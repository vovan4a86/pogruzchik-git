<?php

namespace App\Console\Commands;

use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Char;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\ProductCertificate;
use Fanky\Admin\Models\ProductChar;
use Fanky\Admin\Models\ProductImage;
use Fanky\Admin\Text;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Symfony\Component\DomCrawler\Crawler;
use App\Traits\ParseFunctions;

class ParseSpareMirst extends Command {

    use ParseFunctions;

    protected $signature = 'parse:spare';
    protected $description = 'Парсим сайт gc-mirst';

    private $basePath = ProductImage::UPLOAD_URL . 'gc-mirst/';
    public $baseUrl = 'https://gc-mirst.ru/';
    public $brands = [];

    public $client;

    public function __construct() {
        parent::__construct();
        $this->client = new Client([
            'headers' => ['User-Agent' => Arr::random($this->userAgents)],
        ]);
    }

    public function handle() {
        foreach ($this->categoryList() as $categoryName => $categoryUrl) {
            $this->parseListCategories($categoryName, $categoryUrl, 18);
        }
        $this->info('The command was successful!');
    }

    public function categoryList(): array {
        return [
            'Запчасти и комплектующие для погрузчиков' => 'https://gc-mirst.ru/shop/zapchasti-i-komplektuyuschie/'
        ];
    }

    public function parseListCategories($categoryName, $categoryUrl, $parentId) {
        $this->info('Parse category: ' . $categoryName);
        $catalog = $this->getCatalogByName($categoryName, $parentId);

        try {
            $res = $this->client->get($categoryUrl);
            $html = $res->getBody()->getContents();
            $crawler = new Crawler($html); //products page from url

            //список всех брендов запчастей, чтобы можно было сравнить с именем и добавить в колонку Brand
            if ($catalog->name == 'Запчасти и комплектующие для погрузчиков') {
                if ($crawler->filter('.filternsv_search_param_parent')->count() != 0) {
                    $crawler->filter('.filternsv_search_param_parent')->each(function (Crawler $name) {
                        $this->brands[] = $name->filter('label')->first()->innerText();
                    });
                }
                $this->info('Количество брендов: ' . count($this->brands));
            }

            if ($crawler->filter('ul.catalog__menu')->count() != 0) {
                $crawler->filter('ul.catalog__menu li a')
//                    ->reduce(function (Crawler $none, $i) {
//                        return ($i < 1);
//                    })
                    ->each(function (Crawler $node, $n) use ($catalog) {
                        $categoryNameRaw = $node->text();
                        $categoryName = $this->extractName($categoryNameRaw); //отрезаем количество товаров
                        $categoryUrl = $node->attr('href');
                        $this->parseListCategories($categoryName, $categoryUrl, $catalog->id);
                    });
            } else {
                $this->parseListProduct($catalog->name, $categoryUrl);
            }
        } catch
        (GuzzleException $e) {
            $this->error('Error Parse Category: ' . $e->getMessage());
            $this->error('See: ' . $e->getLine());
        }
    }

    //ДОДЕЛАТЬ ПРОХОД ПО ВСЕМ СТРАНИЦАМ!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    public function parseListProduct($categoryName, $categoryUrl) {
        $this->info('Parse products from: ' . $categoryName);
        $catalog = $this->getCatalogByName($categoryName);

        try {
            $res = $this->client->get($categoryUrl);
            $html = $res->getBody()->getContents();
            $crawler = new Crawler($html); //products page from url

            $uploadPath = $this->basePath . $catalog->slug . '/';

            if ($crawler->filter('.section-d__list.catalogItem__row article')->count() != 0) {
                $crawler->filter('.section-d__list.catalogItem__row article')
                    ->reduce(function (Crawler $none, $i) {
                        return ($i < 1);
                    })
                    ->each(function (Crawler $node, $n) use ($catalog, $categoryName, $categoryUrl, $uploadPath) {
                        $data = [];
                        try {
                            $url = $node->filter('a.item-product-name')->first()->attr('href');
                            $data['name'] = trim($node->filter('a.item-product-name')->first()->text());
                            $data['manufacturer'] = $this->getBrandFromText($data['name']);

                            $this->info(++$n . ') ' . $data['name']);

                            $product = Product::whereParseUrl($url)->first();

                            if (!$product) {
                                $data['h1'] = $data['name'];
                                $data['title'] = $data['h1'];
                                $data['alias'] = Text::translit($data['name']);

                                $productPage = $this->client->get($url);
                                $productHtml = $productPage->getBody()->getContents();
                                $productCrawler = new Crawler($productHtml); //product page

                                $order = $catalog->products()->max('order') + 1;
                                $newProd = Product::create(array_merge([
                                    'catalog_id' => $catalog->id,
                                    'parse_url' => $url,
                                    'published' => 1,
                                    'order' => $order,
                                ], $data));

                                //сохраняем изображения товара
                                $productCrawler->filter('.swiper.itemFull__bigImg .swiper-slide img')->each(function ($img)
                                use ($newProd, $catalog, $uploadPath) {
                                    $imageSrc = $this->baseUrl . $img->attr('src');
                                    $ext = $this->getExtensionFromSrc($imageSrc);
                                    $fileName = md5(uniqid(rand(), true)) . '_' . time() . $ext;
                                    $res = $this->downloadJpgFile($imageSrc, $uploadPath, $fileName);
                                    if ($res) {
                                        ProductImage::create([
                                            'product_id' => $newProd->id,
                                            'image' => $uploadPath . $fileName,
                                            'order' => ProductImage::where('product_id', $newProd->id)->max('order') + 1,
                                        ]);
                                    }
                                });
                            } else {
                                $product->update($data);
                                $product->save();
                            }
                        } catch
                        (\Exception $e) {
                            $this->warn('product create error: ' . $e->getMessage());
                            $this->warn('see line: ' . $e->getLine());
                        }
                    });
            }
        } catch
        (GuzzleException $e) {
            $this->error('Error Parse Product: ' . $e->getMessage());
            $this->error('See: ' . $e->getLine());
        }
    }

    public function getTextFromCharArray(array $chars): ?string {
        if (!count($chars)) return null;

        $res = '<ul class="prod-char">';
        foreach ($chars as $name => $value) {
            $res .= "<li><span class='char-name'>$name</span> - <span class='char-value'>$value</span></li>";
        }
        $res .= '</ul>';
        return $res;
    }

    public function test() {
        $html = file_get_contents(public_path('/test/test.html'));
        $crawler = new Crawler($html); //products page from url

        $crawler->filter('.product-wrapper .item')
//                    ->reduce(function (Crawler $none, $i) {return ($i < 3);})
            ->each(function (Crawler $node, $n) {
                $data = [];
                try {
                    $url = $node->filter('img')->first()->attr('href');
                    $this->info($node->count());
                    exit();
                    $data['name'] = trim($node->filter('h3.woocommerce-loop-product__title')->first()->text());
                    $rawPrice = $node->filter('span.woocommerce-Price-amount.amount')->first()->text();
                    $data['price'] = preg_replace("/[^,.0-9]/", null, $rawPrice);
                    $data['price'] = $this->replaceFloatValue($data['price']);
                    $data['in_stock'] = 1;
                    if (!$data['price']) $data['in_stock'] = 0;

                    $this->info(++$n . ') ' . $data['name']);
                    $product = Product::whereParseUrl($url)->first();
                    $data['h1'] = $data['name'];
                    $data['title'] = $data['name'];
                    $data['alias'] = Text::translit($data['name']);

                    $productPage = $this->client->get($url);
                    $productHtml = $productPage->getBody()->getContents();
                    $productCrawler = new Crawler($productHtml); //product page

                    //описание
                    if ($productCrawler->filter('#tab-description')->first()->count() != 0) {
                        $data['text'] = $productCrawler->filter('#tab-description')->first()->html();
                    }

                    //характеристики
//                    if ($productCrawler->filter('table.woocommerce-product-attributes')->count() != 0) {
//                        $productCrawler->filter('.table.woocommerce-product-attributes tr')->each(function (Crawler $char) {
//                            $name = $char->filter('.woocommerce-product-attributes-item__label')->first()->text();
//                            if ($char->filter('.woocommerce-product-attributes-item__value a')->count() != 0) {
//                                $value = trim($char->filter('.woocommerce-product-attributes-item__value a')->first()->text());
//                            } else {
//                                $value = trim($char->filter('.woocommerce-product-attributes-item__value')->first()->text());
//                            }
//
//                            $this->info($name . ' : ' . $value);
//                        });
//                    }

                } catch (\Exception $e) {
                    $this->warn('error parse product: ' . $e->getMessage());
                    $this->warn('see line: ' . $e->getLine());
                    exit();
                }
            });
    }

    public function getBrandFromText(string $text): string {
        $text = mb_strtoupper($text);
        if($text && count($this->brands)) {
            foreach ($this->brands as $brand) {
                if(mb_strpos($text, mb_strtoupper($brand))) {
                    return $brand;
                }
            }
        }
        return '';
    }

    public function extractName($text) {
        $index = strripos($text, '(');
        return trim(substr($text, 0, $index));
    }

}

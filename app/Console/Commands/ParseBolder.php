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

class ParseBolder extends Command {

    use ParseFunctions;

    protected $signature = 'parse:bolder';
    protected $description = 'Парсим марку Bolder';

    private $basePath = ProductImage::UPLOAD_URL . 'bolder/';
    public $baseUrl = 'https://xn--90agdwop.xn--p1ai/';
    public $brand = 'Bolder';

    public $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->client = new Client([
            'headers' => ['User-Agent' => Arr::random($this->userAgents)],
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        foreach ($this->categoryList() as $parentCatName => $categoryUrl) {
            $this->parseListProduct($this->brand, $categoryUrl, $parentCatName);
        }
        $this->info('The command was successful!');
    }

    public function categoryList(): array {
        return [
            'Вилочные погрузчики' => 'https://xn--90agdwop.xn--p1ai/catalog/forkloaders',
            'Фронтальные погрузчики' => 'https://xn--90agdwop.xn--p1ai/catalog/frontloaders',
            'Экскаваторы' => 'https://xn--90agdwop.xn--p1ai/catalog/excavator',
            'Экскаваторы-погрузчики' => 'https://xn--90agdwop.xn--p1ai/catalog/backhoe',
        ];
    }

    public function parseListProduct($categoryName, $categoryUrl, $parentCatName) {
        $this->info('Parse products from: ' . $parentCatName . ' > ' . $categoryName);
        $parent = $this->getCatalogByName($parentCatName);
        $catalog = $this->getCatalogByName($categoryName, $parent->id);

        try {
            $res = $this->client->get($categoryUrl);
            $html = $res->getBody()->getContents();
            $crawler = new Crawler($html); //products page from url

            $uploadPath = $this->basePath . $catalog->slug . '/';

            if ($crawler->filter('.item')->count() != 0) {
                $crawler->filter('.item')
                    ->reduce(function (Crawler $none, $i) {return ($i < 1);})
                    ->each(function (Crawler $node, $n) use ($catalog, $categoryUrl, $uploadPath) {
                        $data = [];
                        try {
                            $model = trim($node->filter('span.model')->first()->text());
                            $url = $categoryUrl . '/' . $model;
                            $data['name'] = $model;
                            $data['manufacturer'] = $this->brand;

                            $this->info(++$n . ') ' . $data['name']);

                            $product = Product::whereParseUrl($url)->first();

                            if (!$product) {
                                $data['h1'] = 'Bolder ' . $model;
                                $data['title'] = $data['h1'];
                                $data['alias'] = Text::translit($model);

                                $productPage = $this->client->get($url);
                                $productHtml = $productPage->getBody()->getContents();
                                $productCrawler = new Crawler($productHtml); //product page

                                //характеристики
                                $c = $productCrawler->filter('.char-list')->count();// <- все характеристики
                                $text = '';
                                if ($c > 0) {
                                    $productCrawler->filter('.char-list')->each(function (Crawler $row) use (&$text) {
                                        //заголовок
                                        if ($row->filter('.char-group-title')->count() > 0) {
                                            $text .= '<h3><strong>' . $row->filter('.char-group-title')->first()->text() . '</strong></h3>';
                                        }
                                        //название: значение
                                        if ($row->filter('.char-group-item')->count() > 0) {
                                            $text .= '<p>' . $row->filter('.char-group-item .name')->first()->text() . ': ' .
                                                $row->filter('.char-group-item .value')->first()->text() . '</p>';
                                        }
                                    });
                                }
                                $data['text'] = $text;

                                $order = $catalog->products()->max('order') + 1;
                                $newProd = Product::create(array_merge([
                                    'catalog_id' => $catalog->id,
                                    'parse_url' => $url,
                                    'published' => 1,
                                    'order' => $order,
                                ], $data));

                                //сохраняем изображения товара
                                $productCrawler->filter('.slider-image')->each(function ($img)
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

}

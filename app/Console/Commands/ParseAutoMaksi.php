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

class ParseAutoMaksi extends Command {

    use ParseFunctions;

    protected $signature = 'parse:good';
    protected $description = 'Парсим сайт automaksicars.ru';

    private $basePath = ProductImage::UPLOAD_URL . 'auto/';
    public $baseUrl = 'https://automaksicars.ru';
    public $brand = '';

    public $client;

    public function __construct() {
//        $resource = fopen(public_path($this->basePath . '/pdf/' . '1.pdf'), 'w');
//        $g = new \GuzzleHttp\Client;
//
//        $response = $g->get("https://automaksicars.ru/catalog/cat/elektricheskie-pogruzchiki-cat/item/download/167_72b70b1958e5488834e4d0a287d977c4", [
//            'sink' => $resource
//        ]);
//        exit();

        parent::__construct();
        $this->client = new Client([
            'headers' => ['User-Agent' => Arr::random($this->userAgents)],
        ]);
    }

    public function handle() {

        foreach ($this->categoryList() as $name => $categoryUrl) {
            [$this->brand, $categoryName] = explode('|', $name);
            $cat = $this->getCatalogByName($this->brand, 3);
            $this->parseListProduct($categoryName, $categoryUrl, $cat->id);
        }

        foreach ($this->categoryListRecurse() as $name => $categoryUrl) {
            [$this->brand, $parentCat, $categoryName] = explode('|', $name);
            $catBrand = $this->getCatalogByName($this->brand, 3);
            $parent = $this->getCatalogByName($parentCat, $catBrand->id);
            $this->parseListProduct($categoryName, $categoryUrl, $parent->id);
        }
        $this->info('The command was successful!');
    }

    public function categoryList(): array {
        return [
//            'Goodsense|Дизельные погрузчики' => 'https://automaksicars.ru/catalog/goodsense/dizelnye-pogruzchiki-goodsense',
//            'Goodsense|Газ/бензиновые погрузчики' => 'https://automaksicars.ru/catalog/goodsense/gaz-benzinovye-pogruzchiki-goodsense',
//            'Goodsense|Электрические погрузчики' => 'https://automaksicars.ru/catalog/goodsense/elektricheskie-pogruzchiki-goodsense',
//            'Goodsense|Большегрузные погрузчики' => 'https://automaksicars.ru/catalog/goodsense/bolshegruznye-pogruzchiki-goodsense',
//            'Goodsense|Внедорожные погрузчики' => 'https://automaksicars.ru/catalog/goodsense/vnedorozhnye-pogruzchiki-goodsense',

//            'Heli|Дизельные погрузчики' => 'https://automaksicars.ru/catalog/heli/dizelnye-pogruzchiki-heli',
//            'Heli|Газ/бензиновые погрузчики' => 'https://automaksicars.ru/catalog/heli/gazbenzinovye-pogruzchiki-heli',
//            'Heli|Дизельные повышенной проходимости' => 'https://automaksicars.ru/catalog/heli/dizelnye-pogruzchiki-povyshennoj-prokhodimosti-heli',

//            'Heli|Ричтраки' => 'https://automaksicars.ru/catalog/richtraki-heli',

            'TCM|Ричтраки' => 'https://automaksicars.ru/catalog/richtraki-heli',


        ];
    }

    public function categoryListRecurse(): array {
        return [
//            'Cat|Электропогрузчики|3х опорные 1,4-2,0 тонны 48V' => 'https://automaksicars.ru/catalog/cat/elektricheskie-pogruzchiki-cat/itemlist/category/91-elektropogruzchiki-3kh-opornye-1-4-2-0-t-48v',
//            'Cat|Электропогрузчики|4х опорные 1,4-2,0 тонны 48V' => 'https://automaksicars.ru/catalog/cat/elektricheskie-pogruzchiki-cat/itemlist/category/92-elektropogruzchiki-4kh-opornye-1-4-2-0-t-48v',
//            'Cat|Электропогрузчики|4х опорные 2,5 - 3,5 тонны 80V' => 'https://automaksicars.ru/catalog/cat/elektricheskie-pogruzchiki-cat/itemlist/category/93-elektropogruzchiki-4kh-opornye-2-5-3-5t-80v',
//            'Cat|Электропогрузчики|4х опорные 4,0 - 5,0 тонны 80V' => 'https://automaksicars.ru/catalog/cat/elektricheskie-pogruzchiki-cat/itemlist/category/94-elektropogruzchiki-4kh-opornye-4-0-5-0t-80v',
//
//            'Cat|Дизельные погрузчики|1,5-3,5 тонны' => 'https://automaksicars.ru/catalog/cat/dizelnye-pogruzchiki-cat/itemlist/category/95-dizelnye-pogruzchiki-1-5-3-5t',
//            'Cat|Дизельные погрузчики|4,0-5,5 тонны' => 'https://automaksicars.ru/catalog/cat/dizelnye-pogruzchiki-cat/itemlist/category/96-dizelnye-pogruzchiki-4-0-5-5t',
//            'Cat|Дизельные погрузчики|7,0-10,0 тонны' => 'https://automaksicars.ru/catalog/cat/dizelnye-pogruzchiki-cat/itemlist/category/97-dizelnyj-pogruzchik-7-0t',
//            'Cat|Дизельные погрузчики|10,0-15,0 тонны' => 'https://automaksicars.ru/catalog/cat/dizelnye-pogruzchiki-cat/itemlist/category/99-dizelnye-pogruzchiki-10-0-15-0t',
//
//            'Cat|Бензиновые погрузчики|1,5-3,5 тонны' => 'https://automaksicars.ru/catalog/cat/gaz-benzinovye-pogruzchiki-cat/itemlist/category/100-gaz-benzinovye-pogruzchiki-1-5-3-5-t',
//            'Cat|Бензиновые погрузчики|4,0-5,5 тонны' => 'https://automaksicars.ru/catalog/cat/gaz-benzinovye-pogruzchiki-cat/itemlist/category/101-gaz-benzinovye-pogruzchiki-4-0-5-5-t',

//            'Heli|Электропогрузчики|3-х опорные' => 'https://automaksicars.ru/catalog/heli/elektropogruzchiki-heli/itemlist/category/107-elektropogruzchiki-heli-3-kh-opornye',
//            'Heli|Электропогрузчики|4-х опорные' => 'https://automaksicars.ru/catalog/heli/elektropogruzchiki-heli/itemlist/category/108-elektropogruzchiki-heli-4-kh-opornye',
//            'Heli|Электропогрузчики|с литий-ионной АКБ' => 'https://automaksicars.ru/catalog/heli/elektropogruzchiki-heli/itemlist/category/109-elektropogruzchiki-heli-s-litij-ionnoj-akb',
        ];
    }

    public function parseListCategories($categoryName, $categoryUrl, $parentId) {
        $this->info('Parse category: ' . $categoryName);
        $catalog = $this->getCatalogByName($categoryName, $parentId);

        try {
            $res = $this->client->get($categoryUrl);
            $html = $res->getBody()->getContents();
            $crawler = new Crawler($html); //products page from url

            if ($crawler->filter('.itemContainer.itemContainerLast')->count() != 0) {
                $crawler->filter('.itemContainer.itemContainerLast')
//                    ->reduce(function (Crawler $none, $i) {
//                        return ($i < 1);
//                    })
                    ->each(function (Crawler $node, $n) use ($catalog) {
                        $categoryName = trim($node->filter('.catItemTitle a')->first()->text());
                        $categoryUrl = $node->filter('.catItemTitle a')->first()->attr('href');
                        $this->parseListProduct($categoryName, $categoryUrl, $catalog->id);
                    });
            }
        } catch (GuzzleException $e) {
            $this->error('Error Parse Category: ' . $e->getMessage());
            $this->error('See: ' . $e->getLine());
        }
    }

    public function parseListProduct($categoryName, $categoryUrl, $parentId) {
        $this->info('Parse products from: ' . $categoryName);
        $catalog = $this->getCatalogByName($categoryName, $parentId);

        try {
            $res = $this->client->get($categoryUrl);
            $html = $res->getBody()->getContents();
            $crawler = new Crawler($html); //products page from url

            $uploadPath = $this->basePath . $catalog->slug . '/';

            if ($crawler->filter('.itemContainer.itemContainerLast')->count() != 0) {
                $crawler->filter('.itemContainer.itemContainerLast')
                    ->reduce(function (Crawler $none, $i) {
                        return ($i < 1);
                    })
                    ->each(function (Crawler $node, $n) use ($catalog, $categoryName, $categoryUrl, $uploadPath) {
                        $data = [];
                        try {
                            $url = $this->baseUrl . $node->filter('.catItemTitle a')->first()->attr('href');
                            $nameRaw = trim($node->filter('.catItemTitle a')->first()->text());
//                            $data['name'] = $this->getOnlyModelFromName($nameRaw, strtoupper($this->brand));
                            $data['name'] = $nameRaw;
                            $data['manufacturer'] = $this->brand;

                            $this->info(++$n . ') ' . $data['name']);

                            $product = Product::whereParseUrl($url)->first();

                            if (!$product) {
                                $data['h1'] = $data['name'];
                                $data['title'] = $data['h1'];
                                $data['alias'] = Text::translit($data['name']);

                                $productPage = $this->client->get($url);
                                $productHtml = $productPage->getBody()->getContents();
                                $productCrawler = new Crawler($productHtml); //product page

                                //текст и хар-ки
                                $c = $productCrawler->filter('.itemFullText')->first()->count();// <- все характеристики
                                if ($c > 0) {
                                    $data['text'] = $productCrawler->filter('.itemFullText')->first()->html();
                                }


                                //pdf файл есть не у всех
                                $uploadPathPdf = $this->basePath . 'pdf/';
                                $fileName = $data['alias'] . '_' . time() . '.pdf';
                                $c = $productCrawler->filter('ul.itemAttachments')->first()->count();// <- все характеристики
                                $data['pdf'] = null;
                                if ($c > 0) {
                                    $url = $this->baseUrl . $productCrawler->filter('ul.itemAttachments li a')
                                            ->first()->attr('href');
                                    $data['pdf'] = $this->downloadPdfFile($url, $uploadPathPdf, $fileName);
                                }

                                $order = $catalog->products()->max('order') + 1;
                                $newProd = Product::create(array_merge([
                                    'catalog_id' => $catalog->id,
                                    'parse_url' => $url,
                                    'published' => 1,
                                    'order' => $order,
                                ], $data));

                                //сохраняем изображения товара
                                $productCrawler->filter('.itemImageBlock .itemImage img')->each(function ($img)
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
        } catch (GuzzleException $e) {
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

    public function getOnlyModelFromName(string $name, string $searchStr) {
        $index = strripos($name, $searchStr);
        return substr($name, $index + strlen($searchStr) + 1);
    }

}

<?php

namespace App\Console\Commands;

use App\Traits\ParseSsr;
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

class ParseLiftNet extends Command {

    use ParseFunctions, ParseSsr;

    protected $signature = 'parse:lift';
    protected $description = 'Парсим сайт liftnet.ru';

    private $basePath = ProductImage::UPLOAD_URL . 'lift/';
    public $baseUrl = 'https://www.liftnet.ru';
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
//        $items = $this->getInfoFromPage('https://www.liftnet.ru/katalog/vilochnye-pogruzchiki/hyundai/');
//        if($items) {
//            foreach ($items as $n => $item) {
//                $this->info(++$n . ') ' . $item->brand . ': ' . $item->name . ' => ' . $item->url);
//            }
//        } else {
//            $this->info('none');
//        }
//        exit();

        foreach ($this->categoryVilochnie() as $name => $categoryUrl) {
            $cat = $this->getCatalogByName($name, 3); //id3 - вилочные погрузчики
            $this->parseListProductFromSsr($cat, $categoryUrl);
        }

        $this->info('The command was successful!');
    }

    public function categoryVilochnie(): array {
        return [
//            'Hyundai' => 'https://www.liftnet.ru/katalog/vilochnye-pogruzchiki/hyundai/',
//            'TRF' => 'https://www.liftnet.ru/katalog/vilochnye-pogruzchiki/trf/',
//            'Dalian' => 'https://www.liftnet.ru/katalog/vilochnye-pogruzchiki/dalian/',
            'TCM' => 'https://www.liftnet.ru/katalog/vilochnye-pogruzchiki/tcm/',
        ];
    }

    public function parseListCategoriesSsr($categoryName, $categoryUrl, $parentId) {
        $this->info('Parse category: ' . $categoryName);
        $catalog = $this->getCatalogByName($categoryName, $parentId);

        try {

        } catch (GuzzleException $e) {
            $this->error('Error Parse Category: ' . $e->getMessage());
            $this->error('See: ' . $e->getLine());
        }
    }

    public function parseListProductFromSsr($catalog, $categoryUrl) {
        $this->info('Parse SSR category: ' . $catalog->name);
        $uploadPath = $this->basePath . $catalog->slug . '/';

        try {
            $products_list = $this->getInfoFromPage($categoryUrl);

            if($products_list) {
                foreach ($products_list as $n => $item) {
                    $this->info(++$n . ') ' . $item->name);
                    $data = [];
                    $url = $item->url;
                    $data['name'] = $item->name;
                    $data['manufacturer'] = $item->brand;

                    $product = Product::whereParseUrl($url)->first();
                    if (!$product) {
                        $data['h1'] = $data['name'];
                        $data['title'] = $data['h1'];
                        $data['alias'] = Text::translit($data['name']);

                        $productPage = $this->client->get($url);
                        $productHtml = $productPage->getBody()->getContents();
                        $productCrawler = new Crawler($productHtml); //product page

                        //описание
                        $c = $productCrawler->filter('#pane-desc .el-tabs__content-description')->count();
                        if ($c > 0) {
                            $data['text'] = $productCrawler->filter('#pane-desc .el-tabs__content-description')->first()->html();
                        }

                        //хар-ки
                        $c = $productCrawler->filter('#pane-attr')->count();
                        $chars = '';
                        if ($c > 0) {
                            $productCrawler->filter('#pane-attr .single-product__attributes-item')
                                ->each(function(Crawler $char) use (&$chars) {
                                    $name = $char->filter('.single-product__attributes-label')->first()->text();
                                    $value = $char->filter('.single-product__attributes-value')->first()->text();
                                    $chars .= '<p>' . $name . ': ' . $value . '</p>';
                                });
                        }
                        $data['chars_text'] = $chars;

                        $order = $catalog->products()->max('order') + 1;
                        $newProd = Product::create(array_merge([
                            'catalog_id' => $catalog->id,
                            'parse_url' => $url,
                            'published' => 1,
                            'order' => $order,
                        ], $data));

                        //сохраняем изображения товара !!!!!!!качаем из preview
                        $this->info('count img: ' . $productCrawler->filter('.swiper-wrapper')->count());
                        $productCrawler->filter('.v-picture img')->each(function ($img)
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
                    exit();
                }
            }
        }
        catch (GuzzleException $e) {
            $this->error('Error Parse SSR Category: ' . $e->getMessage());
            $this->error('See: ' . $e->getLine());
        }
    }

    public function parseListProduct($categoryName, $categoryUrl, $parentId) {
        $this->info('Parse products from: ' . $categoryName);
        $catalog = $this->getCatalogByName($categoryName, 3);

        try {
            $res = $this->client->get($categoryUrl);
            $html = $res->getBody()->getContents();
            $crawler = new Crawler($html); //products page from url

            $uploadPath = $this->basePath . $catalog->slug . '/';

            $this->info($crawler->filter('.product-card')->count());
            exit();

            if ($crawler->filter('.product-card')->count() != 0) {
                $crawler->filter('.product-card')
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

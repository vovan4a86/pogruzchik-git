<?php

namespace App\Console\Commands;

use App\CraneSpare;
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

class CraneSpares extends Command
{

    use ParseFunctions;

    protected $signature = 'crane';
    protected $description = 'Парсим Crane Spares';

    private $basePath = ProductImage::UPLOAD_URL . 'crane-spare/';
    public $baseUrl = 'https://www.crane-spares.com';
    protected $dictionary = [
//        'Accumulator' => 'Аккумулятор', //0

//        'Booster Assy' => 'Усилитель в сборе', //1
//        'Brake Valve Repair Kit' => 'Комплект для ремонта тормозного клапана',
//        'Clutch Booster Assy' => 'Усилитель сцепления в сборе',
//        'Clutch Booster Repair Kit' => 'Ремкомплект усилителя сцепления',
//        'Gearshift Servo Repair Kit' => 'Комплект для ремонта сервопривода переключения передач',
//        'Power Steering Repair Kit' => 'Комплект для ремонта гидроусилителя руля',
//        'Relay Valve' => 'Релейный клапан',
//        'Repair Kit' => 'Комплект для ремонта',

        'Swing Brake Pad' => 'Поворотная тормозная колодка', //2
        'Brake Pad' => 'Тормозная колодка',

        'Brake Valve Repair Kit' => 'Комплект для ремонта тормозных клапанов', //3
        'Throttle Valve Repair Kit' => 'Ремонтный комплект дроссельного клапана',
        'Brake Valve' => 'Тормозной клапан',
        'Throttle Valve' => 'Дроссельный клапан',

        'Caliper Seal Kit' => 'Комплект уплотнений суппорта', //4

        'Pressure Plate Assy' => 'Прижимная пластина в сборе', //5
        'Clutch Disc' => 'Диск сцепления',

        'Brake Cylinder Repair Kit' => 'Комплект для ремонта тормозного цилиндра', //6
        'Control Cylinder Assy' => 'Цилиндр управления в сборе',
        'Exhaust Brake Cylinder' => 'Выпускной тормозной цилиндр',
        'Winch Brake Cylinder' => 'Тормозной цилиндр лебедки',
        'Cylinder Assy' => 'Цилиндр в сборе',
        'Wheel Cylinder' => 'Колесный цилиндр',
        'Master Cylinder' => 'Главный цилиндр',
        'Power Cylinder' => 'Силовой цилиндр',
        'Throttle Cylinder' => 'Дроссельный цилиндр',
        'Air Cylinder' => 'Воздушный цилиндр',
        'Brake Cylinder' => 'Тормозной цилиндр',
        'Cylinder Repair Kit' => 'Ремонтный комплект для цилиндра',
        'Clutch Cylinder' => 'Цилиндр сцепления',

        'Diesel Hammer Cushion Rubber' => 'Резиновая подушка дизельного молота', //7
        'Diesel Hammer Fuel Pump' => 'Топливный насос дизельного молота',
        'Diesel Hammer Grease Nipple' => 'Ниппель для смазки дизельного молота',
        'Diesel Hammer Guide Ring' => 'Направляющее кольцо дизельного молота',
        'Diesel Hammer Piston Assy' => 'Поршень дизельного молота в сборе',
        'Diesel Hammer Piston Ring' => 'Поршневое кольцо дизельного молота',

        'Contact Relay' => 'Контактное реле', //8
        'Operator Cabin Fan' => 'Вентилятор кабины оператора',
        'DC Converter' => 'Преобразователь постоянного тока',
        'Surge Protector' => 'Устройство защиты от перепадов напряжения',
        'Starter Switch' => 'Переключатель стартера',
        'Battery Relay' => 'Реле батареи',
        'Brush Holder' => 'Держатель щетки',
        'Engine Stop Solenoid' => 'Соленоид остановки двигателя',
        'Control Unit Assy' => 'Блок управления в сборе',
        'Solenoid Assy' => 'Соленоид в сборе',
        'Rectifier' => 'Выпрямитель',
        'Regulator' => 'Регулятор',
        'Alternator' => 'Генератор',
        'Relay' => 'Реле',
        'Starter' => 'Стартер',

        'Air Pressure Switch' => 'Реле давления воздуха', //9
        'AV Sensor' => 'Датчик AV',
        'Element Generator' => 'Генератор элементов',
        'EPROM' => 'ППЗУ',
        'LCD' => 'ЖК-Дисплей',
        'Moment Limiter' => 'Ограничитель момента',
        'Oil Pressure Sensor' => 'Датчик давления масла',
        'Optical Reel Cord' => 'Оптический шнур катушки',
        'Optical Cable' => 'Оптический кабель',
        'Optical Cord' => 'Оптический шнур',
        'Panel Switch' => 'Панельный переключатель',
        'Potentio Meter' => 'Измеритель потенциала',
        'Pressure Sensor' => 'Датчик давления',
        'Print Plate' => 'Печатная плата',
        'Proximity Switch' => 'Бесконтактный переключатель',
        'Reel Cord' => 'Катушка шнура',
        'Rotary Brush' => 'Роторная щетка',
        'Sensor L Theta' => 'Датчик L Тета',
        'Sensor Load' => 'Датчик нагрузки',
        'Sensor Stroke' => 'Датчик хода',
        'Switch Assy' => 'Переключатель в сборе',
        'Switch' => 'Переключатель',
        'Switch Box' => 'Распределительная коробка',
        'Angle Sensor' => 'Датчик угла поворота',
        'IC Servo' => 'Сервопривод IC',
        'Outrigger Sensor' => 'Датчик аутриггера',
        'Panel Cover' => 'Крышка панели',
        'Sensor' => 'Датчик',
        'Load Cell' => 'Датчик нагрузки',
        'Load Indicator' => 'Индикатор нагрузки',
        'Accelerator Sensor' => 'Датчик акселератора',
        'Pick Up Sensor' => 'Датчик подхвата',
        'Swing Regulator Assy' => 'Регулятор поворота в сборе',
        'Transistor' => 'Транзистор',
        'Cord Assy' => 'Шнур в сборе',
        'Controller SPL' => 'Контроллер SPL',
        'Display Panel' => 'Панель дисплея',
        'Limit Switch' => 'Концевой переключатель',
        'Reel Cord Drum Assy' => 'Барабан шнура катушки в сборе',
        'Sender Pressure' => 'Давление отправителя',
        'Transmitter Multiplex Data' => 'Передатчик мультиплексных данных',
        'Telescopic Wire' => 'Телескопический провод',



    ];
    public $brand = 'Crane Spare';

    //Запчасти для крановой техники
    protected $dictionaryCatalog = [
//        'Accumulators' => 'Аккумуляторы',
//        'Booster Assy' => 'Усилитель в сборе'
        'Brake Pads' => 'Тормозные колодки',
        'Brake Valves' => 'Тормозные клапаны',
        'Caliper Seal Kits' => 'Комплекты уплотнений суппорта',
        'Clutch Discs' => 'Диски сцепления',
        'Cylinder Assy' => 'Цилиндр в сборе',
        'Diesel Hammer Parts' => 'Запчасти для дизельных молотов',
        'Electrical Items' => 'Электрические детали',
        'Electronics Components' => 'Компоненты электроники',
        'Engine Fans' => 'Вентиляторы двигателя',
        'Engine Filters' => 'Фильтры двигателя',
        'Engine Mountings' => 'Крепления двигателя',
        'Friction Plates' => 'Фрикционные накладки',
        'Fuel Feed Pumps' => 'Насосы подачи топлива',
        'Gear Sets' => 'Наборы шестерен',
        'Grove Crane Parts' => 'Запчасти для кранов Grove',
        'Hino Engine Parts' => 'Запчасти для двигателей Hino',
        'Hitachi Crane Parts' => 'Запчасти для кранов Hitachi',
        'Hoses' => 'Шланги',
        'Hydraulic Filters' => 'Гидравлические фильтры',
        'Hydraulic Motors' => 'Гидравлические моторы',
        'Hydraulic Pumps' => 'Гидравлические насосы',
        'Hydraulic Seal Kits' => 'Комплекты гидравлических уплотнений',
        'Hydraulic Valves' => 'Гидравлические клапаны',
        'Isuzu Engine Parts' => 'Запчасти для двигателей Isuzu',
        'Kato Crane Parts' => 'Запчасти для кранов Kato',
        'Kobelco Crane Parts' => 'Запчасти для кранов Kobelco',
        'Level Gauges' => 'Уровнемеры',
        'Magnetic Valves' => 'Магнитные клапаны',
        'Meter Gauges' => 'Измерительные манометры',
        'Miscellaneous Items' => 'Разное',
        'Mitsubishi Engine Parts' => 'Запчасти для двигателей Mitsubishi',
        'Nissan Engine Parts' => 'Запчасти для двигателей Nissan',
        'Oil Pumps' => 'Масляные насосы',
        'P&H Crane Parts' => 'Запчасти кранов P&H',
        'P&H Omega Crane Parts' => 'Запчасти для кранов P&H Omega',
        'Power Steering Cartridges' => 'Картриджи гидроусилителя руля',
        'Safety Devices' => 'Устройства безопасности',
        'Shafts' => 'Валы',
        'Solenoid Valves' => 'Соленоидные клапаны',
        'Sprockets' => 'Звездочки',
        'Steering Pumps' => 'Рулевые насосы',
        'Sumitomo Crane Parts' => 'Детали кранов Sumitomo',
        'Super Structure' => 'Суперструктура',
        'Swing Bearings' => 'Поворотные подшипники',
        'Swivel Joints' => 'Шарнирные соединения',
        'Tadano Crane Parts' => 'Запчасти для кранов Tadano',
        'Track Chains' => 'Гусеничные цепи',
        'Track Rollers' => 'Гусеничные ролики',
        'Track Shoes' => 'Гусеничные башмаки',
        'Turbo Chargers' => 'Турбозарядные устройства',
        'Valve Assy' => 'Узел клапана',
        'Water Pumps' => 'Водяные насосы',
    ];

    public $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client(
            [
                'headers' => ['User-Agent' => Arr::random($this->userAgents)],
            ]
        );
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $name = 'Brake Valve Repair Kit';
//        echo $name == 'Brake Valve Repair Kit' ? 'true' : 'false';
//        echo $this->tryToTranslate($name);

        $this->parseAllCategories('https://www.crane-spares.com/catalog/products/');
        $this->info('The command was successful!');
    }

    public function tryToTranslate($name) {
        foreach ($this->dictionary as $word => $translate) {
            if ($name == $word) {
                $this->info('here');
                return $this->dictionary[$name];
            } else {
                if (stripos($name, $word)) {
                    $clear = trim(str_replace($word, '', $name));
                    return $translate . ' ' . $clear;
                }
            }
        }
    }

    public function tryToTranslateCatalog($text): string {
        try {
            return $this->dictionaryCatalog[$text];
        } catch (\Exception $e) {
            $this->error('Cant translate catalog name');
        }

    }

    public function categoryList(): array
    {
        return [
            'Вилочные погрузчики' => 'https://xn--90agdwop.xn--p1ai/catalog/forkloaders',
        ];
    }

    public function parseAllCategories($categoryUrl)
    {
        $this->info('start parsing all');
        try {
            $res = $this->client->get($categoryUrl);
            $html = $res->getBody()->getContents();
            $sectionCrawler = new Crawler($html); //page from url

            $sectionCrawler->filter('.part ul.content-list li a')
                ->reduce(
                    function (Crawler $none, $i) {
                        //0 - Acc
                        //1 - Booster Assy
                        return ($i == 1);
                    }
                )
                ->each(
                    function (Crawler $sectionInnerCrawler) {
                        $url = $this->baseUrl . $sectionInnerCrawler->attr('href');
                        $section_name = trim($sectionInnerCrawler->text());

                        if ($url && $section_name) {
                            $this->parseProducts($section_name, $url);
                        }
                    }
                );
        } catch (GuzzleException $e) {
            $this->error('Error parse all: ' . $e->getMessage());
        }
    }

    public function parseProducts($categoryName, $categoryUrl)
    {
        $this->info('Parse products from: ' . $categoryName);
        $catalog = $this->getCatalogByName($categoryName);
        $cat_translate = $this->tryToTranslateCatalog($catalog->name);

        $res = $this->client->get($categoryUrl);
        $html = $res->getBody()->getContents();
        $crawler = new Crawler($html); //category page from url

        $uploadPath = $this->basePath . $catalog->slug . '/';

        if ($crawler->filter('#product_cell li')->count() != 0) {
            $crawler->filter('#product_cell li')
                ->reduce(
                    function (Crawler $none, $i) {
//                        return ($i < 1);
                    }
                )
                ->each(
                    function (Crawler $node, $n) use ($catalog, $categoryUrl, $uploadPath, $cat_translate) {
                        $data = [];
                        try {
                            $raw_article = trim($node->filter('.bam-span')->first()->text());
                            $data['name'] = trim($node->filter('.bam-span span')->first()->text());
                            $data['articul'] = $this->clearTextArticul($raw_article, $data['name']);
                            $data['translate'] = $this->tryToTranslate($data['name']);
                            $data['cat_translate'] = $cat_translate;

                            $this->info(++$n . ') ' . $data['name']);

                            $this->info($data['articul']);
                            $this->info($data['name']);
                            $this->info($data['translate']);

                            $product = CraneSpare::where('articul', $data['articul'])->first();

                            if (!$product) {
                                CraneSpare::create(
                                    array_merge(
                                        [
                                            'cat_root' => 'Запчасти для крановой техники',
                                            'cat_child' => 'Crane Spares',
                                            'cat_grandchild' => $catalog->name,
                                        ],
                                        $data
                                    )
                                );

                                //сохраняем изображения товара
                                $image_url = $node->filter('img')->first()->attr('src');
                                $ext = $this->getExtensionFromSrc($image_url);
                                $filename = $data['articul'] . $ext;
                                $this->downloadJpgFile($image_url, $uploadPath, $filename);
                            } else {
                                $product->update($data);
                            }
                        } catch
                        (\Exception $e) {
                            $this->warn('product create error: ' . $e->getMessage());
                            $this->warn('see line: ' . $e->getLine());
                        }
                    }
                );
        }
    }

    public function getTextFromCharArray(array $chars): ?string
    {
        if (!count($chars)) {
            return null;
        }

        $res = '<ul class="prod-char">';
        foreach ($chars as $name => $value) {
            $res .= "<li><span class='char-name'>$name</span> - <span class='char-value'>$value</span></li>";
        }
        $res .= '</ul>';
        return $res;
    }

    public function clearTextArticul($text, $name) {
        return str_replace($name, '', $text);
    }

    public function test()
    {
        $html = file_get_contents(public_path('/test/test.html'));
        $crawler = new Crawler($html); //products page from url

        $crawler->filter('.product-wrapper .item')
//                    ->reduce(function (Crawler $none, $i) {return ($i < 3);})
            ->each(
                function (Crawler $node, $n) {
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
                        if (!$data['price']) {
                            $data['in_stock'] = 0;
                        }

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
                }
            );
    }

}

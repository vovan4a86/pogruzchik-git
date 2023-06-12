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

//        'Swing Brake Pad' => 'Поворотная тормозная колодка', //2
//        'Brake Pad' => 'Тормозная колодка',

//        'Brake Valve Repair Kit' => 'Комплект для ремонта тормозных клапанов', //3
//        'Throttle Valve Repair Kit' => 'Ремонтный комплект дроссельного клапана',
//        'Brake Valve' => 'Тормозной клапан',
//        'Throttle Valve' => 'Дроссельный клапан',

//        'Caliper Seal Kit' => 'Комплект уплотнений суппорта', //4 *

//        'Pressure Plate Assy' => 'Прижимная пластина в сборе', //5
//        'Clutch Disc' => 'Диск сцепления',

//        'Brake Cylinder Repair Kit' => 'Комплект для ремонта тормозного цилиндра', //6
//        'Control Cylinder Assy' => 'Цилиндр управления в сборе',
//        'Exhaust Brake Cylinder' => 'Выпускной тормозной цилиндр',
//        'Winch Brake Cylinder' => 'Тормозной цилиндр лебедки',
//        'Cylinder Assy' => 'Цилиндр в сборе',
//        'Wheel Cylinder' => 'Колесный цилиндр',
//        'Master Cylinder' => 'Главный цилиндр',
//        'Power Cylinder' => 'Силовой цилиндр',
//        'Throttle Cylinder' => 'Дроссельный цилиндр',
//        'Air Cylinder' => 'Воздушный цилиндр',
//        'Brake Cylinder' => 'Тормозной цилиндр',
//        'Cylinder Repair Kit' => 'Ремонтный комплект для цилиндра',
//        'Clutch Cylinder' => 'Цилиндр сцепления',

//        'Diesel Hammer Cushion Rubber' => 'Резиновая подушка дизельного молота', //7
//        'Diesel Hammer Fuel Pump' => 'Топливный насос дизельного молота',
//        'Diesel Hammer Grease Nipple' => 'Ниппель для смазки дизельного молота',
//        'Diesel Hammer Guide Ring' => 'Направляющее кольцо дизельного молота',
//        'Diesel Hammer Piston Assy' => 'Поршень дизельного молота в сборе',
//        'Diesel Hammer Piston Ring' => 'Поршневое кольцо дизельного молота',

//        'Contact Relay' => 'Контактное реле', //8
//        'Operator Cabin Fan' => 'Вентилятор кабины оператора',
//        'DC Converter' => 'Преобразователь постоянного тока',
//        'Surge Protector' => 'Устройство защиты от перепадов напряжения',
//        'Starter Switch' => 'Переключатель стартера',
//        'Battery Relay' => 'Реле батареи',
//        'Brush Holder' => 'Держатель щетки',
//        'Engine Stop Solenoid' => 'Электромагнит остановки двигателя',
//        'Control Unit Assy' => 'Блок управления в сборе',
//        'Solenoid Assy' => 'Электромагнит в сборе',
//        'Rectifier' => 'Выпрямитель',
//        'Regulator' => 'Регулятор',
//        'Alternator' => 'Генератор',
//        'Relay' => 'Реле',
//        'Starter' => 'Стартер',
//        'Switch Assy' => 'Переключатель в сборе',
//        'Switch' => 'Переключатель',

//        'Air Pressure Switch' => 'Реле давления воздуха', //9
//        'AV Sensor' => 'Датчик AV',
//        'Element Generator' => 'Генератор элементов',
//        'Moment Limiter' => 'Ограничитель момента',
//        'Oil Pressure Sensor' => 'Датчик давления масла',
//        'Optical Reel Cord' => 'Оптический шнур катушки',
//        'Optical Cable' => 'Оптический кабель',
//        'Optical Cord' => 'Оптический шнур',
//        'Panel Switch' => 'Панельный переключатель',
//        'Potentio Meter' => 'Измеритель потенциала',
//        'Pressure Sensor' => 'Датчик давления',
//        'Print Plate' => 'Печатная плата',
//        'Proximity Switch' => 'Бесконтактный переключатель',
//        'Reel Cord' => 'Катушка шнура',
//        'Rotary Brush' => 'Роторная щетка',
//        'Sensor L Theta' => 'Датчик L Тета',
//        'Sensor Load' => 'Датчик нагрузки',
//        'Sensor Stroke' => 'Датчик хода',
//        'Switch Assy' => 'Переключатель в сборе',
//        'Switch Box' => 'Распределительная коробка',
//        'Angle Sensor' => 'Датчик угла поворота',
//        'IC Servo' => 'Сервопривод IC',
//        'Outrigger Sensor' => 'Датчик аутриггера',
//        'Panel Cover' => 'Крышка панели',
//        'Load Cell' => 'Датчик нагрузки',
//        'Load Indicator' => 'Индикатор нагрузки',
//        'Accelerator Sensor' => 'Датчик акселератора',
//        'Pick Up Sensor' => 'Датчик подхвата',
//        'Swing Regulator Assy' => 'Регулятор поворота в сборе',
//        'Cord Assy' => 'Шнур в сборе',
//        'Controller SPL' => 'Контроллер SPL',
//        'Display Panel' => 'Панель дисплея',
//        'Limit Switch' => 'Концевой переключатель',
//        'Reel Cord Drum Assy' => 'Барабан шнура катушки в сборе',
//        'Sender Pressure' => 'Давление отправителя',
//        'Transmitter Multiplex Data' => 'Передатчик мультиплексных данных',
//        'Telescopic Wire' => 'Телескопический провод',
//        'EPROM' => 'ППЗУ',
//        'Sensor' => 'Датчик',
//        'Transistor' => 'Транзистор',
//        'Switch' => 'Переключатель',
//        'LCD' => 'ЖК-Дисплей',

//          'Fan Assy' => 'Вентилятор в сборе', //10
//          'Engine Fan' => 'Вентилятор двигателя',

//          'Air Filter' => 'Воздушный фильтр', //11
//          'Filter Assy' => 'Фильтр в сборе',
//          'Filter Cartridge' => 'Картридж для фильтра',
//          'Fuel Filter' => 'Топливный фильтр',
//          'Oil Filter' => 'Масляный фильтр',

//          'Engine Mounting' => 'Крепление двигателя', //12

//            'Friction Plates' => 'Фрикционные пластины', //13
//            'Disk Kit' => 'Комплект дисков',
//            'Input Plate' => 'Входная пластина',
//            'Plate Return' => 'Возвратная пластина',
//            'PTO Plates' => 'Карданные пластины',
//            'Sinter Plate' => 'Пластина агломерата',
//            'Transmission End Plate' => 'Торцевая пластина коробки передач',
//            'Transmission Plates' => 'Трансмиссионные пластины',
//            'PTO End Plate' => 'Торцевая пластина карданного вала',
//            'Sinter Converter Plate' => 'Плита агломерационного преобразователя',
//            'Steel Converter Plate' => 'Стальная конвертерная пластина',
//            'Plate' => 'Пластина',
//            'Converter Plate' => 'Пластина преобразователя',

//            'Fuel Feed Pump' => 'Насос подачи топлива', //14

//            'Fuel Feed Pump' => 'Насос подачи топлива', //15

//            'Disc Brake' => 'Дисковый тормоз', //16
//            'Repair Kit' => 'Ремонтный комплект',
//            'Seal Kit' => 'Набор уплотнений',
//            'Swing Lock Cable' => 'Трос поворотного замка',
//            'Stator' => 'Статор',

//            'Damper Pulley' => 'Шкив демпфера', //17
//            'Gasket Kit' => 'Комплект прокладок',
//            'Pressure Regulator' => 'Регулятор давления',
//            'Pulley' => 'Шкив',
//            'Thermostat' => 'Термостат',
//            'Timer Assy' => 'Таймер в сборе',

//            'D Ring' => 'Кольцо D', //18

//            'Brake Hose' => 'Тормозной шланг', //19
//            'Telescopic Hose' => 'Телескопический шланг',
//            'Hose' => 'Шланг',

//            'Element Assy' => 'Элемент в сборе',//20
//            'Filter Cartridge' => 'Картридж для фильтра',
//            'Filter Assy' => 'Фильтр в сборе',
//            'Filter Element' => 'Фильтрующий элемент',
//            'Hydraulic Filter' => 'Гидравлический фильтр',
//            'Water Separator' => 'Водоотделитель',
//            'Element' => 'Элемент',
//            'Strainer' => 'Сетчатый фильтр',
//            'Filter' => 'Фильтр',

//            'Hydraulic Motor' => 'Гидравлический двигатель', //21
//            'Swing Motor' => 'Поворотный двигатель',
//            'Winch Motor' => 'Двигатель лебедки',
//            'Pump & Motor Assy' => 'Насос и двигатель в сборе',

//            'Gear Pump' => 'Шестеренчатый насос', //22
//            'Outrigger Pump' => 'Насос аутригера',
//            'Piston Pump' => 'Поршневой насос',
//            'Steering Pump' => 'Насос рулевого управления',
//            'Charging Pump' => 'Насос зарядки',
//            'Transmission Pump' => 'Насос коробки передач',

//            'Hydraulic Seal Kit' => 'Комплект гидравлических уплотнений', //23
//            'Derrick Seal Kit' => 'Комплект уплотнений для деррика',
//            'Horinzontal Slide Seal Kit' => 'Комплект уплотнений для горинзонтального скольжения',
//            'Vertical Jack Seal Kit' => 'Комплект уплотнений вертикального домкрата',
//            'Vertical Jack Seal Kit H Type' => 'Комплект уплотнений для вертикальных домкратов типа H',
//            'Vertical Jack Seal Kit X Type' => 'Комплект уплотнений для вертикального домкрата X типа',
//            'Rotary Seal Kit' => 'Комплект ротационных уплотнений',
//            'Telescopic Seal Kit' => 'Комплект телескопических уплотнений',

//            'Outrigger Control Valve' => 'Клапан управления аутригером', // 24
//            'Main Control Valve' => 'Главный регулирующий клапан',

//            'Cylinder Head' => 'Головка цилиндра', //25

//            'Air Breather' => 'Воздухозаборник', //26
//            'Fuel Cut Motor' => 'Двигатель отключения подачи топлива',
//            'Arm Knuckle' => 'Наконечник рычага',
//            'Caliper Piston' => 'Поршень суппорта',
//            'Back Plate' => 'Задняя пластина',
//            'Wiper Motor' => 'Двигатель стеклоочистителя',
//            'Brake Adjustment' => 'Регулировка тормоза',
//            'Brake Chamber' => 'Тормозная камера',
//            'Brake Disc' => 'Тормозной диск',
//            'Brake Lining' => 'Тормозные накладки',
//            'Cap Seal' => 'Прокладка крышки',
//            'Cone Bearing' => 'Конусный подшипник',
//            'Control Cable' => 'Кабель управления',
//            'Cup Bearing' => 'Чашечный подшипник',
//            'Desiccant' => 'Влагопоглотитель',
//            'Fork Shift' => 'Смещение вилки',
//            'Impeller' => 'Крыльчатка',
//            'Inner Race' => 'Внутренний каток',
//            'Insulator' => 'Изолятор',
//            'Lens Assy' => 'Линза в сборе',
//            'Lock Assy' => 'Замок в сборе',
//            'Lock Cylinder' => 'Запорный цилиндр',
//            'Lug Rim' => 'Обод проушины',
//            'Mirror Assy' => 'Зеркало в сборе',
//            'Oil Seal' => 'Сальник',
//            'Outer Race' => 'Наружная поверхность',
//            'Piston Ring' => 'Поршневое кольцо',
//            'Piston Seal' => 'Уплотнитель поршня',
//            'Planet Spider Assy' => 'Планетарный патрубок в сборе',
//            'Planetary Gear Set' => 'Комплект планетарных шестерен',
//            'Plate Separator' => 'Пластинчатый разделитель',
//            'Pressure Gauge' => 'Манометр',
//            'Propeller Shaft' => 'Вал винта',
//            'Reel Hose Spring' => 'Пружина шланга катушки',
//            'Repair Kit' => 'Ремонтный комплект',
//            'Roller Bearing' => 'Роликовый подшипник',
//            'Roller Drum' => 'Роликовый барабан',
//            'Seal Ring' => 'Уплотнительное кольцо',
//            'Sheave Assy' => 'Шкив в сборе',
//            'Slide Plate' => 'Пластина скольжения',
//            'Slip Ring' => 'Контактное кольцо',
//            'Snop Pin' => 'Сноповая шпилька',
//            'Sun Gear' => 'Солнечная шестеренка',
//            'Tie Rod End' => 'Конец тяги',
//            'Universal Coupling' => 'Универсальная муфта',
//            'Universal Joint' => 'Универсальный шарнир',
//            'Pinion' => 'Шестерня',
//            'Bearing' => 'Подшипник',
//            'Piston' => 'Поршень',
//            'Boot' => 'Ботинок',
//            'Lever' => 'Рычаг',
//            'Gear' => 'Шестерня',
//            'Graver' => 'Гравер',
//            'Guide' => 'Гид',
//            'Hook' => 'Крюк',
//            'Bulb' => 'Лампочка',
//            'Cup' => 'Чашка',
//            'Case' => 'Кейс',
//            'Collar' => 'Воротник',
//            'Latch' => 'Защелка',
//            'Pin' => 'Штырь',
//            'Rotor' => 'Ротор',
//            'Seal' => 'Уплотнитель',
//            'Spacer' => 'Проставка',
//            'Spider' => 'Патрубок',
//            'Spindle' => 'Шпиндель',
//            'Spring' => 'Пружина',
//            'Washer' => 'Шайба',
//            'Yoke' => 'Хомут',
//            'Shaft' => 'Вал',
//            'Band' => 'Группа',
//            'Bolt' => 'Болт',

//            'Bar' => 'Бар', //27
//            'Combination Switch' => 'Комбинированный переключатель',
//            'Lens Assy' => 'Линза в сборе',
//            'Reel Spring' => 'Пружина катушки',
//            'PTO Assy' => 'Карданная передача в сборе',
//            'Repair Kit' => 'Ремонтный комплект',
//            'Reverse Lamp' => 'Фонарь заднего хода',
//            'Rubber Boot' => 'Резиновый сапог',
//            'Switch Panel' => 'Панель переключателей',
//            'Tank Assy' => 'Бак в сборе',

//            'Level Gauge' => 'Датчик уровня', //28

//            'Magnetic Valve' => 'Магнитный клапан', //29

//            'Meter Gauge' => 'Манометр', //30

//            пусто //31

//        'Accelerator Cable' => 'Кабель акселератора', //32
//        'Air Compressor Ring' => 'Кольцо воздушного компрессора',
//        'Air Compressor Valve Kit' => 'Комплект клапанов воздушного компрессора',
//        'Gear Shift Valve' => 'Клапан переключения передач',
//        'Air Dryer Repair Kit' => 'Ремонтный комплект для осушителя воздуха',
//        'Air Governor Kit' => 'Комплект воздушного регулятора',
//        'Air Heater' => 'Воздухонагреватель',
//        'Air Pressure Governor' => 'Регулятор давления воздуха',
//        'Air Dryer' => 'Осушитель воздуха',
//        'Air Compressor' => 'Воздушный компрессор',
//        'Automatic Timer' => 'Автоматический таймер',
//        'Ball Joint' => 'Шаровой шарнир',
//        'Ball Stud' => 'Шариковый стержень',
//        'Beam End Shaft' => 'Концевой вал балки',
//        'Brake Chamber Piston' => 'Поршень тормозной камеры',
//        'Brake Chamber Repair Kit' => 'Комплект для ремонта тормозной камеры',
//        'Cable Assy' => 'Кабельный узел',
//        'Cam Idler' => 'Кулачковый идлер',
//        'Centre Bearing Assy' => 'Центральный подшипник в сборе',
//        'Check Valve' => 'Обратный клапан',
//        'Clutch Bearing Assy' => 'Подшипник сцепления в сборе',
//        'Connector' => 'Разъем',
//        'Conrod Assy' => 'Шатун в сборе',
//        'Crankshaft Assy' => 'Коленчатый вал в сборе',
//        'Crankshaft Oil Seal' => 'Сальник коленчатого вала',
//        'Cushion Rubber' => 'Резиновая подушка',
//        'Damper Pulley' => 'Шкив демпфера',
//        'Diesel Gauge' => 'Дизельный манометр',
//        'Differential Case Set' => 'Комплект корпусов дифференциалов',
//        'Differential Gear Washer' => 'Шайба шестерни дифференциала',
//        'Differential Gear' => 'Дифференциальная передача',
//        'Differential Pinion Washer' => 'Шайба шестерни дифференциала',
//        'Differential Pinion' => 'Шестерня дифференциала',
//        'Door Handle' => 'Ручка двери',
//        'Drag Link' => 'Тяговое звено',
//        'Dust Cover' => 'Пыльник',
//        'Engine Breather' => 'Сапун двигателя',
//        'Exhaust Manifold Gasket' => 'Прокладка выпускного коллектора',
//        'Exhaust Valve Assy' => 'Узел выпускного клапана',
//        'Expansion Ring' => 'Расширительное кольцо',
//        'Fan Bushing' => 'Втулка вентилятора',
//        'Flange Assy' => 'Фланец в сборе',
//        'Flexible Cable' => 'Гибкий кабель',
//        'Flexible Hose' => 'Гибкий шланг',
//        'Flywheel Assy' => 'Маховик в сборе',
//        'Fuel Control Unit' => 'Блок управления подачей топлива',
//        'Fuel Injection Pump' => 'Насос впрыска топлива',
//        'Gasket Kit' => 'Комплект прокладок',
//        'Gear Shift Lever' => 'Рычаг переключения передач',
//        'Gear Shifter' => 'Переключатель передач',
//        'Glow Plug' => 'Свеча накаливания',
//        'Hand Brake Cable' => 'Трос ручного тормоза',
//        'Handle Regulator' => 'Ручка регулятора',
//        'Head Gasket' => 'Прокладка головки',
//        'Hub Bolt' => 'Ступичный болт',
//        'Injection Pump' => 'Инжекторный насос',
//        'Inlet Valve Assy' => 'Впускной клапан в сборе',
//        'King Pin Set' => 'Комплект штифтов',
//        'Lock Cylinder' => 'Запорный цилиндр',
//        'Nozzle Assy' => 'Форсунка в сборе',
//        'Nozzle Tip Gasket' => 'Прокладка наконечника форсунки',
//        'Nozzle Tube' => 'Трубка форсунки',
//        'Oil Cooler Assy' => 'Масляный радиатор в сборе',
//        'Oil Cooler Cover' => 'Крышка масляного радиатора',
//        'Oil Gauge' => 'Масляный манометр',
//        'Oil Pressure Gauge' => 'Манометр давления масла',
//        'Oil Pressure Unit' => 'Блок для измерения давления масла',
//        'Oil Seal' => 'Масляный сальник',
//        'Oil Slinger' => 'Масляный стропальщик',
//        'Power Steering Oil Booster' => 'Масляный усилитель рулевого управления',
//        'PTO Idler Gear' => 'Карданная передача',
//        'PTO Power Cylinder' => 'Цилиндр отбора мощности',
//        'PTO Switch' => 'Переключатель коробки отбора мощности',
//        'Radiator Core' => 'Сердечник радиатора',
//        'Rear Axle Shaft' => 'Вал заднего моста',
//        'Retainer Spring' => 'Стопорная пружина',
//        'Ring Felt Wiper' => 'Кольцевой войлочный стеклоочиститель',
//        'Rubber Bushing' => 'Резиновая втулка',
//        'Rubber Cap' => 'Резиновая крышка',
//        'Screw Fixing Inlet' => 'Винт крепления впускного отверстия',
//        'Seal Ring' => 'Уплотнительное кольцо',
//        'Shaft Lever' => 'Рычаг вала',
//        'Shock Absorber' => 'Амортизатор',
//        'Spring Assy' => 'Пружина в сборе',
//        'Sub Heater Assy' => 'Узел субнагревателя',
//        'Support Plate & Shoe Assy' => 'Опорная пластина и башмак в сборе',
//        'Switch Back Lamp' => 'Переключатель задней лампы',
//        'Tachometer Sensor' => 'Датчик тахометра',
//        'Thermo Switch' => 'Термопереключатель',
//        'Thermostat Casing' => 'Корпус термостата',
//        'Thermostat Cover' => 'Крышка термостата',
//        'Thermostat Kit' => 'Комплект термостата',
//        'Tie Rod End' => 'Конец тяги',
//        'Tube Joint' => 'Трубчатое соединение',
//        'Universal Joint' => 'Универсальное соединение',
//        'Valve Assy' => 'Клапан в сборе',
//        'Valve Unloader' => 'Разгрузочное устройство клапана',
//        'Water Pump Pulley' => 'Шкив водяного насоса',
//        'Water Temperature Gauge' => 'Датчик температуры воды',
//        'Water Temperature Sending Unit' => 'Блок сигнализации температуры воды',
//        'Wiper Blade' => 'Щетка стеклоочистителя',
//        'Wrench Socket' => 'Торцевой ключ',
//        'Tachometer' => 'Тахометр',
//        'Switch' => 'Переключатель',
//        'Bolt' => 'Болт',
//        'Boot' => 'Ботинок',
//        'Sleeve' => 'Рукав',
//        'Spider' => 'Патрубок',
//        'Spring' => 'Пружина',
//        'Seat' => 'Седло клапана',
//        'Shaft' => 'Вал',
//        'Pinion Set' => 'Комплект шестерен',
//        'Piston' => 'Поршень',
//        'Nut' => 'Гайка',
//        'Gear' => 'Шестерня',
//        'Gasket' => 'Прокладка',
//        'Diaphragm' => 'Мембрана',
//        'Crown' => 'Корона',
//        'Bushing' => 'Втулка',
//        'Thermostat' => 'Термостат',
//        'Heater Assy' => 'Нагреватель в сборе',
//        'Pinion' => 'Шестерня',
//        'Brake Chamber' => 'Тормозная камера',

//        'Accelerator Pedal' => 'Педаль акселератора', //33
//        'Air Compressor' => 'Воздушный компрессор',
//        'Ball Seat' => 'Шаровое седло',
//        'Cable Assy' => 'Кабельный узел',
//        'Cam Follower' => 'Кулачковый следящий элемент',
//        'Cartridge Plate' => 'Пластина картриджа',
//        'Centre Bearing Assy' => 'Центральный подшипник в сборе',
//        'Combination Switch' => 'Комбинированный переключатель',
//        'Conrod Assy' => 'Шатун в сборе',
//        'Conrod Bearing' => 'Шатунный подшипник',
//        'Cylinder Head' => 'Головка цилиндра',
//        'Delivery Valve' => 'Клапан подачи',
//        'Door Handle' => 'Ручка двери',
//        'Drain Cap' => 'Сливная крышка',
//        'Engine Stop Solenoid' => 'Электромагнит остановки двигателя',
//        'Exhaust Manifold Gasket' => 'Прокладка выпускного коллектора',
//        'Fan Belt' => 'Ремень вентилятора',
//        'Fan Coupling' => 'Муфта вентилятора',
//        'Flywheel Assy' => 'Маховик в сборе',
//        'Gasket Kit' => 'Комплект прокладок',
//        'Head Gasket' => 'Прокладка головки',
//        'Head Sink' => 'Головная раковина',
//        'Hub Bolt Kit' => 'Комплект болтов ступицы',
//        'Lamp Assy' => 'Лампа в сборе',
//        'Mirror Assy' => 'Зеркало в сборе',
//        'Needle Assy' => 'Игольчатый узел',
//        'Oil Cooler Assy' => 'Масляный радиатор в сборе',
//        'Power Shifter Assy' => 'Узел переключателя мощности',
//        'Push Rod' => 'Нажимной шток',
//        'Reverse Lamp' => 'Фонарь заднего хода',
//        'Ring Gear' => 'Кольцевая шестерня',
//        'Screen Assy' => 'Экран в сборе',
//        'Sender Unit' => 'Блок отправителя',
//        'Shock Absorber' => 'Амортизатор',
//        'Shroud Assy' => 'Кожух в сборе',
//        'Spring Return' => 'Возвратная пружина',
//        'Suction Valve' => 'Клапан всасывания',
//        'Synchro Unit' => 'Блок синхронизации',
//        'Temperature Gauge' => 'Датчик температуры',
//        'Thermostat Housing' => 'Корпус термостата',
//        'Thermostat' => 'Термостат',
//        'Timer Assy' => 'Таймер в сборе',
//        'Tube Vent' => 'Вентиляционная трубка',
//        'Unloader Valve' => 'Клапан разгрузочного устройства',
//        'Water Tank Assy' => 'Бак для воды в сборе',
//        'Tank Assy' => 'Бак в сборе',
//        'Wheel Hub' => 'Ступица колеса',
//        'Wiper Motor Assy' => 'Двигатель стеклоочистителя в сборе',
//        'Wire Assy' => 'Комплект проводов',
//        'Tube' => 'Трубка',
//        'Pulley' => 'Шкив',
//        'Pipe' => 'Труба',
//        'Lever' => 'Рычаг',
//        'Knob' => 'Ручка',
//        'Gasket' => 'Прокладка',
//        'Gear' => 'Шестерня',
//        'Packing' => 'Упаковка',
//        'Boot' => 'Ботинок',
//        'Bushing' => 'Втулка',
//        'Repair Kit' => 'Комплект для ремонта',

//        'Oil Pump' => 'Масляный насос', //34

//        'Adaptor' => 'Переходник', //35
//        'Boom Connector' => 'Соединитель штанги',
//        'Boom Drum Assy' => 'Барабан штанги в сборе',
//        'Boom Hoist Drum' => 'Барабан подъемника стрелы',
//        'Clutch Assy' => 'Сцепление в сборе',
//        'Clutch Dog' => 'Собака с муфтой',
//        'Eccentric Pin' => 'Эксцентриковый штифт',
//        'Grease Nipple' => 'Смазочный ниппель',
//        'Guy Cable Head' => 'Наконечник кабеля',
//        'Hook Roller' => 'Ролик крюка',
//        'Lever Assy' => 'Рычаг в сборе',
//        'Sheave Assy' => 'Шкив в сборе',
//        'Spider Assy' => 'Патрубок в сборе',
//        'Swivel Arm' => 'Поворотный рычаг',
//        'Bellow' => 'Ревун',
//        'Pinion' => 'Шестерня',

//        'Oil Seal' => 'Сальник', //36
//        'Repair Kit' => 'Комплект для ремонта',

//        'Power Steering Cartridge' => 'Картридж гидроусилителя руля', //37

//        'Level Gauge' => 'Датчик уровня', //38
//        'Limit Switch' => 'Концевой переключатель',
//        'Revolving Light' => 'Вращающаяся лампа',
//        'Safety Latch' => 'Предохранительная защелка',

//        'Sharyo Shaft' => 'Вал Шарье', //39
//        'Peak Pin' => 'Пиковый штырь',
//        'Pin' => 'Штырь',
//        'Shaft' => 'Вал',

//        'Solenoid Coil' => 'Электромагнитная катушка', //40
//        'Solenoid Valve' => 'Электромагнитный клапан',
//        'Air Valve' => 'Воздушный клапан',
//        'Swing Valve' => 'Поворотный клапан',

//        'Idler' => 'Шестерня', //41
//        'Sharyo Gear' => 'Шестерня Шарье',
//        'Bevel Gear' => 'Коническая шестерня',
//        'Gear & Hub' => 'Шестерня и ступица',
//        'Sprocket & Hub' => 'Звездочка и ступица',
//        'Sprocket' => 'Звездочка',

//        'Steering Pump' => 'Насос рулевого управления', //42

//        'Ball Bearing' => 'Шарикоподшипник', //43
//        'Needle Roller Bearing' => 'Игольчатый подшипник',
//        'O Ring' => 'Уплотнительное кольцо',
//        'Oil Seal Assy' => 'Сальник в сборе',
//        'Oil Seal Retainer' => 'Фиксатор масляного сальника',
//        'Oil Seal' => 'Сальник',
//        'Pinion' => 'Шестерня',
//        'Repair Kit' => 'Комплект для ремонта',
//        'Spring' => 'Пружина',
//        'Throttle Assy' => 'Дроссельная заслонка в сборе',

        //44 пусто

        //45 пусто

//        'Swivel Joint Repair Kit' => 'Комплект для ремонта шарнирного соединения', //46
//        'Swivel Joint' => 'Шарнирное соединение',

//        'Air Dryer Repair Kit' => 'Ремонтный комплект для осушителя воздуха', //47
//        'Air Pressure Gauge' => 'Манометр давления воздуха',
//        'Air Pressure Switch' => 'Реле давления воздуха',
//        'Back Up Lamp' => 'Лампа заднего хода',
//        'Caliper Piston' => 'Поршень суппорта',
//        'Control Unit' => 'Блок управления',
//        'Coupling Assy' => 'Муфта в сборе',
//        'Fuel Pump Assy' => 'Топливный насос в сборе',
//        'Ignition Plug' => 'Свеча зажигания',
//        'Lamp Bulb' => 'Лампа накаливания',
//        'Lens Assy' => 'Линза в сборе',
//        'Pressure Gauge' => 'Манометр',
//        'Pressure Plate' => 'Прижимная пластина',
//        'Pressure Regulator' => 'Регулятор давления',
//        'Propeller Shaft' => 'Вал винта',
//        'Radiator Cap' => 'Крышка радиатора',
//        'Reduction Gear' => 'Редуктор',
//        'Repair Kit' => 'Комплект для ремонта',
//        'Ring Gear' => 'Кольцевая шестерня',
//        'Rubber Boot' => 'Резиновый сапог',
//        'Seal Assy' => 'Уплотнитель в сборе',
//        'Sender Thermo' => 'Отправитель Термо',
//        'Sheave Assy' => 'Шкив в сборе',
//        'Speedometer' => 'Спидометр',
//        'Tachometer' => 'Тахометр',
//        'Thermo Sender' => 'Отправитель Термо',
//        'Valve Assy' => 'Узел клапана',
//        'Wheel Hub Oil Seal' => 'Сальник ступицы колеса',
//        'Oil Seal' => 'Сальник',
//        'Spring' => 'Пружина',
//        'Retainer' => 'Фиксатор',
//        'Plug' => 'Штекер',
//        'Lighter' => 'Зажигалка',
//        'Nut' => 'Гайка',
//        'Cover' => 'Крышка',
//        'Gasket' => 'Прокладка',
//        'Band' => 'Группа',
//        'Bearing' => 'Подшипник',
//        'Boot' => 'Ботинок',
//        'Shaft' => 'Вал',
//        'Packing' => 'Упаковка',
//        'Clip' => 'Зажим',
//        'Coupling' => 'Муфта',
//        'Ring' => 'Кольцо',

//        'Track Chain' => 'Гусеничная цепь', //48

//        'Top Roller' => 'Верхний ролик', //49
//        'Track Roller' => 'Гусеничный ролик',

//        'Track Shoe' => 'Гусеничный трак', //50

//        'Turbo Charger' => 'Турбокомпрессор', //51

//        'Relief Valve' => 'Предохранительный клапан', //52
//        'Valve Assy' => 'Узел клапана',
//        'Balancing Valve' => 'Балансировочный клапан',
//        'Flow Divider' => 'Распределитель расхода',
//        'Flow Regulator Valve' => 'Клапан регулятора расхода',
//        'Holding Valve' => 'Удерживающий клапан',
//        'Hydro Clutch Valve' => 'Клапан гидропривода сцепления',
//        'Inline Check Valve' => 'Обратный клапан',
//        'Pilot Check Valve' => 'Пилотный обратный клапан',
//        'Reducing Valve' => 'Редукционный клапан',
//        'Shuttle Valve' => 'Запорный клапан',
//        'Sub Plate' => 'Подложка',
//        'Counter Balance Valve' => 'Контрбалансный клапан',
//        'Divider' => 'Распределитель',

        'Water Pump Repair Kit' => 'Комплект для ремонта водяного насоса',
        'Water Pump' => 'Водяной насос', //53

    ];
    public $brand = 'Crane Spare';

    //Запчасти для крановой техники
    protected $dictionaryCatalog = [
        'Accumulators' => 'Аккумуляторы',
        'Booster Assy' => 'Усилитель в сборе',
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
        'Solenoid Valves' => 'Электромагнитные клапаны',
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

//        $html = '<span style="color:#474747; padding:0;">Kato Swing Motor</span><br>619-31100011<br><span style="color:#848484; padding:0;">NK200M-3 / NK200E-3 / NK250E-3 / NK300E-3</span>';
//        $res = $this->clearTextArticul($html);
//        $this->info($res);

        $this->parseAllCategories('https://www.crane-spares.com/catalog/products/');
        $this->info('The command was successful!');
    }

    public function tryToTranslate($name)
    {
        foreach ($this->dictionary as $word => $translate) {
            if ($name == $word) {
                return $this->dictionary[$name];
            } else {
                if (stripos($name, $word)) {
                    $clear = trim(str_replace($word, '', $name));
                    return $translate . ' ' . $clear;
                }
            }
        }
    }

    public function tryToTranslateCatalog($text): string
    {
        try {
            return $this->dictionaryCatalog[$text];
        } catch (\Exception $e) {
            $this->error('Cant translate catalog name');
            return false;
        }
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
                        //2 - Brake Pads
                        //3 - Brake Valves
                        //4 - Caliper Seal Kits *
                        //5 - Clutch Discs
                        //6 - Cylinder Assy
                        //7 - Diesel Hammer Parts *
                        //8 - Electrical Items
                        //9 - Electronics Components *
                        //10 - Engine Fans
                        //11 - Engine Filters
                        //12 - Engine Mountings
                        //13 - Friction Plates
                        //14 - Fuel Feed Pumps
                        //15 - Gear Sets
                        //16 - Grove Crane Parts
                        //17 - Hino Engine Parts
                        //18 - Hitachi Crane Parts
                        //19 - Hoses
                        //20 - Hydraulic Filters
                        //21 - Hydraulic Motors */
                        //22 - Hydraulic Pumps */
                        //23 - Hydraulic Seal Kits
                        //24 - Hydraulic Valves
                        //25 - Isuzu Engine Parts
                        //26 - Kato Crane Parts
                        //27 - Kobelco Crane Parts
                        //28 - Level Gauges
                        //29 - Magnetic Valves
                        //30 - Meter Gauges
                        //31 - Miscellaneous Items - пусто
                        //32 - Mitsubishi Engine Parts
                        //33 - Nissan Engine Parts
                        //34 - Oil Pumps
                        //35 - P&H Crane Parts
                        //36 - P&H Omega Crane Parts
                        //37 - Power Steering Cartridges
                        //38 - Safety Devices
                        //39 - Shafts
                        //40 - Solenoid Valves
                        //41 - Sprockets
                        //42 - Steering Pumps
                        //43 - Sumitomo Crane Parts
                        //44 - Super Structure //пусто
                        //45 - Swing Bearings //пусто
                        //46 - Swivel Joints
                        //47 - Tadano Crane Parts
                        //48 - Track Chains
                        //49 - Track Rollers
                        //50 - Track Shoes
                        //51 - Turbo Chargers
                        //52 - Valve Assy
                        //53 - Water Pumps

                        return ($i == 53);
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
            $total = $crawler->filter('#product_cell li')->count();
            $crawler->filter('#product_cell li')
                ->reduce(
                    function (Crawler $none, $i) {
//                        return ($i < 1);
                    }
                )
                ->each(
                    function (Crawler $node, $n) use ($catalog, $categoryUrl, $uploadPath, $cat_translate, $total) {
                        $data = [];
                        try {
                            $raw_article = trim($node->filter('.bam-span')->html());
                            $data['name'] = trim($node->filter('.bam-span span')->first()->text());
                            $data['articul'] = $this->clearTextArticul($raw_article);

                            if (!$data['articul']) {
                                $data['articul'] = $data['name'];
                            }
                            $data['translate'] = $this->tryToTranslate($data['name']);
                            $data['cat_translate'] = $cat_translate;
                            $data['parse_image'] = $node->filter('img')->first()->attr('src');

                            $this->info(++$n . '/' . $total . ')' . $data['name']);
                            $this->info($data['articul'] . ' / ' . $data['name'] . ' (' . $data['translate'] . ')');

                            $product = CraneSpare::where('parse_image', $data['parse_image'])->first();

                            if (!$product) {
                                $duplicate_products = CraneSpare::where(
                                    'articul',
                                    'LIKE',
                                    $data['articul'] . '%'
                                )->count();
                                if ($duplicate_products !== 0) {
                                    $data['articul'] = $data['articul'] . '-' . ($duplicate_products + 1);
                                }
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
                                $ext = $this->getExtensionFromSrc($data['parse_image']);
                                $filename = $data['articul'] . $ext;
                                $this->downloadJpgFile($data['parse_image'], $uploadPath, $filename);
                            } else {
                                $product->update($data);
                            }
                        } catch
                        (\Exception $e) {
                            $this->warn('product create error: ' . $e->getMessage());
                            $this->warn('see line: ' . $e->getLine());
                            exit();
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

    public function clearTextArticul($text)
    {
        //вырезаем артикул
        $start = stripos($text, '<br>') + 4;
        $end = strripos($text, '<br>');
        return substr($text, $start, $end - $start);
//        $clear_slash_text = str_replace(' / ', '_', $text);
//        return str_replace($name, '', $clear_slash_text);

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

<?php

namespace Database\Factories\Data\AttributeValues;

/**
 * es / uk / ru translations of the English attribute names and values used in CategoryAttributeValues and
 * BrandAttributeValues. Terms that are not listed (model names, codes, "USB", "XLR" ...) stay the same in every locale.
 */
class AttributeTranslations
{
    /**
     * @return array<string, array{es: string, uk: string, ru: string}> English text => translations
     */
    public static function get(): array
    {
        return [
            ...self::general(),
            ...self::guitars(),
            ...self::keyboardsAndPianos(),
            ...self::drums(),
            ...self::ampsAndStudio(),
            ...self::accessories(),
            ...self::brands(),
            ...self::measurements(),
        ];
    }

    /** @return array<string, array{es: string, uk: string, ru: string}> */
    private static function general(): array
    {
        return [
            'Skill Level' => ['es' => 'Nivel', 'uk' => 'Рівень підготовки', 'ru' => 'Уровень подготовки'],
            'Beginner' => ['es' => 'Principiante', 'uk' => 'Початківець', 'ru' => 'Начинающий'],
            'Intermediate' => ['es' => 'Intermedio', 'uk' => 'Середній рівень', 'ru' => 'Средний уровень'],
            'Professional' => ['es' => 'Profesional', 'uk' => 'Професійний', 'ru' => 'Профессиональный'],
            'Color' => ['es' => 'Color', 'uk' => 'Колір', 'ru' => 'Цвет'],
            'Black' => ['es' => 'Negro', 'uk' => 'Чорний', 'ru' => 'Чёрный'],
            'White' => ['es' => 'Blanco', 'uk' => 'Білий', 'ru' => 'Белый'],
            'Natural' => ['es' => 'Natural', 'uk' => 'Натуральний', 'ru' => 'Натуральный'],
            'Sunburst' => ['es' => 'Sunburst', 'uk' => 'Санберст', 'ru' => 'Санберст'],
            'Red' => ['es' => 'Rojo', 'uk' => 'Червоний', 'ru' => 'Красный'],
            'Blue' => ['es' => 'Azul', 'uk' => 'Синій', 'ru' => 'Синий'],
            'Connectivity' => ['es' => 'Conectividad', 'uk' => 'Підключення', 'ru' => 'Подключение'],
            'Number of Strings' => ['es' => 'Número de cuerdas', 'uk' => 'Кількість струн', 'ru' => 'Количество струн'],
            'Number of Keys' => ['es' => 'Número de teclas', 'uk' => 'Кількість клавіш', 'ru' => 'Количество клавиш'],
            'Finish' => ['es' => 'Acabado', 'uk' => 'Оздоблення', 'ru' => 'Отделка'],
            'Technology' => ['es' => 'Tecnología', 'uk' => 'Технологія', 'ru' => 'Технология'],
            'Power' => ['es' => 'Potencia', 'uk' => 'Потужність', 'ru' => 'Мощность'],
            'Medium' => ['es' => 'Medio', 'uk' => 'Середній', 'ru' => 'Средний'],
            'Included' => ['es' => 'Incluidos', 'uk' => 'У комплекті', 'ru' => 'В комплекте'],
            'Not Included' => ['es' => 'No incluidos', 'uk' => 'Не входить у комплект', 'ru' => 'Не входит в комплект'],
        ];
    }

    /** @return array<string, array{es: string, uk: string, ru: string}> */
    private static function guitars(): array
    {
        return [
            'Body Shape' => ['es' => 'Forma del cuerpo', 'uk' => 'Форма корпусу', 'ru' => 'Форма корпуса'],
            'Dreadnought' => ['es' => 'Dreadnought', 'uk' => 'Дредноут', 'ru' => 'Дредноут'],
            'Concert' => ['es' => 'Concierto', 'uk' => 'Концерт', 'ru' => 'Концерт'],
            'Grand Auditorium' => ['es' => 'Gran Auditorio', 'uk' => 'Гранд аудиторіум', 'ru' => 'Гранд аудиториум'],
            'Jumbo' => ['es' => 'Jumbo', 'uk' => 'Джамбо', 'ru' => 'Джамбо'],
            'Parlor' => ['es' => 'Parlor', 'uk' => 'Парлор', 'ru' => 'Парлор'],
            'Top Wood' => ['es' => 'Madera de la tapa', 'uk' => 'Деревина верхньої деки', 'ru' => 'Древесина верхней деки'],
            'Spruce' => ['es' => 'Abeto', 'uk' => 'Ялина', 'ru' => 'Ель'],
            'Cedar' => ['es' => 'Cedro', 'uk' => 'Кедр', 'ru' => 'Кедр'],
            'Mahogany' => ['es' => 'Caoba', 'uk' => 'Червоне дерево', 'ru' => 'Красное дерево'],
            'Guitar Size' => ['es' => 'Tamaño de la guitarra', 'uk' => 'Розмір гітари', 'ru' => 'Размер гитары'],
            'Body Type' => ['es' => 'Tipo de cuerpo', 'uk' => 'Тип корпусу', 'ru' => 'Тип корпуса'],
            'Solid Body' => ['es' => 'Cuerpo sólido', 'uk' => 'Суцільний корпус', 'ru' => 'Цельный корпус'],
            'Semi-Hollow' => ['es' => 'Semihueca', 'uk' => 'Напівакустична', 'ru' => 'Полуакустическая'],
            'Hollow Body' => ['es' => 'Caja hueca', 'uk' => 'Порожнистий корпус', 'ru' => 'Полый корпус'],
            'Pickup Configuration' => ['es' => 'Configuración de pastillas', 'uk' => 'Конфігурація звукознімачів', 'ru' => 'Конфигурация звукоснимателей'],
            'Bridge Type' => ['es' => 'Tipo de puente', 'uk' => 'Тип бриджа', 'ru' => 'Тип бриджа'],
            'Fixed' => ['es' => 'Fijo', 'uk' => 'Фіксований', 'ru' => 'Фиксированный'],
            'Tremolo' => ['es' => 'Trémolo', 'uk' => 'Тремоло', 'ru' => 'Тремоло'],
            'Scale Length' => ['es' => 'Longitud de escala', 'uk' => 'Мензура', 'ru' => 'Мензура'],
            'Short Scale' => ['es' => 'Escala corta', 'uk' => 'Коротка мензура', 'ru' => 'Короткая мензура'],
            'Medium Scale' => ['es' => 'Escala media', 'uk' => 'Середня мензура', 'ru' => 'Средняя мензура'],
            'Long Scale' => ['es' => 'Escala larga', 'uk' => 'Довга мензура', 'ru' => 'Длинная мензура'],
        ];
    }

    /** @return array<string, array{es: string, uk: string, ru: string}> */
    private static function keyboardsAndPianos(): array
    {
        return [
            'Key Action' => ['es' => 'Mecánica de teclas', 'uk' => 'Механіка клавіш', 'ru' => 'Механика клавиш'],
            'Synth Action' => ['es' => 'Acción de sintetizador', 'uk' => 'Синтезаторна механіка', 'ru' => 'Синтезаторная механика'],
            'Semi-Weighted' => ['es' => 'Semipesadas', 'uk' => 'Напівзважена', 'ru' => 'Полувзвешенная'],
            'Weighted' => ['es' => 'Contrapesadas', 'uk' => 'Зважена', 'ru' => 'Взвешенная'],
            'Graded Hammer Action' => ['es' => 'Martillos graduados', 'uk' => 'Градуйована молоточкова механіка', 'ru' => 'Градуированная молоточковая механика'],
            'Synthesis Type' => ['es' => 'Tipo de síntesis', 'uk' => 'Тип синтезу', 'ru' => 'Тип синтеза'],
            'Analog' => ['es' => 'Analógico', 'uk' => 'Аналоговий', 'ru' => 'Аналоговый'],
            'Digital' => ['es' => 'Digital', 'uk' => 'Цифровий', 'ru' => 'Цифровой'],
            'Hybrid' => ['es' => 'Híbrido', 'uk' => 'Гібридний', 'ru' => 'Гибридный'],
            'Wavetable' => ['es' => 'Tabla de ondas', 'uk' => 'Вейвтейбл', 'ru' => 'Вейвтейбл'],
            'Polyphony' => ['es' => 'Polifonía', 'uk' => 'Поліфонія', 'ru' => 'Полифония'],
            'Monophonic' => ['es' => 'Monofónico', 'uk' => 'Монофонічний', 'ru' => 'Монофонический'],
            'Paraphonic' => ['es' => 'Parafónico', 'uk' => 'Парафонічний', 'ru' => 'Парафонический'],
            'Polyphonic' => ['es' => 'Polifónico', 'uk' => 'Поліфонічний', 'ru' => 'Полифонический'],
            'Polished Ebony' => ['es' => 'Ébano pulido', 'uk' => 'Чорний полірований', 'ru' => 'Чёрный полированный'],
            'Satin Ebony' => ['es' => 'Ébano satinado', 'uk' => 'Чорний сатиновий', 'ru' => 'Чёрный сатиновый'],
            'Polished Walnut' => ['es' => 'Nogal pulido', 'uk' => 'Горіх полірований', 'ru' => 'Орех полированный'],
            'Number of Pedals' => ['es' => 'Número de pedales', 'uk' => 'Кількість педалей', 'ru' => 'Количество педалей'],
            'Piano Length' => ['es' => 'Longitud del piano', 'uk' => 'Довжина інструмента', 'ru' => 'Длина инструмента'],
            'Piano Height' => ['es' => 'Altura del piano', 'uk' => 'Висота інструмента', 'ru' => 'Высота инструмента'],
            'Silent System' => ['es' => 'Sistema silencioso', 'uk' => 'Безшумна система', 'ru' => 'Бесшумная система'],
            'With Silent System' => ['es' => 'Con sistema silencioso', 'uk' => 'З безшумною системою', 'ru' => 'С бесшумной системой'],
            'Without Silent System' => ['es' => 'Sin sistema silencioso', 'uk' => 'Без безшумної системи', 'ru' => 'Без бесшумной системы'],
            'Form Factor' => ['es' => 'Formato', 'uk' => 'Форм-фактор', 'ru' => 'Форм-фактор'],
            'Portable' => ['es' => 'Portátil', 'uk' => 'Портативний', 'ru' => 'Портативный'],
            'Console' => ['es' => 'Consola', 'uk' => 'Консольний', 'ru' => 'Консольный'],
            'Stage' => ['es' => 'De escenario', 'uk' => 'Сценічний', 'ru' => 'Сценический'],
        ];
    }

    /** @return array<string, array{es: string, uk: string, ru: string}> */
    private static function drums(): array
    {
        return [
            'Shell Material' => ['es' => 'Material del casco', 'uk' => 'Матеріал корпусу', 'ru' => 'Материал корпуса'],
            'Maple' => ['es' => 'Arce', 'uk' => 'Клен', 'ru' => 'Клён'],
            'Birch' => ['es' => 'Abedul', 'uk' => 'Береза', 'ru' => 'Берёза'],
            'Poplar' => ['es' => 'Álamo', 'uk' => 'Тополя', 'ru' => 'Тополь'],
            'Number of Pieces' => ['es' => 'Número de piezas', 'uk' => 'Кількість елементів', 'ru' => 'Количество элементов'],
            '3-piece' => ['es' => '3 piezas', 'uk' => '3 елементи', 'ru' => '3 элемента'],
            '4-piece' => ['es' => '4 piezas', 'uk' => '4 елементи', 'ru' => '4 элемента'],
            '5-piece' => ['es' => '5 piezas', 'uk' => '5 елементів', 'ru' => '5 элементов'],
            '7-piece' => ['es' => '7 piezas', 'uk' => '7 елементів', 'ru' => '7 элементов'],
            'Hardware' => ['es' => 'Herrajes', 'uk' => 'Фурнітура', 'ru' => 'Фурнитура'],
            'Cymbal Type' => ['es' => 'Tipo de platillo', 'uk' => 'Тип тарілки', 'ru' => 'Тип тарелки'],
            'Hi-Hat' => ['es' => 'Hi-hat', 'uk' => 'Хай-хет', 'ru' => 'Хай-хэт'],
            'Crash' => ['es' => 'Crash', 'uk' => 'Краш', 'ru' => 'Крэш'],
            'Ride' => ['es' => 'Ride', 'uk' => 'Райд', 'ru' => 'Райд'],
            'Splash' => ['es' => 'Splash', 'uk' => 'Сплеш', 'ru' => 'Сплэш'],
            'China' => ['es' => 'China', 'uk' => 'Чайна', 'ru' => 'Чайна'],
            'Diameter' => ['es' => 'Diámetro', 'uk' => 'Діаметр', 'ru' => 'Диаметр'],
            'Cymbal Material' => ['es' => 'Material del platillo', 'uk' => 'Матеріал тарілки', 'ru' => 'Материал тарелки'],
            'Brass' => ['es' => 'Latón', 'uk' => 'Латунь', 'ru' => 'Латунь'],
            'Pad Type' => ['es' => 'Tipo de pad', 'uk' => 'Тип падів', 'ru' => 'Тип падов'],
            'Mesh' => ['es' => 'Malla', 'uk' => 'Сітчастий', 'ru' => 'Сетчатый'],
            'Rubber' => ['es' => 'Goma', 'uk' => 'Гумовий', 'ru' => 'Резиновый'],
        ];
    }

    /** @return array<string, array{es: string, uk: string, ru: string}> */
    private static function ampsAndStudio(): array
    {
        return [
            'Amplifier Type' => ['es' => 'Tipo de amplificador', 'uk' => 'Тип підсилювача', 'ru' => 'Тип усилителя'],
            'Combo' => ['es' => 'Combo', 'uk' => 'Комбопідсилювач', 'ru' => 'Комбоусилитель'],
            'Head' => ['es' => 'Cabezal', 'uk' => 'Голова', 'ru' => 'Голова'],
            'Cabinet' => ['es' => 'Pantalla', 'uk' => 'Кабінет', 'ru' => 'Кабинет'],
            'Tube' => ['es' => 'Válvulas', 'uk' => 'Ламповий', 'ru' => 'Ламповый'],
            'Solid State' => ['es' => 'Estado sólido', 'uk' => 'Транзисторний', 'ru' => 'Транзисторный'],
            'Modeling' => ['es' => 'Modelado', 'uk' => 'Моделювання', 'ru' => 'Моделирование'],
            'Speaker Size' => ['es' => 'Tamaño del altavoz', 'uk' => 'Розмір динаміка', 'ru' => 'Размер динамика'],
            'Number of Channels' => ['es' => 'Número de canales', 'uk' => 'Кількість каналів', 'ru' => 'Количество каналов'],
            'Equipment Type' => ['es' => 'Tipo de equipo', 'uk' => 'Тип обладнання', 'ru' => 'Тип оборудования'],
            'Microphone' => ['es' => 'Micrófono', 'uk' => 'Мікрофон', 'ru' => 'Микрофон'],
            'Audio Interface' => ['es' => 'Interfaz de audio', 'uk' => 'Аудіоінтерфейс', 'ru' => 'Аудиоинтерфейс'],
            'Studio Monitor' => ['es' => 'Monitor de estudio', 'uk' => 'Студійний монітор', 'ru' => 'Студийный монитор'],
            'Headphones' => ['es' => 'Auriculares', 'uk' => 'Навушники', 'ru' => 'Наушники'],
            'Mixer' => ['es' => 'Mezclador', 'uk' => 'Мікшер', 'ru' => 'Микшер'],
            'Microphone Type' => ['es' => 'Tipo de micrófono', 'uk' => 'Тип мікрофона', 'ru' => 'Тип микрофона'],
            'Dynamic' => ['es' => 'Dinámico', 'uk' => 'Динамічний', 'ru' => 'Динамический'],
            'Condenser' => ['es' => 'Condensador', 'uk' => 'Конденсаторний', 'ru' => 'Конденсаторный'],
            'Ribbon' => ['es' => 'De cinta', 'uk' => 'Стрічковий', 'ru' => 'Ленточный'],
            'Polar Pattern' => ['es' => 'Patrón polar', 'uk' => 'Діаграма спрямованості', 'ru' => 'Диаграмма направленности'],
            'Cardioid' => ['es' => 'Cardioide', 'uk' => 'Кардіоїда', 'ru' => 'Кардиоида'],
            'Supercardioid' => ['es' => 'Supercardioide', 'uk' => 'Суперкардіоїда', 'ru' => 'Суперкардиоида'],
            'Omnidirectional' => ['es' => 'Omnidireccional', 'uk' => 'Всенаправлений', 'ru' => 'Всенаправленный'],
            'Connection Type' => ['es' => 'Tipo de conexión', 'uk' => 'Тип підключення', 'ru' => 'Тип подключения'],
            'Number of Inputs' => ['es' => 'Número de entradas', 'uk' => 'Кількість входів', 'ru' => 'Количество входов'],
            'Sample Rate' => ['es' => 'Frecuencia de muestreo', 'uk' => 'Частота дискретизації', 'ru' => 'Частота дискретизации'],
        ];
    }

    /** @return array<string, array{es: string, uk: string, ru: string}> */
    private static function accessories(): array
    {
        return [
            'Accessory Type' => ['es' => 'Tipo de accesorio', 'uk' => 'Тип аксесуара', 'ru' => 'Тип аксессуара'],
            'Strings' => ['es' => 'Cuerdas', 'uk' => 'Струни', 'ru' => 'Струны'],
            'Cables' => ['es' => 'Cables', 'uk' => 'Кабелі', 'ru' => 'Кабели'],
            'Picks' => ['es' => 'Púas', 'uk' => 'Медіатори', 'ru' => 'Медиаторы'],
            'Straps' => ['es' => 'Correas', 'uk' => 'Ремені', 'ru' => 'Ремни'],
            'Stands' => ['es' => 'Soportes', 'uk' => 'Стійки', 'ru' => 'Стойки'],
            'Cases' => ['es' => 'Estuches', 'uk' => 'Кейси', 'ru' => 'Кейсы'],
            'Compatible Instrument' => ['es' => 'Instrumento compatible', 'uk' => 'Сумісний інструмент', 'ru' => 'Совместимый инструмент'],
            'Acoustic Guitar' => ['es' => 'Guitarra acústica', 'uk' => 'Акустична гітара', 'ru' => 'Акустическая гитара'],
            'Electric Guitar' => ['es' => 'Guitarra eléctrica', 'uk' => 'Електрогітара', 'ru' => 'Электрогитара'],
            'Classical Guitar' => ['es' => 'Guitarra clásica', 'uk' => 'Класична гітара', 'ru' => 'Классическая гитара'],
            'Bass Guitar' => ['es' => 'Bajo eléctrico', 'uk' => 'Бас-гітара', 'ru' => 'Бас-гитара'],
            'String Gauge' => ['es' => 'Calibre de cuerdas', 'uk' => 'Калібр струн', 'ru' => 'Калибр струн'],
            'Extra Light' => ['es' => 'Extra ligero', 'uk' => 'Екстра легкий', 'ru' => 'Экстра лёгкий'],
            'Light' => ['es' => 'Ligero', 'uk' => 'Легкий', 'ru' => 'Лёгкий'],
            'Heavy' => ['es' => 'Pesado', 'uk' => 'Важкий', 'ru' => 'Тяжёлый'],
            'Coating' => ['es' => 'Recubrimiento', 'uk' => 'Покриття', 'ru' => 'Покрытие'],
            'Coated' => ['es' => 'Con recubrimiento', 'uk' => 'З покриттям', 'ru' => 'С покрытием'],
            'Uncoated' => ['es' => 'Sin recubrimiento', 'uk' => 'Без покриття', 'ru' => 'Без покрытия'],
            'String Material' => ['es' => 'Material de las cuerdas', 'uk' => 'Матеріал струн', 'ru' => 'Материал струн'],
            'Nickel-Plated Steel' => ['es' => 'Acero niquelado', 'uk' => 'Нікельована сталь', 'ru' => 'Никелированная сталь'],
            'Phosphor Bronze' => ['es' => 'Bronce fosforado', 'uk' => 'Фосфорна бронза', 'ru' => 'Фосфорная бронза'],
            'Nylon' => ['es' => 'Nailon', 'uk' => 'Нейлон', 'ru' => 'Нейлон'],
            'Stainless Steel' => ['es' => 'Acero inoxidable', 'uk' => 'Нержавіюча сталь', 'ru' => 'Нержавеющая сталь'],
            'Cable Type' => ['es' => 'Tipo de cable', 'uk' => 'Тип кабелю', 'ru' => 'Тип кабеля'],
            'Instrument' => ['es' => 'Instrumento', 'uk' => 'Інструментальний', 'ru' => 'Инструментальный'],
            'Speaker' => ['es' => 'Altavoz', 'uk' => 'Акустичний', 'ru' => 'Акустический'],
            'Patch' => ['es' => 'Patch', 'uk' => 'Патч', 'ru' => 'Патч'],
            'Cable Length' => ['es' => 'Longitud del cable', 'uk' => 'Довжина кабелю', 'ru' => 'Длина кабеля'],
            'Connector Type' => ['es' => 'Tipo de conector', 'uk' => "Тип роз'єму", 'ru' => 'Тип разъёма'],
            'Straight' => ['es' => 'Recto', 'uk' => 'Прямий', 'ru' => 'Прямой'],
            'Angled' => ['es' => 'En ángulo', 'uk' => 'Кутовий', 'ru' => 'Угловой'],
        ];
    }

    /** @return array<string, array{es: string, uk: string, ru: string}> */
    private static function brands(): array
    {
        return [
            'Product Line' => ['es' => 'Línea de producto', 'uk' => 'Серія продукції', 'ru' => 'Серия продукции'],
            'Price Segment' => ['es' => 'Segmento de precio', 'uk' => 'Ціновий сегмент', 'ru' => 'Ценовой сегмент'],
            'Entry-Level' => ['es' => 'Gama de entrada', 'uk' => 'Початковий рівень', 'ru' => 'Начальный уровень'],
            'Mid-Range' => ['es' => 'Gama media', 'uk' => 'Середній сегмент', 'ru' => 'Средний сегмент'],
            'Premium' => ['es' => 'Premium', 'uk' => 'Преміум', 'ru' => 'Премиум'],
            'Made In' => ['es' => 'Fabricado en', 'uk' => 'Країна виробництва', 'ru' => 'Страна производства'],
            'Japan' => ['es' => 'Japón', 'uk' => 'Японія', 'ru' => 'Япония'],
            'USA' => ['es' => 'EE. UU.', 'uk' => 'США', 'ru' => 'США'],
            'Germany' => ['es' => 'Alemania', 'uk' => 'Німеччина', 'ru' => 'Германия'],
            'UK' => ['es' => 'Reino Unido', 'uk' => 'Велика Британія', 'ru' => 'Великобритания'],
            'Indonesia' => ['es' => 'Indonesia', 'uk' => 'Індонезія', 'ru' => 'Индонезия'],
        ];
    }

    /**
     * Values with units: only the unit (and "Up to" / "Over") differs per locale.
     *
     * @return array<string, array{es: string, uk: string, ru: string}>
     */
    private static function measurements(): array
    {
        $translations = [];

        foreach (['150-160', '160-170', '170-180', '270-280', '280-290', '100-110', '110-120', '120-130', '130-140'] as $range) {
            $translations["{$range} cm"] = ['es' => "{$range} cm", 'uk' => "{$range} см", 'ru' => "{$range} см"];
        }

        foreach (['1', '3', '6', '10'] as $meters) {
            $translations["{$meters} m"] = ['es' => "{$meters} m", 'uk' => "{$meters} м", 'ru' => "{$meters} м"];
        }

        foreach (['48', '96', '192'] as $rate) {
            $translations["{$rate} kHz"] = ['es' => "{$rate} kHz", 'uk' => "{$rate} кГц", 'ru' => "{$rate} кГц"];
        }

        foreach (['15-50', '50-100', '100-300', '300-500'] as $range) {
            $translations["{$range} W"] = ['es' => "{$range} W", 'uk' => "{$range} Вт", 'ru' => "{$range} Вт"];
        }

        foreach (['15', '100'] as $watts) {
            $translations["Up to {$watts} W"] = ['es' => "Hasta {$watts} W", 'uk' => "До {$watts} Вт", 'ru' => "До {$watts} Вт"];
        }

        foreach (['100', '500'] as $watts) {
            $translations["Over {$watts} W"] = ['es' => "Más de {$watts} W", 'uk' => "Понад {$watts} Вт", 'ru' => "Более {$watts} Вт"];
        }

        return $translations;
    }
}

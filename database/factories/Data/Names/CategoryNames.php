<?php

namespace Database\Factories\Data\Names;

/**
 * Category names per locale: the kinds of gear the shop sells.
 */
class CategoryNames
{
    /**
     * @return list<array<string, string>> each item is locale => name
     */
    public static function get(): array
    {
        return [
            // Guitars
            ['en' => 'Guitars', 'es' => 'Guitarras', 'uk' => 'Гітари', 'ru' => 'Гитары'],
            ['en' => 'Acoustic Guitars', 'es' => 'Guitarras acústicas', 'uk' => 'Акустичні гітари', 'ru' => 'Акустические гитары'],
            ['en' => 'Classical Guitars', 'es' => 'Guitarras clásicas', 'uk' => 'Класичні гітари', 'ru' => 'Классические гитары'],
            ['en' => 'Steel-String Guitars', 'es' => 'Guitarras de cuerdas de acero', 'uk' => 'Гітари зі сталевими струнами', 'ru' => 'Гитары со стальными струнами'],
            ['en' => 'Electric Guitars', 'es' => 'Guitarras eléctricas', 'uk' => 'Електрогітари', 'ru' => 'Электрогитары'],
            ['en' => 'Bass Guitars', 'es' => 'Bajos', 'uk' => 'Бас-гітари', 'ru' => 'Бас-гитары'],

            // Keyboards
            ['en' => 'Keyboards', 'es' => 'Teclados', 'uk' => 'Клавішні', 'ru' => 'Клавишные'],
            ['en' => 'Synthesizers', 'es' => 'Sintetizadores', 'uk' => 'Синтезатори', 'ru' => 'Синтезаторы'],

            // Pianos
            ['en' => 'Pianos', 'es' => 'Pianos', 'uk' => 'Фортепіано', 'ru' => 'Фортепиано'],
            ['en' => 'Grand Pianos', 'es' => 'Pianos de cola', 'uk' => 'Роялі', 'ru' => 'Рояли'],
            ['en' => 'Baby Grand Pianos', 'es' => 'Pianos de media cola', 'uk' => 'Кабінетні роялі', 'ru' => 'Кабинетные рояли'],
            ['en' => 'Concert Grand Pianos', 'es' => 'Pianos de cola de concierto', 'uk' => 'Концертні роялі', 'ru' => 'Концертные рояли'],
            ['en' => 'Upright Pianos', 'es' => 'Pianos verticales', 'uk' => 'Піаніно', 'ru' => 'Пианино'],
            ['en' => 'Digital Pianos', 'es' => 'Pianos digitales', 'uk' => 'Цифрові піаніно', 'ru' => 'Цифровые пианино'],

            // Drums
            ['en' => 'Drums', 'es' => 'Baterías', 'uk' => 'Барабани', 'ru' => 'Барабаны'],
            ['en' => 'Acoustic Drums', 'es' => 'Baterías acústicas', 'uk' => 'Акустичні барабани', 'ru' => 'Акустические барабаны'],
            ['en' => 'Drum Kits', 'es' => 'Kits de batería', 'uk' => 'Барабанні установки', 'ru' => 'Ударные установки'],
            ['en' => 'Cymbals', 'es' => 'Platillos', 'uk' => 'Тарілки', 'ru' => 'Тарелки'],
            ['en' => 'Electronic Drums', 'es' => 'Baterías electrónicas', 'uk' => 'Електронні барабани', 'ru' => 'Электронные барабаны'],

            // Amplifiers
            ['en' => 'Amplifiers', 'es' => 'Amplificadores', 'uk' => 'Підсилювачі', 'ru' => 'Усилители'],
            ['en' => 'Guitar Amplifiers', 'es' => 'Amplificadores de guitarra', 'uk' => 'Гітарні підсилювачі', 'ru' => 'Гитарные усилители'],
            ['en' => 'Bass Amplifiers', 'es' => 'Amplificadores de bajo', 'uk' => 'Басові підсилювачі', 'ru' => 'Басовые усилители'],

            // Studio Gear
            ['en' => 'Studio Gear', 'es' => 'Equipo de estudio', 'uk' => 'Студійне обладнання', 'ru' => 'Студийное оборудование'],
            ['en' => 'Microphones', 'es' => 'Micrófonos', 'uk' => 'Мікрофони', 'ru' => 'Микрофоны'],
            ['en' => 'Audio Interfaces', 'es' => 'Interfaces de audio', 'uk' => 'Аудіоінтерфейси', 'ru' => 'Аудиоинтерфейсы'],

            // Accessories
            ['en' => 'Accessories', 'es' => 'Accesorios', 'uk' => 'Аксесуари', 'ru' => 'Аксессуары'],
            ['en' => 'Strings', 'es' => 'Cuerdas', 'uk' => 'Струни', 'ru' => 'Струны'],
            ['en' => 'Cables', 'es' => 'Cables', 'uk' => 'Кабелі', 'ru' => 'Кабели'],
        ];
    }
}

<?php

namespace Database\Factories\Data\Catalog;

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
            ['en' => 'Guitars', 'es' => 'Guitarras', 'uk' => 'Гітари', 'ru' => 'Гитары'],
            ['en' => 'Bass Guitars', 'es' => 'Bajos', 'uk' => 'Бас-гітари', 'ru' => 'Бас-гитары'],
            ['en' => 'Keyboards', 'es' => 'Teclados', 'uk' => 'Клавішні', 'ru' => 'Клавишные'],
            ['en' => 'Drums', 'es' => 'Baterías', 'uk' => 'Барабани', 'ru' => 'Барабаны'],
            ['en' => 'Amplifiers', 'es' => 'Amplificadores', 'uk' => 'Підсилювачі', 'ru' => 'Усилители'],
            ['en' => 'Studio Gear', 'es' => 'Equipo de estudio', 'uk' => 'Студійне обладнання', 'ru' => 'Студийное оборудование'],
            ['en' => 'Accessories', 'es' => 'Accesorios', 'uk' => 'Аксесуари', 'ru' => 'Аксессуары'],
        ];
    }
}

<?php

namespace Database\Factories\Data\Names;

use App\Enums\DiscountType;

/**
 * Discount names per locale, one for each DiscountType.
 */
class DiscountNames
{
    /**
     * @return array<string, array<string, string>> DiscountType value => (locale => name)
     */
    public static function get(): array
    {
        return [
            DiscountType::OpenBox->value => ['en' => 'Open Box', 'es' => 'Caja abierta', 'uk' => 'Відкрита коробка', 'ru' => 'Открытая коробка'],
            DiscountType::BStock->value => ['en' => 'B-Stock', 'es' => 'Stock B', 'uk' => 'B-сток', 'ru' => 'B-сток'],
            DiscountType::Used->value => ['en' => 'Used', 'es' => 'Usado', 'uk' => 'Вживане', 'ru' => 'Б/у'],
        ];
    }
}

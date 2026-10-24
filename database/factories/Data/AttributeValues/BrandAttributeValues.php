<?php

namespace Database\Factories\Data\AttributeValues;

/**
 * Filter attributes and their values per brand, keyed by the brand name (see BrandNames).
 * Same shape and same translation/assigning flow as CategoryAttributeValues; attribute names shared between
 * brands (Product Line, Price Segment, Made In) are created once and their values merged.
 */
class BrandAttributeValues
{
    /**
     * @return array<string, array<string, list<string>>> brand => attribute => values
     */
    public static function get(): array
    {
        return [
            'Yamaha' => self::brand(['Pacifica', 'Revstar', 'FG Series', 'Clavinova', 'Arius']),
            'Steinway & Sons' => self::brand(['Model A', 'Model B', 'Model D', 'Boston', 'Essex']),
            'Fender' => self::brand(['Stratocaster', 'Telecaster', 'Jazz Bass', 'Precision Bass', 'Player Series']),
            'Gibson' => self::brand(['Les Paul', 'SG', 'ES Series', 'Hummingbird', 'J-45']),
            'Roland' => self::brand(['Juno', 'Jupiter', 'FP Series', 'TD Series', 'Fantom']),
            'Pearl' => self::brand(['Export', 'Decade Maple', 'Masters Maple', 'Roadshow']),
            'Marshall' => self::brand(['JCM800', 'Plexi', 'DSL', 'Origin']),
            'Audio-Technica' => self::brand(['AT2020', 'AT4040', 'AT875R', 'ATH-M Series']),
            'Focusrite' => self::brand(['Scarlett', 'Clarett', 'Vocaster']),
            "D'Addario" => self::brand(['EXL Series', 'XT Coated', 'EJ Phosphor Bronze', 'Planet Waves']),
        ];
    }

    /**
     * Every brand has its own product lines plus the same price segments and countries of origin.
     *
     * @param  list<string>  $productLines
     * @return array<string, list<string>>
     */
    private static function brand(array $productLines): array
    {
        return [
            'Product Line' => $productLines,
            'Price Segment' => ['Entry-Level', 'Mid-Range', 'Premium'],
            'Made In' => ['Japan', 'USA', 'Germany', 'UK', 'Indonesia'],
        ];
    }
}

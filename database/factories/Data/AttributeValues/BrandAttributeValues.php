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
            'Yamaha' => self::brand([
                'Gigmaker', 'APX', 'FS Series', 'CSF Series', 'C Series', 'CGS Series', 'NCX Series', 'TransAcoustic',
                'FG Series', 'L Series', 'Pacifica', 'Revstar', 'TRBX', 'BB Series', 'PSR', 'PSS', 'Piaggero',
                'YC Series', 'MODX', 'Montage', 'reface', 'AvantGrand', 'Disklavier', 'GB Series', 'GC Series', 'CFX',
                'U Series', 'b Series', 'P Series', 'Clavinova', 'Arius', 'CP Series', 'Stage Custom',
                'Recording Custom', 'Rydeen', 'DTX', 'THR', 'HS Series', 'MG Series', 'HPH', 'Stands',
            ]),
            'Steinway & Sons' => self::brand([
                'Spirio', 'Model A', 'Model B', 'Model D', 'Model K', 'Model M', 'Model O', 'Model S', 'Boston', 'Essex',
            ]),
            'Fender' => self::brand([
                'CD Series', 'FA Series', 'Squier', 'Redondo', 'Malibu', 'CC Series', 'CN Series', 'Paramount',
                'Player Series', 'Stratocaster', 'Telecaster', 'Precision Bass', 'Jazz Bass', 'Mustang',
                'Acoustasonic', 'Champion', 'Blues Junior', 'Hot Rod', "'65 Reissue", 'Bassbreaker', 'Tone Master',
                'Rumble', 'Premium Picks', 'Gig Bags', 'Hardshell Cases', 'Straps', 'Super 250', '60 Series',
                'Professional Series',
            ]),
            'Gibson' => self::brand(['Les Paul', 'SG', 'ES Series', 'Hummingbird', 'J-45', 'J-185', 'Hardshell Cases']),
            'Roland' => self::brand([
                'GO:KEYS', 'E-X Series', 'A Series', 'Juno', 'Jupiter', 'JD-Xi', 'Fantom', 'GAIA', 'FP Series',
                'RD Series', 'TD Series', 'KC Series', 'AC Series', 'JC', 'Cube', 'Rubix', 'Duo-Capture', 'Stands',
                'Black Series',
            ]),
            'Pearl' => self::brand(['Export', 'Decade Maple', 'Masters Maple', 'Roadshow', 'Hardware']),
            'Marshall' => self::brand(['JCM800', 'Plexi', 'DSL', 'Origin', 'Cabinets']),
            'Audio-Technica' => self::brand([
                'AT2020', 'AT2035', 'AT4040', 'AT5040', 'AT4081', 'AT875R', 'AT8004', 'ATR', 'ATH-M Series', 'ATH-R Series',
            ]),
            'Focusrite' => self::brand(['Scarlett', 'Clarett', 'Vocaster']),
            "D'Addario" => self::brand([
                'EXL Series', 'XT Coated', 'EJ Phosphor Bronze', 'Pro-Arté', 'NYXL', 'Chromes', 'Planet Waves',
                'American Stage', 'Classic Series', 'Custom Series',
            ]),
            'Zildjian' => self::brand(['A Zildjian', 'A Custom', 'K Custom', 'ZBT']),
            'Sabian' => self::brand(['HHX', 'AAX', 'B8X']),
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
            'Made In' => ['Japan', 'USA', 'Germany', 'UK', 'Indonesia', 'Mexico', 'China', 'Taiwan', 'Canada'],
        ];
    }
}

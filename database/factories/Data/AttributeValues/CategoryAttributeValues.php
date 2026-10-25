<?php

namespace Database\Factories\Data\AttributeValues;

/**
 * Filter attributes and their values per category, keyed by the English category name (see CategoryNames).
 * Everything is English here; AttributeTranslations supplies es/uk/ru and AttributeAssigner turns it into rows.
 *
 * An attribute name that appears under several categories (Color, Skill Level, Finish ...) is created once and
 * reused; its values are merged. Parent categories get broad attributes, leaf categories specific ones.
 */
class CategoryAttributeValues
{
    /**
     * @return array<string, array<string, list<string>>> category => attribute => values
     */
    public static function get(): array
    {
        return [
            // Guitars
            'Guitars' => [
                'Skill Level' => self::skillLevel(),
                'Color' => self::color(),
            ],
            'Acoustic Guitars' => [
                'Body Shape' => ['Dreadnought', 'Concert', 'Grand Auditorium', 'Jumbo', 'Parlor'],
                'Top Wood' => ['Spruce', 'Cedar', 'Mahogany'],
                'Color' => self::color(),
            ],
            'Classical Guitars' => [
                'Guitar Size' => ['4/4', '3/4', '1/2'],
                'Top Wood' => ['Spruce', 'Cedar'],
                'Skill Level' => self::skillLevel(),
            ],
            'Steel-String Guitars' => [
                'Number of Strings' => ['6', '12'],
                'Body Shape' => ['Dreadnought', 'Grand Auditorium', 'Jumbo'],
                'Top Wood' => ['Spruce', 'Cedar', 'Mahogany'],
            ],
            'Electric Guitars' => [
                'Body Type' => ['Solid Body', 'Semi-Hollow', 'Hollow Body'],
                'Pickup Configuration' => ['SSS', 'HSS', 'SS', 'HH', 'HSH', 'P-90'],
                'Number of Strings' => ['6', '7', '8'],
                'Bridge Type' => ['Fixed', 'Tremolo', 'Floyd Rose'],
                'Color' => self::color(),
            ],
            'Bass Guitars' => [
                'Number of Strings' => ['4', '5', '6'],
                'Pickup Configuration' => ['J', 'P', 'PJ', 'HH'],
                'Scale Length' => ['Short Scale', 'Medium Scale', 'Long Scale'],
                'Color' => self::color(),
            ],

            // Keyboards
            'Keyboards' => [
                'Number of Keys' => ['25', '37', '49', '61', '76', '88'],
                'Key Action' => ['Synth Action', 'Semi-Weighted', 'Weighted'],
                'Connectivity' => self::connectivity(),
                'Skill Level' => self::skillLevel(),
            ],
            'Synthesizers' => [
                'Synthesis Type' => ['Analog', 'Digital', 'Hybrid', 'Wavetable'],
                'Polyphony' => ['Monophonic', 'Paraphonic', 'Polyphonic'],
                'Number of Keys' => ['25', '37', '49', '61'],
                'Connectivity' => self::connectivity(),
            ],

            // Pianos
            'Pianos' => [
                'Finish' => self::pianoFinish(),
                'Skill Level' => self::skillLevel(),
            ],
            'Grand Pianos' => [
                'Finish' => self::pianoFinish(),
                'Number of Pedals' => ['2', '3'],
            ],
            'Baby Grand Pianos' => [
                'Piano Length' => ['150-160 cm', '160-170 cm', '170-180 cm'],
                'Finish' => self::pianoFinish(),
            ],
            'Concert Grand Pianos' => [
                'Piano Length' => ['270-280 cm', '280-290 cm'],
                'Finish' => ['Polished Ebony', 'Satin Ebony'],
            ],
            'Upright Pianos' => [
                'Piano Height' => ['100-110 cm', '110-120 cm', '120-130 cm', '130-140 cm'],
                'Finish' => self::pianoFinish(),
                'Silent System' => ['With Silent System', 'Without Silent System'],
            ],
            'Digital Pianos' => [
                'Number of Keys' => ['61', '76', '88'],
                'Key Action' => ['Graded Hammer Action', 'Weighted', 'Semi-Weighted'],
                'Form Factor' => ['Portable', 'Console', 'Stage'],
                'Connectivity' => self::connectivity(),
            ],

            // Drums
            'Drums' => [
                'Shell Material' => ['Maple', 'Birch', 'Poplar', 'Mahogany'],
                'Skill Level' => self::skillLevel(),
            ],
            'Acoustic Drums' => [
                'Shell Material' => ['Maple', 'Birch', 'Poplar', 'Mahogany'],
                'Skill Level' => self::skillLevel(),
            ],
            'Drum Kits' => [
                'Number of Pieces' => ['3-piece', '4-piece', '5-piece', '7-piece'],
                'Shell Material' => ['Maple', 'Birch', 'Poplar', 'Mahogany'],
                'Hardware' => ['Included', 'Not Included'],
                'Color' => self::color(),
            ],
            'Cymbals' => [
                'Cymbal Type' => ['Hi-Hat', 'Crash', 'Ride', 'Splash', 'China'],
                'Diameter' => ['10"', '12"', '14"', '16"', '18"', '20"', '22"'],
                'Cymbal Material' => ['B20 Bronze', 'B8 Bronze', 'Brass'],
            ],
            'Electronic Drums' => [
                'Number of Pieces' => ['3-piece', '4-piece', '5-piece', '7-piece'],
                'Pad Type' => ['Mesh', 'Rubber'],
                'Connectivity' => self::connectivity(),
                'Skill Level' => self::skillLevel(),
            ],

            // Amplifiers
            'Amplifiers' => [
                'Amplifier Type' => ['Combo', 'Head', 'Cabinet'],
                'Technology' => ['Tube', 'Solid State', 'Modeling', 'Hybrid'],
            ],
            'Guitar Amplifiers' => [
                'Amplifier Type' => ['Combo', 'Head', 'Cabinet'],
                'Technology' => ['Tube', 'Solid State', 'Modeling', 'Hybrid'],
                'Power' => ['Up to 15 W', '15-50 W', '50-100 W', 'Over 100 W'],
                'Speaker Size' => ['8"', '10"', '12"'],
                'Number of Channels' => ['1', '2', '3'],
            ],
            'Bass Amplifiers' => [
                'Amplifier Type' => ['Combo', 'Head', 'Cabinet'],
                'Technology' => ['Tube', 'Solid State', 'Modeling', 'Hybrid'],
                'Power' => ['Up to 100 W', '100-300 W', '300-500 W', 'Over 500 W'],
                'Speaker Size' => ['10"', '12"', '15"'],
            ],

            // Studio Gear
            'Studio Gear' => [
                'Equipment Type' => ['Microphone', 'Audio Interface', 'Studio Monitor', 'Headphones', 'Mixer'],
            ],
            'Microphones' => [
                'Microphone Type' => ['Dynamic', 'Condenser', 'Ribbon', 'USB'],
                'Polar Pattern' => ['Cardioid', 'Supercardioid', 'Omnidirectional', 'Figure-8'],
                'Connection Type' => ['XLR', 'USB'],
            ],
            'Audio Interfaces' => [
                'Number of Inputs' => ['1', '2', '4', '8', '16'],
                'Connection Type' => ['USB-C', 'USB-A', 'Thunderbolt'],
                'Sample Rate' => ['48 kHz', '96 kHz', '192 kHz'],
            ],

            // Accessories
            'Accessories' => [
                'Accessory Type' => ['Strings', 'Cables', 'Picks', 'Straps', 'Stands', 'Cases'],
                'Color' => self::color(),
            ],
            'Strings' => [
                'Compatible Instrument' => ['Acoustic Guitar', 'Electric Guitar', 'Classical Guitar', 'Bass Guitar'],
                'String Gauge' => ['Extra Light', 'Light', 'Medium', 'Heavy'],
                'Coating' => ['Coated', 'Uncoated'],
                'String Material' => ['Nickel-Plated Steel', 'Phosphor Bronze', 'Nylon', 'Stainless Steel'],
                'Number of Strings' => ['4', '5', '6', '12'],
            ],
            'Cables' => [
                'Cable Type' => ['Instrument', 'Microphone', 'Speaker', 'Patch', 'MIDI', 'USB'],
                'Cable Length' => ['1 m', '3 m', '6 m', '10 m'],
                'Connector Type' => ['Straight', 'Angled'],
                'Color' => self::color(),
            ],
        ];
    }

    /** @return list<string> */
    private static function color(): array
    {
        return ['Black', 'White', 'Natural', 'Sunburst', 'Red', 'Blue'];
    }

    /** @return list<string> */
    private static function skillLevel(): array
    {
        return ['Beginner', 'Intermediate', 'Professional'];
    }

    /** @return list<string> */
    private static function connectivity(): array
    {
        return ['USB', 'MIDI', 'Bluetooth'];
    }

    /** @return list<string> */
    private static function pianoFinish(): array
    {
        return ['Polished Ebony', 'Satin Ebony', 'Polished Walnut', 'Mahogany', 'White'];
    }
}

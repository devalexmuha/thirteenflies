<?php

namespace Database\Factories\Data\Names;

/**
 * Popular brand names that fit the shop's categories (guitars, pianos, drums, amps, studio gear, accessories).
 * Brand names are plain strings, the same in every locale.
 */
class BrandNames
{
    /**
     * @return list<string>
     */
    public static function get(): array
    {
        return [
            'Yamaha',          // pianos, keyboards, drums, guitars
            'Steinway & Sons', // grand, baby grand and concert grand pianos
            'Fender',          // electric, bass and acoustic guitars, amps
            'Gibson',          // electric and acoustic guitars
            'Roland',          // synthesizers, digital pianos, electronic drums
            'Pearl',           // drum kits
            'Marshall',        // guitar and bass amplifiers
            'Audio-Technica',  // microphones
            'Focusrite',       // audio interfaces
            "D'Addario",       // strings and cables
        ];
    }
}

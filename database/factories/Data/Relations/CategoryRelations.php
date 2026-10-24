<?php

namespace Database\Factories\Data\Relations;

/**
 * Category tree as child => parent, both by English name (see CategoryNames). Categories not listed are roots.
 * A parent must come before its children in CategoryNames, so it already exists when the child is created.
 */
class CategoryRelations
{
    /**
     * @return array<string, string> child English name => parent English name
     */
    public static function get(): array
    {
        return [
            'Acoustic Guitars' => 'Guitars',
            'Classical Guitars' => 'Acoustic Guitars',
            'Steel-String Guitars' => 'Acoustic Guitars',
            'Electric Guitars' => 'Guitars',
            'Bass Guitars' => 'Guitars',

            'Synthesizers' => 'Keyboards',

            'Grand Pianos' => 'Pianos',
            'Baby Grand Pianos' => 'Grand Pianos',
            'Concert Grand Pianos' => 'Grand Pianos',
            'Upright Pianos' => 'Pianos',
            'Digital Pianos' => 'Pianos',

            'Acoustic Drums' => 'Drums',
            'Drum Kits' => 'Acoustic Drums',
            'Cymbals' => 'Acoustic Drums',
            'Electronic Drums' => 'Drums',

            'Guitar Amplifiers' => 'Amplifiers',
            'Bass Amplifiers' => 'Amplifiers',

            'Microphones' => 'Studio Gear',
            'Audio Interfaces' => 'Studio Gear',

            'Strings' => 'Accessories',
            'Cables' => 'Accessories',
        ];
    }
}

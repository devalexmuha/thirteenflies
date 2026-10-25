<?php

namespace Database\Factories\Data\Names;

/**
 * Workshop service names per locale: what the shop's technicians do for instruments.
 */
class ServiceNames
{
    /**
     * @return list<array<string, string>> each item is locale => name
     */
    public static function get(): array
    {
        return [
            ['en' => 'Guitar Setup', 'es' => 'Puesta a punto de guitarra', 'uk' => 'Налаштування гітари', 'ru' => 'Настройка гитары'],
            ['en' => 'Fret Dressing and Leveling', 'es' => 'Nivelación y pulido de trastes', 'uk' => 'Вирівнювання та полірування ладів', 'ru' => 'Выравнивание и полировка ладов'],
            ['en' => 'Piano Tuning', 'es' => 'Afinación de piano', 'uk' => 'Налаштування піаніно', 'ru' => 'Настройка пианино'],
            ['en' => 'Drum Kit Tuning', 'es' => 'Afinación de batería', 'uk' => 'Налаштування барабанної установки', 'ru' => 'Настройка ударной установки'],
            ['en' => 'Amplifier Repair', 'es' => 'Reparación de amplificadores', 'uk' => 'Ремонт підсилювачів', 'ru' => 'Ремонт усилителей'],
            ['en' => 'Keyboard and Synthesizer Repair', 'es' => 'Reparación de teclados y sintetizadores', 'uk' => 'Ремонт клавішних і синтезаторів', 'ru' => 'Ремонт клавишных и синтезаторов'],
        ];
    }
}

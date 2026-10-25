<?php

namespace Database\Factories\Data\Names;

/**
 * Job titles per locale for the shop's authors.
 */
class AuthorPositions
{
    /**
     * @return list<array<string, string>> each item is locale => position
     */
    public static function get(): array
    {
        return [
            ['en' => 'Guitar Technician', 'es' => 'Técnico de guitarras', 'uk' => 'Майстер з гітар', 'ru' => 'Мастер по гитарам'],
            ['en' => 'Session Pianist', 'es' => 'Pianista de sesión', 'uk' => 'Сесійний піаніст', 'ru' => 'Сессионный пианист'],
            ['en' => 'Studio Engineer', 'es' => 'Ingeniero de estudio', 'uk' => 'Студійний інженер', 'ru' => 'Студийный инженер'],
            ['en' => 'Drum Instructor', 'es' => 'Instructor de batería', 'uk' => 'Викладач гри на барабанах', 'ru' => 'Преподаватель игры на барабанах'],
            ['en' => 'Product Specialist', 'es' => 'Especialista de producto', 'uk' => 'Спеціаліст з продукції', 'ru' => 'Специалист по продукции'],
        ];
    }
}

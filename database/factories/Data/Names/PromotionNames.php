<?php

namespace Database\Factories\Data\Names;

/**
 * Promotion names per locale: seasonal and themed sales of the shop.
 */
class PromotionNames
{
    /**
     * @return list<array<string, string>> each item is locale => name
     */
    public static function get(): array
    {
        return [
            ['en' => 'Summer Sale', 'es' => 'Rebajas de verano', 'uk' => 'Літній розпродаж', 'ru' => 'Летняя распродажа'],
            ['en' => 'Black Friday', 'es' => 'Black Friday', 'uk' => 'Чорна пʼятниця', 'ru' => 'Чёрная пятница'],
            ['en' => 'New Year Deals', 'es' => 'Ofertas de Año Nuevo', 'uk' => 'Новорічні пропозиції', 'ru' => 'Новогодние предложения'],
            ['en' => 'Back to Music School', 'es' => 'Vuelta a la escuela de música', 'uk' => 'Назад до музичної школи', 'ru' => 'Назад в музыкальную школу'],
            ['en' => 'Studio Week', 'es' => 'Semana del estudio', 'uk' => 'Студійний тиждень', 'ru' => 'Студийная неделя'],
        ];
    }
}

<?php

namespace Database\Factories\Traits\Seo;

use Database\Factories\Traits\Sentences\CatalogSentences;

/**
 * SEO meta for filter pages (not in SeoTemplateType): title, description, h1
 * and the top/bottom texts shown by SeoContentBlock, in every locale.
 */
trait FillsFilterPageSeoMeta
{
    use CatalogSentences, FillsSeoMeta;

    protected function seoTemplates(): array
    {
        return [
            'en' => [
                'title' => 'Shop {name} - Thirteen Flies',
                'description' => 'Browse {name} at thirteenflies.com: hand-picked gear, fair prices and fast US shipping. Narrow it down and find the right fit for your sound.',
                'h1' => '{name}',
            ],
            'es' => [
                'title' => 'Compra {name} - Thirteen Flies',
                'description' => 'Explora {name} en thirteenflies.com: equipo seleccionado, precios justos y envío rápido en EE. UU. Filtra y encuentra lo que mejor encaja con tu sonido.',
                'h1' => '{name}',
            ],
            'uk' => [
                'title' => 'Купити {name} - Thirteen Flies',
                'description' => 'Переглядайте {name} на thirteenflies.com: відібране обладнання, чесні ціни та швидка доставка по США. Уточніть пошук і знайдіть те, що пасує вашому звуку.',
                'h1' => '{name}',
            ],
            'ru' => [
                'title' => 'Купить {name} - Thirteen Flies',
                'description' => 'Смотрите {name} на thirteenflies.com: отобранное оборудование, честные цены и быстрая доставка по США. Уточните поиск и найдите то, что подходит вашему звуку.',
                'h1' => '{name}',
            ],
        ];
    }
}

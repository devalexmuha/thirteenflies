<?php

namespace Database\Factories\Traits\Seo;

use Database\Factories\Traits\Sentences\CatalogSentences;

/**
 * SEO meta for brands (SeoTemplateType::Brand): title, description, h1
 * and the top/bottom texts shown by SeoContentBlock, in every locale.
 */
trait FillsBrandSeoMeta
{
    use CatalogSentences, FillsSeoMeta;

    protected function seoTemplates(): array
    {
        return [
            'en' => [
                'title' => '{name} Instruments & Gear - Thirteen Flies',
                'description' => 'Discover the full {name} lineup at thirteenflies.com. Authentic products, expert support and fast shipping across the US. Order yours today.',
                'h1' => '{name} Instruments',
            ],
            'es' => [
                'title' => 'Instrumentos y equipo {name} - Thirteen Flies',
                'description' => 'Descubre toda la línea de {name} en thirteenflies.com. Productos originales, asesoría experta y envío rápido en todo EE. UU. Haz tu pedido hoy.',
                'h1' => 'Instrumentos {name}',
            ],
            'uk' => [
                'title' => 'Інструменти та обладнання {name} - Thirteen Flies',
                'description' => 'Відкрийте повну лінійку {name} на thirteenflies.com. Оригінальна продукція, експертна підтримка та швидка доставка по всіх США. Замовляйте вже сьогодні.',
                'h1' => 'Інструменти {name}',
            ],
            'ru' => [
                'title' => 'Инструменты и оборудование {name} - Thirteen Flies',
                'description' => 'Откройте полную линейку {name} на thirteenflies.com. Оригинальная продукция, экспертная поддержка и быстрая доставка по всем США. Заказывайте уже сегодня.',
                'h1' => 'Инструменты {name}',
            ],
        ];
    }
}

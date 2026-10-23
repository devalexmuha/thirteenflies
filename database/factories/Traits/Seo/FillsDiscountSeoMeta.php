<?php

namespace Database\Factories\Traits\Seo;

use Database\Factories\Traits\Sentences\CatalogSentences;

/**
 * SEO meta for discounts (SeoTemplateType::Discount): title, description, h1
 * and the top/bottom texts shown by SeoContentBlock, in every locale.
 */
trait FillsDiscountSeoMeta
{
    use CatalogSentences, FillsSeoMeta;

    protected function seoTemplates(): array
    {
        return [
            'en' => [
                'title' => '{name} Sale and Discounts - Thirteen Flies',
                'description' => 'Grab {name} discounts at thirteenflies.com and save on musical instruments and accessories. Fast US shipping, easy returns, real deals.',
                'h1' => '{name}',
            ],
            'es' => [
                'title' => 'Rebajas y descuentos {name} - Thirteen Flies',
                'description' => 'Aprovecha los descuentos de {name} en thirteenflies.com y ahorra en instrumentos musicales y accesorios. Envío rápido en EE. UU. y devoluciones fáciles.',
                'h1' => '{name}',
            ],
            'uk' => [
                'title' => 'Розпродаж і знижки {name} - Thirteen Flies',
                'description' => 'Скористайтеся знижками {name} на thirteenflies.com та заощаджуйте на музичних інструментах і аксесуарах. Швидка доставка по США та легке повернення.',
                'h1' => '{name}',
            ],
            'ru' => [
                'title' => 'Распродажа и скидки {name} - Thirteen Flies',
                'description' => 'Воспользуйтесь скидками {name} на thirteenflies.com и экономьте на музыкальных инструментах и аксессуарах. Быстрая доставка по США и простой возврат.',
                'h1' => '{name}',
            ],
        ];
    }
}

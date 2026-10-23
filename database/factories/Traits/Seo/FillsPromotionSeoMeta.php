<?php

namespace Database\Factories\Traits\Seo;

use Database\Factories\Traits\Sentences\CatalogSentences;

/**
 * SEO meta for promotions (SeoTemplateType::Promotion): title, description, h1
 * and the top/bottom texts shown by SeoContentBlock, in every locale.
 */
trait FillsPromotionSeoMeta
{
    use CatalogSentences, FillsSeoMeta;

    protected function seoTemplates(): array
    {
        return [
            'en' => [
                'title' => '{name} Deals and Offers - Thirteen Flies',
                'description' => 'Save more with {name} at thirteenflies.com. Limited-time prices on guitars, keys, drums and gear, shipped fast across the US. Don\'t miss out.',
                'h1' => '{name}',
            ],
            'es' => [
                'title' => 'Ofertas y promociones {name} - Thirteen Flies',
                'description' => 'Ahorra más con {name} en thirteenflies.com. Precios por tiempo limitado en guitarras, teclados, baterías y accesorios, con envío rápido en EE. UU.',
                'h1' => '{name}',
            ],
            'uk' => [
                'title' => 'Акції та пропозиції {name} - Thirteen Flies',
                'description' => 'Заощаджуйте більше з {name} на thirteenflies.com. Обмежені за часом ціни на гітари, клавішні, барабани та аксесуари зі швидкою доставкою по США.',
                'h1' => '{name}',
            ],
            'ru' => [
                'title' => 'Акции и предложения {name} - Thirteen Flies',
                'description' => 'Экономьте больше с {name} на thirteenflies.com. Ограниченные по времени цены на гитары, клавишные, барабаны и аксессуары с быстрой доставкой по США.',
                'h1' => '{name}',
            ],
        ];
    }
}

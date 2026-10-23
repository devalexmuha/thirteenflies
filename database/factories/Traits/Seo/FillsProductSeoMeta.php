<?php

namespace Database\Factories\Traits\Seo;

/**
 * SEO meta for products (SeoTemplateType::Product): title, description and h1
 * in every locale. The product form has no top/bottom texts.
 */
trait FillsProductSeoMeta
{
    use FillsSeoMeta;

    protected function seoTemplates(): array
    {
        return [
            'en' => [
                'title' => 'Buy {name} - Thirteen Flies',
                'description' => 'Get the {name} at thirteenflies.com. Genuine gear, secure checkout, fast US shipping and friendly expert support.',
                'h1' => '{name}',
            ],
            'es' => [
                'title' => 'Compra {name} - Thirteen Flies',
                'description' => 'Consigue {name} en thirteenflies.com. Equipo original, pago seguro, envío rápido en EE. UU. y atención experta y amable.',
                'h1' => '{name}',
            ],
            'uk' => [
                'title' => 'Купити {name} - Thirteen Flies',
                'description' => 'Замовте {name} на thirteenflies.com. Оригінальне обладнання, безпечна оплата, швидка доставка по США та дружня експертна підтримка.',
                'h1' => '{name}',
            ],
            'ru' => [
                'title' => 'Купить {name} - Thirteen Flies',
                'description' => 'Закажите {name} на thirteenflies.com. Оригинальное оборудование, безопасная оплата, быстрая доставка по США и дружелюбная экспертная поддержка.',
                'h1' => '{name}',
            ],
        ];
    }
}

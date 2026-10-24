<?php

namespace Database\Factories\Data\Seo;

/**
 * Meta title / description templates for products shown within their category, per locale.
 * {name} is the product name, {category_name} the name of its category (in the same locale), {price} the formatted price.
 */
class ProductCategorySeoTemplates
{
    /**
     * @return array{title: array<string, string>, description: array<string, string>} each is locale => template
     */
    public static function get(): array
    {
        return [
            'title' => [
                'en' => 'Buy {name} - Thirteen Flies',
                'es' => 'Compra {name} - Thirteen Flies',
                'uk' => 'Купити {name} - Thirteen Flies',
                'ru' => 'Купить {name} - Thirteen Flies',
            ],
            'description' => [
                'en' => 'Get the {name} from our {category_name} range for just {price} at thirteenflies.com. Genuine gear, secure checkout, fast US shipping and friendly expert support.',
                'es' => 'Consigue {name} de nuestra categoría {category_name} por solo {price} en thirteenflies.com. Equipo original, pago seguro, envío rápido en EE. UU. y atención experta y amable.',
                'uk' => 'Замовте {name} з категорії «{category_name}» всього за {price} на thirteenflies.com. Оригінальне обладнання, безпечна оплата, швидка доставка по США та дружня експертна підтримка.',
                'ru' => 'Закажите {name} из категории «{category_name}» всего за {price} на thirteenflies.com. Оригинальное оборудование, безопасная оплата, быстрая доставка по США и дружелюбная экспертная поддержка.',
            ],
        ];
    }
}

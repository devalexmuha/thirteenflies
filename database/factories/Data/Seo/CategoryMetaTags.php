<?php

namespace Database\Factories\Data\Seo;

/**
 * Meta title / description / h1 templates for categories (SeoTemplateType::Category), per locale.
 * {name} is replaced with the category name by FillsSeoMeta.
 */
class CategoryMetaTags
{
    /**
     * @return array<string, array{title: string, description: string, h1: string}>
     */
    public static function get(): array
    {
        return [
            'en' => [
                'title' => 'Shop {name} Online - Thirteen Flies',
                'description' => 'Explore our {name} collection at thirteenflies.com: top brands, fair prices and fast US shipping. Find the right gear for your sound today.',
                'h1' => '{name}',
            ],
            'es' => [
                'title' => 'Compra {name} en línea - Thirteen Flies',
                'description' => 'Explora nuestra colección de {name} en thirteenflies.com: las mejores marcas, precios justos y envío rápido en EE. UU. Encuentra el equipo ideal para tu sonido.',
                'h1' => '{name}',
            ],
            'uk' => [
                'title' => 'Купити {name} онлайн - Thirteen Flies',
                'description' => 'Відкрийте колекцію {name} на thirteenflies.com: провідні бренди, чесні ціни та швидка доставка по США. Знайдіть ідеальне обладнання для свого звуку.',
                'h1' => '{name}',
            ],
            'ru' => [
                'title' => 'Купить {name} онлайн - Thirteen Flies',
                'description' => 'Откройте коллекцию {name} на thirteenflies.com: ведущие бренды, честные цены и быстрая доставка по США. Найдите идеальное оборудование для своего звука.',
                'h1' => '{name}',
            ],
        ];
    }
}

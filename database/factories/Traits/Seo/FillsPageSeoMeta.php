<?php

namespace Database\Factories\Traits\Seo;

/**
 * SEO meta for content pages such as About us or Privacy terms (SeoTemplateType::Page):
 * title, description and h1 in every locale. The page form has no top/bottom texts.
 */
trait FillsPageSeoMeta
{
    use FillsSeoMeta;

    protected function seoTemplates(): array
    {
        return [
            'en' => [
                'title' => '{name} - Thirteen Flies',
                'description' => 'Learn more about {name} at thirteenflies.com, your trusted US store for musical instruments, accessories and expert advice for every player.',
                'h1' => '{name}',
            ],
            'es' => [
                'title' => '{name} - Thirteen Flies',
                'description' => 'Conoce más sobre {name} en thirteenflies.com, tu tienda de confianza en EE. UU. de instrumentos musicales, accesorios y asesoría experta.',
                'h1' => '{name}',
            ],
            'uk' => [
                'title' => '{name} - Thirteen Flies',
                'description' => 'Дізнайтеся більше про {name} на thirteenflies.com, вашому надійному магазині музичних інструментів, аксесуарів та експертних порад у США.',
                'h1' => '{name}',
            ],
            'ru' => [
                'title' => '{name} - Thirteen Flies',
                'description' => 'Узнайте больше о {name} на thirteenflies.com, вашем надёжном магазине музыкальных инструментов, аксессуаров и экспертных советов в США.',
                'h1' => '{name}',
            ],
        ];
    }
}

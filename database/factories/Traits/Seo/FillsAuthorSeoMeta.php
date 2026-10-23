<?php

namespace Database\Factories\Traits\Seo;

/**
 * SEO meta for author profiles (SeoTemplateType::Author): title, description and h1
 * in every locale. The author form has no top/bottom texts.
 */
trait FillsAuthorSeoMeta
{
    use FillsSeoMeta;

    protected function seoTemplates(): array
    {
        return [
            'en' => [
                'title' => 'Articles by {name} - Thirteen Flies',
                'description' => 'Meet {name}, a writer at thirteenflies.com. Read their latest gear reviews, buying guides and practical tips for musicians of every level.',
                'h1' => 'Articles by {name}',
            ],
            'es' => [
                'title' => 'Artículos de {name} - Thirteen Flies',
                'description' => 'Conoce a {name}, autor en thirteenflies.com. Lee sus últimas reseñas de equipo, guías de compra y consejos prácticos para músicos de todos los niveles.',
                'h1' => 'Artículos de {name}',
            ],
            'uk' => [
                'title' => 'Статті автора {name} - Thirteen Flies',
                'description' => 'Знайомтеся: {name}, автор thirteenflies.com. Читайте свіжі огляди обладнання, гайди з вибору та практичні поради для музикантів будь-якого рівня.',
                'h1' => 'Статті автора {name}',
            ],
            'ru' => [
                'title' => 'Статьи автора {name} - Thirteen Flies',
                'description' => 'Знакомьтесь: {name}, автор thirteenflies.com. Читайте свежие обзоры оборудования, гайды по выбору и практические советы для музыкантов любого уровня.',
                'h1' => 'Статьи автора {name}',
            ],
        ];
    }
}

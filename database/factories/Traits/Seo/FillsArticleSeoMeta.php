<?php

namespace Database\Factories\Traits\Seo;

/**
 * SEO meta for blog articles (SeoTemplateType::Article): title, description and h1
 * in every locale. The article form has no top/bottom texts.
 */
trait FillsArticleSeoMeta
{
    use FillsSeoMeta;

    protected function seoTemplates(): array
    {
        return [
            'en' => [
                'title' => '{name} - Thirteen Flies',
                'description' => 'Read {name} on the thirteenflies.com blog: practical tips, gear reviews and guides to help you play, practice and choose better instruments.',
                'h1' => '{name}',
            ],
            'es' => [
                'title' => '{name} - Thirteen Flies',
                'description' => 'Lee «{name}» en el blog de thirteenflies.com: consejos prácticos, reseñas de equipo y guías para tocar, practicar y elegir mejores instrumentos.',
                'h1' => '{name}',
            ],
            'uk' => [
                'title' => '{name} - Thirteen Flies',
                'description' => 'Читайте «{name}» у блозі thirteenflies.com: практичні поради, огляди обладнання та гайди, які допоможуть грати, практикуватися й обирати кращі інструменти.',
                'h1' => '{name}',
            ],
            'ru' => [
                'title' => '{name} - Thirteen Flies',
                'description' => 'Читайте «{name}» в блоге thirteenflies.com: практические советы, обзоры оборудования и гайды, которые помогут играть, практиковаться и выбирать лучшие инструменты.',
                'h1' => '{name}',
            ],
        ];
    }
}

<?php

namespace Database\Factories\Traits\Seo;

/**
 * SEO meta for services (SeoTemplateType::Service): title, description and h1
 * in every locale. The service form has no top/bottom texts.
 */
trait FillsServiceSeoMeta
{
    use FillsSeoMeta;

    protected function seoTemplates(): array
    {
        return [
            'en' => [
                'title' => '{name} Service - Thirteen Flies',
                'description' => 'Book {name} with thirteenflies.com: experienced technicians, honest pricing and real care for your instrument. Get it sounding its best again.',
                'h1' => '{name}',
            ],
            'es' => [
                'title' => 'Servicio de {name} - Thirteen Flies',
                'description' => 'Reserva {name} con thirteenflies.com: técnicos con experiencia, precios honestos y cuidado real para tu instrumento. Haz que vuelva a sonar de maravilla.',
                'h1' => '{name}',
            ],
            'uk' => [
                'title' => 'Послуга {name} - Thirteen Flies',
                'description' => 'Замовте {name} у thirteenflies.com: досвідчені майстри, чесні ціни та турбота про ваш інструмент. Нехай він знову звучить якнайкраще.',
                'h1' => '{name}',
            ],
            'ru' => [
                'title' => 'Услуга {name} - Thirteen Flies',
                'description' => 'Закажите {name} в thirteenflies.com: опытные мастера, честные цены и забота о вашем инструменте. Пусть он снова звучит наилучшим образом.',
                'h1' => '{name}',
            ],
        ];
    }
}

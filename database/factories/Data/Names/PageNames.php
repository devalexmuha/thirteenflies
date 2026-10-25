<?php

namespace Database\Factories\Data\Names;

use App\Enums\PageTemplate;

/**
 * Page names per locale: the fixed pages of the site templates (home, listings) and the single pages
 * every shop has (about us, policies).
 */
class PageNames
{
    /**
     * Pages that belong to a page template, by PageTemplate value. Their slugs come from the template.
     *
     * @return array<string, array<string, string>> PageTemplate value => (locale => name)
     */
    public static function templates(): array
    {
        return [
            PageTemplate::Home->value => ['en' => 'Home', 'es' => 'Inicio', 'uk' => 'Головна', 'ru' => 'Главная'],
            PageTemplate::BrandListing->value => ['en' => 'Brands', 'es' => 'Marcas', 'uk' => 'Бренди', 'ru' => 'Бренды'],
            PageTemplate::BlogListing->value => ['en' => 'Blog', 'es' => 'Blog', 'uk' => 'Блог', 'ru' => 'Блог'],
            PageTemplate::ServiceListing->value => ['en' => 'Services', 'es' => 'Servicios', 'uk' => 'Послуги', 'ru' => 'Услуги'],
            PageTemplate::AuthorListing->value => ['en' => 'Authors', 'es' => 'Autores', 'uk' => 'Автори', 'ru' => 'Авторы'],
        ];
    }

    /**
     * Single pages.
     *
     * @return list<array<string, string>> each item is locale => name
     */
    public static function get(): array
    {
        return [
            ['en' => 'About Us', 'es' => 'Sobre nosotros', 'uk' => 'Про нас', 'ru' => 'О нас'],
            ['en' => 'Contact Us', 'es' => 'Contacto', 'uk' => 'Контакти', 'ru' => 'Контакты'],
            ['en' => 'Shipping and Delivery', 'es' => 'Envío y entrega', 'uk' => 'Доставка', 'ru' => 'Доставка'],
            ['en' => 'Returns and Refunds', 'es' => 'Devoluciones y reembolsos', 'uk' => 'Повернення та відшкодування', 'ru' => 'Возврат и возмещение'],
            ['en' => 'Privacy Policy', 'es' => 'Política de privacidad', 'uk' => 'Політика конфіденційності', 'ru' => 'Политика конфиденциальности'],
            ['en' => 'Terms and Conditions', 'es' => 'Términos y condiciones', 'uk' => 'Умови використання', 'ru' => 'Условия использования'],
        ];
    }
}

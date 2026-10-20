<?php

namespace Database\Seeders;

use App\Enums\Locale;
use App\Enums\SeoTemplateType;
use App\Models\Seo\SeoTemplate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (SeoTemplateType::cases() as $type) {
            $template = $this->template($type);

            SeoTemplate::updateOrCreate(
                ['page_type' => $type],
                [
                    'meta_title' => $template['title'],
                    'meta_description' => $template['description'],
                    'h1' => $template['h1'],
                    'alt' => $this->same('{name} - Thirteen Flies'),
                ],
            );
        }
    }

    /** Same text for every locale, e.g. ['en' => '{name}', 'es' => '{name}', ...]. */
    private function same(string $text): array
    {
        return array_fill_keys(array_column(Locale::cases(), 'value'), $text);
    }

    private function template(SeoTemplateType $type): array
    {
        return match ($type) {
            SeoTemplateType::Category => [
                'title' => [
                    'en' => 'Shop {name} Online - Thirteen Flies',
                    'es' => 'Compra {name} en línea - Thirteen Flies',
                    'uk' => 'Купити {name} онлайн - Thirteen Flies',
                    'ru' => 'Купить {name} онлайн - Thirteen Flies',
                ],
                'description' => [
                    'en' => 'Explore our {name} collection at thirteenflies.com: top brands, fair prices and fast US shipping. Find the right gear for your sound today.',
                    'es' => 'Explora nuestra colección de {name} en thirteenflies.com: las mejores marcas, precios justos y envío rápido en EE. UU. Encuentra el equipo ideal para tu sonido.',
                    'uk' => 'Відкрийте колекцію {name} на thirteenflies.com: провідні бренди, чесні ціни та швидка доставка по США. Знайдіть ідеальне обладнання для свого звуку.',
                    'ru' => 'Откройте коллекцию {name} на thirteenflies.com: ведущие бренды, честные цены и быстрая доставка по США. Найдите идеальное оборудование для своего звука.',
                ],
                'h1' => $this->same('{name}'),
            ],

            SeoTemplateType::Brand => [
                'title' => [
                    'en' => '{name} Instruments & Gear - Thirteen Flies',
                    'es' => 'Instrumentos y equipo {name} - Thirteen Flies',
                    'uk' => 'Інструменти та обладнання {name} - Thirteen Flies',
                    'ru' => 'Инструменты и оборудование {name} - Thirteen Flies',
                ],
                'description' => [
                    'en' => 'Discover the full {name} lineup at thirteenflies.com. Authentic products, expert support and fast shipping across the US. Order yours today.',
                    'es' => 'Descubre toda la línea de {name} en thirteenflies.com. Productos originales, asesoría experta y envío rápido en todo EE. UU. Haz tu pedido hoy.',
                    'uk' => 'Відкрийте повну лінійку {name} на thirteenflies.com. Оригінальна продукція, експертна підтримка та швидка доставка по всіх США. Замовляйте вже сьогодні.',
                    'ru' => 'Откройте полную линейку {name} на thirteenflies.com. Оригинальная продукция, экспертная поддержка и быстрая доставка по всем США. Заказывайте уже сегодня.',
                ],
                'h1' => [
                    'en' => '{name} Instruments',
                    'es' => 'Instrumentos {name}',
                    'uk' => 'Інструменти {name}',
                    'ru' => 'Инструменты {name}',
                ],
            ],

            SeoTemplateType::Promotion => [
                'title' => [
                    'en' => '{name} Deals and Offers - Thirteen Flies',
                    'es' => 'Ofertas y promociones {name} - Thirteen Flies',
                    'uk' => 'Акції та пропозиції {name} - Thirteen Flies',
                    'ru' => 'Акции и предложения {name} - Thirteen Flies',
                ],
                'description' => [
                    'en' => 'Save more with {name} at thirteenflies.com. Limited-time prices on guitars, keys, drums and gear, shipped fast across the US. Don\'t miss out.',
                    'es' => 'Ahorra más con {name} en thirteenflies.com. Precios por tiempo limitado en guitarras, teclados, baterías y accesorios, con envío rápido en EE. UU.',
                    'uk' => 'Заощаджуйте більше з {name} на thirteenflies.com. Обмежені за часом ціни на гітари, клавішні, барабани та аксесуари зі швидкою доставкою по США.',
                    'ru' => 'Экономьте больше с {name} на thirteenflies.com. Ограниченные по времени цены на гитары, клавишные, барабаны и аксессуары с быстрой доставкой по США.',
                ],
                'h1' => $this->same('{name}'),
            ],

            SeoTemplateType::Product => [
                'title' => [
                    'en' => 'Buy {name} for {price} - Thirteen Flies',
                    'es' => 'Compra {name} por {price} - Thirteen Flies',
                    'uk' => 'Купити {name} за {price} - Thirteen Flies',
                    'ru' => 'Купить {name} за {price} - Thirteen Flies',
                ],
                'description' => [
                    'en' => 'Get the {name} for just {price} at thirteenflies.com. Genuine gear, secure checkout, fast US shipping and friendly expert support.',
                    'es' => 'Consigue {name} por solo {price} en thirteenflies.com. Equipo original, pago seguro, envío rápido en EE. UU. y atención experta y amable.',
                    'uk' => 'Замовте {name} всього за {price} на thirteenflies.com. Оригінальне обладнання, безпечна оплата, швидка доставка по США та дружня експертна підтримка.',
                    'ru' => 'Закажите {name} всего за {price} на thirteenflies.com. Оригинальное оборудование, безопасная оплата, быстрая доставка по США и дружелюбная экспертная поддержка.',
                ],
                'h1' => $this->same('{name}'),
            ],

            SeoTemplateType::Discount => [
                'title' => [
                    'en' => '{name} Sale and Discounts - Thirteen Flies',
                    'es' => 'Rebajas y descuentos {name} - Thirteen Flies',
                    'uk' => 'Розпродаж і знижки {name} - Thirteen Flies',
                    'ru' => 'Распродажа и скидки {name} - Thirteen Flies',
                ],
                'description' => [
                    'en' => 'Grab {name} discounts at thirteenflies.com and save on musical instruments and accessories. Fast US shipping, easy returns, real deals.',
                    'es' => 'Aprovecha los descuentos de {name} en thirteenflies.com y ahorra en instrumentos musicales y accesorios. Envío rápido en EE. UU. y devoluciones fáciles.',
                    'uk' => 'Скористайтеся знижками {name} на thirteenflies.com та заощаджуйте на музичних інструментах і аксесуарах. Швидка доставка по США та легке повернення.',
                    'ru' => 'Воспользуйтесь скидками {name} на thirteenflies.com и экономьте на музыкальных инструментах и аксессуарах. Быстрая доставка по США и простой возврат.',
                ],
                'h1' => $this->same('{name}'),
            ],

            SeoTemplateType::Page => [
                'title' => $this->same('{name} - Thirteen Flies'),
                'description' => [
                    'en' => 'Learn more about {name} at thirteenflies.com, your trusted US store for musical instruments, accessories and expert advice for every player.',
                    'es' => 'Conoce más sobre {name} en thirteenflies.com, tu tienda de confianza en EE. UU. de instrumentos musicales, accesorios y asesoría experta.',
                    'uk' => 'Дізнайтеся більше про {name} на thirteenflies.com, вашому надійному магазині музичних інструментів, аксесуарів та експертних порад у США.',
                    'ru' => 'Узнайте больше о {name} на thirteenflies.com, вашем надёжном магазине музыкальных инструментов, аксессуаров и экспертных советов в США.',
                ],
                'h1' => $this->same('{name}'),
            ],

            SeoTemplateType::Article => [
                'title' => $this->same('{name} - Thirteen Flies'),
                'description' => [
                    'en' => 'Read {name} on the thirteenflies.com blog: practical tips, gear reviews and guides to help you play, practice and choose better instruments.',
                    'es' => 'Lee «{name}» en el blog de thirteenflies.com: consejos prácticos, reseñas de equipo y guías para tocar, practicar y elegir mejores instrumentos.',
                    'uk' => 'Читайте «{name}» у блозі thirteenflies.com: практичні поради, огляди обладнання та гайди, які допоможуть грати, практикуватися й обирати кращі інструменти.',
                    'ru' => 'Читайте «{name}» в блоге thirteenflies.com: практические советы, обзоры оборудования и гайды, которые помогут играть, практиковаться и выбирать лучшие инструменты.',
                ],
                'h1' => $this->same('{name}'),
            ],

            SeoTemplateType::Service => [
                'title' => [
                    'en' => '{name} Service - Thirteen Flies',
                    'es' => 'Servicio de {name} - Thirteen Flies',
                    'uk' => 'Послуга {name} - Thirteen Flies',
                    'ru' => 'Услуга {name} - Thirteen Flies',
                ],
                'description' => [
                    'en' => 'Book {name} with thirteenflies.com: experienced technicians, honest pricing and real care for your instrument. Get it sounding its best again.',
                    'es' => 'Reserva {name} con thirteenflies.com: técnicos con experiencia, precios honestos y cuidado real para tu instrumento. Haz que vuelva a sonar de maravilla.',
                    'uk' => 'Замовте {name} у thirteenflies.com: досвідчені майстри, чесні ціни та турбота про ваш інструмент. Нехай він знову звучить якнайкраще.',
                    'ru' => 'Закажите {name} в thirteenflies.com: опытные мастера, честные цены и забота о вашем инструменте. Пусть он снова звучит наилучшим образом.',
                ],
                'h1' => $this->same('{name}'),
            ],

            SeoTemplateType::Author => [
                'title' => [
                    'en' => 'Articles by {name} - Thirteen Flies',
                    'es' => 'Artículos de {name} - Thirteen Flies',
                    'uk' => 'Статті автора {name} - Thirteen Flies',
                    'ru' => 'Статьи автора {name} - Thirteen Flies',
                ],
                'description' => [
                    'en' => 'Meet {name}, a writer at thirteenflies.com. Read their latest gear reviews, buying guides and practical tips for musicians of every level.',
                    'es' => 'Conoce a {name}, autor en thirteenflies.com. Lee sus últimas reseñas de equipo, guías de compra y consejos prácticos para músicos de todos los niveles.',
                    'uk' => 'Знайомтеся: {name}, автор thirteenflies.com. Читайте свіжі огляди обладнання, гайди з вибору та практичні поради для музикантів будь-якого рівня.',
                    'ru' => 'Знакомьтесь: {name}, автор thirteenflies.com. Читайте свежие обзоры оборудования, гайды по выбору и практические советы для музыкантов любого уровня.',
                ],
                'h1' => [
                    'en' => 'Articles by {name}',
                    'es' => 'Artículos de {name}',
                    'uk' => 'Статті автора {name}',
                    'ru' => 'Статьи автора {name}',
                ],
            ],
        };
    }
}

<?php

namespace Database\Factories\Data\Sentences;

/**
 * Music-store sentences per locale for the top/bottom SEO texts of catalog pages
 * (the ones whose forms use SeoContentBlock). {name} is replaced with the model name.
 */
class CatalogSentences
{
    public static function get(): array
    {
        return [
            'en' => [
                'Browse our {name} range and find the right gear for your style, budget and stage.',
                'Every {name} item is checked by musicians before it ships, so it sounds right out of the box.',
                'From first guitars to pro stage rigs, {name} has something for players of every level.',
                'Compare tone, feel and build quality to pick the instrument that inspires you to practice.',
                'Our team tunes, tests and sets up gear so you can start playing the moment it arrives.',
                'Pair your {name} with the right strings, cables and stands to get the most from every session.',
                'Good gear shapes how you play, and the right setup makes rehearsals and gigs far more enjoyable.',
                'We stock trusted brands for guitar, keys, drums and studio, all at fair and transparent prices.',
                'Not sure what to choose? Our experts will help you match {name} to your sound and your goals.',
                'Fast US shipping and careful packaging keep your instrument safe on its way to your door.',
                'Whether you play at home, in the studio or on tour, reliable gear lets the music come first.',
                'Look after your instrument with regular cleaning, fresh strings and the right humidity.',
            ],
            'es' => [
                'Explora nuestra gama de {name} y encuentra el equipo ideal para tu estilo, presupuesto y escenario.',
                'Cada artículo de {name} es revisado por músicos antes del envío, así que suena bien desde el primer momento.',
                'Desde la primera guitarra hasta equipos profesionales de escenario, {name} tiene algo para cada nivel.',
                'Compara el tono, el tacto y la calidad de construcción para elegir el instrumento que te inspire a practicar.',
                'Nuestro equipo afina, prueba y ajusta cada equipo para que puedas tocar en cuanto llegue.',
                'Combina tu {name} con las cuerdas, cables y soportes adecuados para sacar el máximo partido a cada sesión.',
                'Un buen equipo influye en cómo tocas, y la configuración correcta hace los ensayos y conciertos más agradables.',
                'Trabajamos con marcas de confianza de guitarra, teclados, batería y estudio, a precios justos y claros.',
                '¿No sabes qué elegir? Nuestros expertos te ayudan a ajustar {name} a tu sonido y a tus objetivos.',
                'El envío rápido en EE. UU. y un embalaje cuidadoso protegen tu instrumento hasta tu puerta.',
                'Toques en casa, en el estudio o de gira, un equipo fiable deja que la música sea lo primero.',
                'Cuida tu instrumento con limpieza regular, cuerdas nuevas y la humedad adecuada.',
            ],
            'uk' => [
                'Перегляньте наш асортимент {name} і знайдіть обладнання, яке підходить вашому стилю, бюджету та сцені.',
                'Кожен товар {name} перевіряють музиканти перед відправкою, тож він звучить чудово з першої хвилини.',
                'Від першої гітари до професійного сценічного комплекту — у {name} є рішення для будь-якого рівня.',
                'Порівнюйте тембр, відчуття та якість виконання, щоб обрати інструмент, який надихає практикуватися.',
                'Наша команда налаштовує та перевіряє обладнання, щоб ви могли грати одразу після отримання.',
                'Доповніть {name} потрібними струнами, кабелями та стійками, щоб отримати максимум від кожної сесії.',
                'Хороше обладнання впливає на гру, а правильне налаштування робить репетиції та концерти приємнішими.',
                'Ми пропонуємо перевірені бренди для гітари, клавішних, барабанів і студії за чесними та прозорими цінами.',
                'Не знаєте, що обрати? Наші експерти допоможуть підібрати {name} під ваш звук і ваші цілі.',
                'Швидка доставка по США та обережне пакування бережуть ваш інструмент дорогою до дверей.',
                'Граєте вдома, в студії чи в турі — надійне обладнання дозволяє музиці бути на першому місці.',
                'Дбайте про інструмент: регулярно чистіть його, змінюйте струни та підтримуйте правильну вологість.',
            ],
            'ru' => [
                'Изучите наш ассортимент {name} и найдите оборудование, которое подойдёт вашему стилю, бюджету и сцене.',
                'Каждый товар {name} проверяют музыканты перед отправкой, поэтому он звучит отлично с первой минуты.',
                'От первой гитары до профессионального сценического комплекта — в {name} есть решение для любого уровня.',
                'Сравнивайте тембр, ощущения и качество сборки, чтобы выбрать инструмент, который вдохновляет заниматься.',
                'Наша команда настраивает и проверяет оборудование, чтобы вы могли играть сразу после получения.',
                'Дополните {name} подходящими струнами, кабелями и стойками, чтобы получить максимум от каждой сессии.',
                'Хорошее оборудование влияет на игру, а правильная настройка делает репетиции и концерты приятнее.',
                'Мы предлагаем проверенные бренды для гитары, клавишных, барабанов и студии по честным и понятным ценам.',
                'Не знаете, что выбрать? Наши эксперты помогут подобрать {name} под ваш звук и ваши цели.',
                'Быстрая доставка по США и аккуратная упаковка берегут ваш инструмент на пути к двери.',
                'Играете дома, в студии или в туре — надёжное оборудование позволяет музыке быть на первом месте.',
                'Заботьтесь об инструменте: регулярно чистите его, меняйте струны и поддерживайте правильную влажность.',
            ],
        ];
    }
}

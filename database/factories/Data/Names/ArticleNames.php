<?php

namespace Database\Factories\Data\Names;

/**
 * Blog article titles per locale: practical guides for the shop's categories.
 */
class ArticleNames
{
    /**
     * @return list<array<string, string>> each item is locale => name
     */
    public static function get(): array
    {
        return [
            ['en' => 'How to Choose Your First Electric Guitar', 'es' => 'Cómo elegir tu primera guitarra eléctrica', 'uk' => 'Як обрати першу електрогітару', 'ru' => 'Как выбрать первую электрогитару'],
            ['en' => 'Acoustic or Classical Guitar: Which One to Buy', 'es' => 'Guitarra acústica o clásica: cuál comprar', 'uk' => 'Акустична чи класична гітара: що купити', 'ru' => 'Акустическая или классическая гитара: что купить'],
            ['en' => 'Digital Piano or Acoustic Piano for Your Home', 'es' => 'Piano digital o acústico para tu casa', 'uk' => 'Цифрове чи акустичне піаніно для дому', 'ru' => 'Цифровое или акустическое пианино для дома'],
            ['en' => 'Home Recording for Beginners', 'es' => 'Grabación en casa para principiantes', 'uk' => 'Домашній звукозапис для початківців', 'ru' => 'Домашняя звукозапись для начинающих'],
            ['en' => 'How Often to Change Your Guitar Strings', 'es' => 'Cada cuánto cambiar las cuerdas de la guitarra', 'uk' => 'Як часто міняти струни на гітарі', 'ru' => 'Как часто менять струны на гитаре'],
            ['en' => 'Choosing a Drum Kit for a Small Room', 'es' => 'Cómo elegir una batería para un espacio pequeño', 'uk' => 'Як обрати барабанну установку для невеликої кімнати', 'ru' => 'Как выбрать ударную установку для небольшой комнаты'],
            ['en' => 'Tube or Modeling Amp: A Practical Comparison', 'es' => 'Amplificador de válvulas o de modelado: comparación práctica', 'uk' => 'Ламповий чи цифровий підсилювач: практичне порівняння', 'ru' => 'Ламповый или цифровой усилитель: практическое сравнение'],
            ['en' => 'First Steps with a New Synthesizer', 'es' => 'Primeros pasos con un sintetizador nuevo', 'uk' => 'Перші кроки з новим синтезатором', 'ru' => 'Первые шаги с новым синтезатором'],
            ['en' => 'Piano Care: Humidity, Tuning and Cleaning', 'es' => 'Cuidado del piano: humedad, afinación y limpieza', 'uk' => 'Догляд за піаніно: вологість, налаштування та чищення', 'ru' => 'Уход за пианино: влажность, настройка и чистка'],
            ['en' => 'Microphones Explained: Dynamic, Condenser and Ribbon', 'es' => 'Micrófonos explicados: dinámicos, de condensador y de cinta', 'uk' => 'Мікрофони простими словами: динамічні, конденсаторні та стрічкові', 'ru' => 'Микрофоны простыми словами: динамические, конденсаторные и ленточные'],
        ];
    }
}

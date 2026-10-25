<?php

namespace Database\Seeders;

use App\Settings\ContactSettings;
use Illuminate\Database\Seeder;

class ContactSettingsSeeder extends Seeder
{
    public function run(ContactSettings $settings): void
    {
        $settings->phone = '+380 44 123 45 67';
        $settings->email = 'info@thirteenflies.com';

        $settings->addresses = [
            [
                'address' => [
                    'en' => '12 Khreshchatyk St, Kyiv, Ukraine',
                    'es' => 'Calle Khreshchatyk 12, Kiev, Ucrania',
                    'uk' => 'вул. Хрещатик, 12, Київ, Україна',
                    'ru' => 'ул. Крещатик, 12, Киев, Украина',
                ],
                'working_hours' => 'Mon–Fri 9am–6pm',
                'map_link' => 'https://maps.google.com/?q=50.4501,30.5234',
                'latitude' => 50.4501,
                'longitude' => 30.5234,
            ],
        ];

        $settings->socials = [
            ['link' => 'https://instagram.com/thirteenflies'],
            ['link' => 'https://facebook.com/thirteenflies'],
        ];

        $settings->save();
    }
}

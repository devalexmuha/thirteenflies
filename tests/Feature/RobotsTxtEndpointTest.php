<?php

use App\Settings\SeoSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns the robots.txt text from the admin settings', function () {
    $settings = app(SeoSettings::class);
    $settings->robots_txt = "User-agent: *\nDisallow: /cart\n";
    $settings->save();

    $this->getJson('/api/robots-txt')
        ->assertOk()
        ->assertExactJson(['data' => ['content' => "User-agent: *\nDisallow: /cart\n"]]);
});

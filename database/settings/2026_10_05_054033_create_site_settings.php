<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.phone_numbers', []);
        $this->migrator->add('site.working_hours', []);
        $this->migrator->add('site.socials', []);
        $this->migrator->add('site.menus', []);
        $this->migrator->add('site.banners', []);
    }
};

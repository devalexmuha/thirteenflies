<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('contacts.phone', null);
        $this->migrator->add('contacts.email', null);
        $this->migrator->add('contacts.addresses', []);
        $this->migrator->add('contacts.socials', []);
    }
};

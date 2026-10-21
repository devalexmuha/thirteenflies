<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ContactSettings extends Settings
{
    public ?string $phone;
    public ?string $email;
    public array $addresses;
    public array $socials;

    public static function group(): string
    {
        return 'contacts';
    }
}

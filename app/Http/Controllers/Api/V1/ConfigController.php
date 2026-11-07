<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConfigResource;
use App\Settings\ContactSettings;

class ConfigController extends Controller
{
    /**
     * Site-wide bootstrap data: locales, contacts and menus.
     */
    public function index(ContactSettings $contacts): ConfigResource
    {
        return ConfigResource::make((object) [
            'contacts' => $contacts,
        ]);
    }
}

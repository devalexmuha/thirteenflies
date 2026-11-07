<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RobotsTxtResource;
use App\Settings\SeoSettings;

class RobotsTxtController extends Controller
{
    /**
     * The robots.txt rules an SEO manager wrote in the admin panel. The client serves them at its own /robots.txt.
     */
    public function show(SeoSettings $seoSettings): RobotsTxtResource
    {
        return RobotsTxtResource::make($seoSettings);
    }
}

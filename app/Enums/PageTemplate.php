<?php

namespace App\Enums;

enum PageTemplate: string
{
    case Home = 'home';
    case Listing = 'listing';
    case Single = 'single';
}

<?php

namespace App\Enums;

enum ProductCondition: string
{
    case New = 'new';
    case OpenBox = 'open_box';
    case BStock = 'b_stock';
    case Used = 'used';
}

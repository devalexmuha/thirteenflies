<?php

namespace App\Enums;

enum DiscountType: string
{
    case BStock = 'b_stock';
    case OpenBox = 'open_box';
    case Used = 'used';
}

<?php

namespace App\Enums;

enum DiscountType: string
{
    case OpenBox = 'open_box';
    case BStock = 'b_stock';
    case Used = 'used';
}

<?php

namespace App\Enums;

enum CollectionType: string
{
    case OnSale = 'on_sale';
    case BStock = 'b_stock';
    case OpenBox = 'open_box';
}

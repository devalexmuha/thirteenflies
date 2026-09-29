<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Received = 'received';
    case Processing = 'processing';
    case Delivery = 'delivery';
    case Delivered = 'delivered';
    case Complete = 'complete';
    case Canceled = 'canceled';
}

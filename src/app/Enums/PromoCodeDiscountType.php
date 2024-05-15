<?php

namespace App\Enums;

enum PromoCodeDiscountType: string
{
    case Percentage = 'percentage';
    case Fixed = 'fixed';
}

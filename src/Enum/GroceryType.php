<?php

declare(strict_types=1);

namespace App\Enum;

enum GroceryType : string
{
    case FRUIT = 'fruit';

    case VEGETABLE = 'vegetable';
}

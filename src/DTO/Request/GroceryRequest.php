<?php

namespace App\DTO\Request;

use App\Enum\GroceryType;
use App\Enum\Unit;
use Symfony\Component\Validator\Constraints as Assert;

class GroceryRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public string $name,
        #[Assert\NotBlank]
        #[Assert\Choice([GroceryType::FRUIT->value, GroceryType::VEGETABLE->value])]
        public string $type,
        #[Assert\NotBlank]
        #[Assert\Positive]
        #[Assert\Type('integer')]
        public int $quantity,
        #[Assert\NotBlank]
        #[Assert\Choice([Unit::GRAMS->value, Unit::KILO_GRAMS->value])]
        public string $unit
    ) {
    }
}

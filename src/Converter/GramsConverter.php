<?php

declare(strict_types=1);

namespace App\Converter;

final class GramsConverter
{
    public function fromKiloGrams(int $value): int
    {
        return $value * 1000;
    }
}

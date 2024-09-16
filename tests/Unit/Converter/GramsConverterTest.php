<?php

namespace App\Tests\Unit\Converter;

use App\Converter\GramsConverter;
use PHPUnit\Framework\TestCase;

class GramsConverterTest extends TestCase
{
    public function testConvertFromKiloGrams(): void
    {
        $this->assertEquals(5000, (new GramsConverter())->fromKiloGrams(5));
        $this->assertEquals(3000, (new GramsConverter())->fromKiloGrams(3));
    }
}

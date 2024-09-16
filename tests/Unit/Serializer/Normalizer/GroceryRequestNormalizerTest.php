<?php

declare(strict_types=1);

namespace App\Tests\Unit\Serializer\Normalizer;

use App\DTO\Request\GroceryRequest;
use App\Serializer\Normalizer\GroceryRequestNormalizer;
use PHPUnit\Framework\TestCase;

class GroceryRequestNormalizerTest extends TestCase
{
    private GroceryRequestNormalizer $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new GroceryRequestNormalizer();
    }

    public function testSupportsNormalization(): void
    {
        $groceryRequest = new GroceryRequest('name', 'fruit', 1, 'kg');
        $this->assertTrue($this->normalizer->supportsNormalization($groceryRequest));
        $this->assertFalse($this->normalizer->supportsNormalization(GroceryRequest::class));
    }

    public function testNormalize(): void
    {
        $groceryRequest = new GroceryRequest('name', 'fruit', 1, 'kg');
        $expected = [
            'name' => 'name',
            'type' => 'fruit',
            'quantity' => 1,
            'unit' => 'kg',
        ];

        $this->assertEquals($expected, $this->normalizer->normalize($groceryRequest));
    }

    public function testSupportsDenormalization(): void
    {
        $this->assertTrue($this->normalizer->supportsDenormalization([], GroceryRequest::class));
        $this->assertFalse($this->normalizer->supportsDenormalization([], \stdClass::class));
    }

    public function testDenormalize(): void
    {
        $data = [
            'name' => 'name',
            'type' => 'fruit',
            'quantity' => 1,
            'unit' => 'kg',
        ];

        $expected = new GroceryRequest('name', 'fruit', 1, 'kg');

        $this->assertEquals($expected, $this->normalizer->denormalize($data, GroceryRequest::class));
    }
}

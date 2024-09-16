<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\DTO\Request\GroceryRequest;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Webmozart\Assert\Assert;

class GroceryRequestNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * @param string[] $context
     * @return array<string, int|string>|null
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): ?array
    {
        if (!$object instanceof GroceryRequest) {
            return null;
        }

        return [
            'name' => $object->name,
            'type' => $object->type,
            'quantity' => $object->quantity,
            'unit' => $object->unit,
        ];
    }

    /**
     * @param string[] $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof GroceryRequest;
    }

    /**
     * @param string[] $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): ?GroceryRequest
    {
        if ($type !== GroceryRequest::class) {
            return null;
        }

        Assert::isArray($data);

        return new GroceryRequest(
            $data['name'],
            $data['type'],
            $data['quantity'],
            $data['unit'],
        );
    }

    /**
     * @param string[] $context
     */
    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = []
    ): bool {
        return $type === GroceryRequest::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            GroceryRequest::class => true,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Converter\GramsConverter;
use App\DTO\Grocery;
use App\DTO\GroceryItem;
use App\Entity\Grocery as GroceryEntity;
use App\Enum\Unit;

final readonly class DtoToEntityTransformer
{
    public function __construct(private GramsConverter $gramsConverter)
    {
    }

    /**
     * @return GroceryEntity[]
     */
    public function transform(Grocery $grocery): array
    {
        return array_map(function (GroceryItem $item) {
            return new GroceryEntity(
                $item->getName(),
                $item->getType(),
                $this->convertToGrams($item),
                $item->getSource(),
                $item->getId(),
                $item->getUnit(),
            );
        }, $grocery->list());
    }

    private function convertToGrams(GroceryItem $item): int
    {
        return match ($item->getUnit()) {
            Unit::KILO_GRAMS => $this->gramsConverter->fromKiloGrams($item->getQuantity()),
            Unit::GRAMS => $item->getQuantity(),
        };
    }
}

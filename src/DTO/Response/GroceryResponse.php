<?php

declare(strict_types=1);

namespace App\DTO\Response;

use DateTime;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

final readonly class GroceryResponse
{
    public function __construct(
        private string $id,
        private ?string $originalId,
        private string $name,
        private string $type,
        private int $quantity,
        private string $unit,
        private ?string $originalUnit,
        private DateTime $createdAt,
        private DateTime $updatedAt
    ) {
    }

    /**
     * @return array<string, int|string|null>
     */
    public function toArray(): array
    {
        Assert::notNull($this->createdAt);
        Assert::notNull($this->updatedAt);

        return [
            'id' => $this->id,
            'originalId' => $this->originalId,
            'name' => $this->name,
            'type' => $this->type,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'originalUnit' => $this->originalUnit,
            'createdAt' => $this->createdAt->format('c'),
            'updatedAt' => $this->updatedAt->format('c'),
        ];
    }
}

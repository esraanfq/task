<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\GrocerySource;
use App\Enum\GroceryType;
use App\Enum\Unit;
use Symfony\Component\Validator\Constraints as Assert;

class GroceryItem
{
    private string $id;
    private string $name;
    private GroceryType $type;
    private int $quantity;
    private Unit $unit;

    private GrocerySource $source;

    public function __construct(
        string $id,
        string $name,
        GroceryType $type,
        int $quantity,
        Unit $unit,
        GrocerySource $source
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->quantity = $quantity;
        $this->unit = $unit;
        $this->source = $source;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): GroceryType
    {
        return $this->type;
    }

    public function setType(GroceryType $type): void
    {
        $this->type = $type;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnit(): Unit
    {
        return $this->unit;
    }

    public function setUnit(Unit $unit): void
    {
        $this->unit = $unit;
    }

    public function getSource(): GrocerySource
    {
        return $this->source;
    }

    public function setSource(GrocerySource $source): void
    {
        $this->source = $source;
    }
}

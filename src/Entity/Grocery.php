<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\GrocerySource;
use App\Enum\GroceryType;
use App\Enum\Unit;
use App\Repository\GroceryRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(GroceryRepository::class)]
#[ORM\Table(name: 'grocery')]
class Grocery
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $originalId = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 50, enumType: GroceryType::class)]
    private GroceryType $type;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    #[ORM\Column(type: 'string', length: 50, options: ['default' => Unit::GRAMS->value])]
    private string $unit = Unit::GRAMS->value;

    #[ORM\Column(type: 'string', length: 50, nullable: true, enumType: Unit::class)]
    private ?Unit $originalUnit = null;

    #[ORM\Column(type: 'string', length: 50, enumType:GrocerySource::class,)]
    private GrocerySource $source;

    public function __construct(
        string $name,
        GroceryType $type,
        int $quantity,
        GrocerySource $source,
        ?string $originalId = null,
        ?Unit $originalUnit = null
    ) {
        $this->id = Uuid::v4()->toRfc4122();
        $this->originalId = $originalId;
        $this->name = $name;
        $this->type = $type;
        $this->quantity = $quantity;
        $this->originalUnit = $originalUnit;
        $this->source = $source;
    }

    public function getId(): string
    {
        return $this->id;
    }
    public function getOriginalId(): ?string
    {
        return $this->originalId;
    }

    public function setOriginalId(?string $originalId): void
    {
        $this->originalId = $originalId;
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

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): void
    {
        $this->unit = $unit;
    }

    public function getOriginalUnit(): ?Unit
    {
        return $this->originalUnit;
    }

    public function setOriginalUnit(?Unit $originalUnit): void
    {
        $this->originalUnit = $originalUnit;
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

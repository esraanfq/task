<?php

declare(strict_types=1);

namespace App\DTO;

class Grocery
{
    /**
     * @var GroceryItem[]
     */
    private array $items = [];

    public function add(GroceryItem $item): void
    {
        $this->items[] = $item;
    }

    public function remove(GroceryItem $item): void
    {
        $key = array_search($item, $this->items, true);
        if ($key === false) {
            return;
        }

        unset($this->items[$key]);
    }

    /**
     * @return GroceryItem[]
     */
    public function list(): array
    {
        return $this->items;
    }
}

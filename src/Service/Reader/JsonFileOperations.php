<?php

declare(strict_types=1);

namespace App\Service\Reader;

use App\DTO\Grocery;
use App\DTO\GroceryItem;
use App\Enum\GrocerySource;
use App\Enum\GroceryType;
use App\Enum\Unit;
use Webmozart\Assert\Assert;

final class JsonFileOperations implements FileOperations
{
    private mixed $resource;

    public function open(string $filePath): void
    {
        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            throw new \RuntimeException("Unable to open file: $filePath");
        }

        $this->resource = $handle;
    }

    /**
     * @return array<string, Grocery>
     */
    public function process(): array
    {
        $fruitCollection = new Grocery();
        $vegetableCollection = new Grocery();

        Assert::resource($this->resource);

        $fileContent = stream_get_contents($this->resource);
        if ($fileContent === false) {
            throw new \RuntimeException("Unable to read file content.");
        }

        $data = json_decode($fileContent, true);

        if ($data === null) {
            throw new \RuntimeException("Invalid JSON data.");
        }

        Assert::isArray($data);

        foreach ($data as $itemData) {
            Assert::isArray($itemData);

            $item = new GroceryItem(
                (string)$itemData['id'],
                $itemData['name'],
                GroceryType::from($itemData['type']),
                (int)$itemData['quantity'],
                Unit::from($itemData['unit']),
                GrocerySource::JSON_FILE_IMPORT
            );

            if ($itemData['type'] === GroceryType::FRUIT->value) {
                $fruitCollection->add($item);
            } elseif ($itemData['type'] === GroceryType::VEGETABLE->value) {
                $vegetableCollection->add($item);
            }
        }

        return [
            GroceryType::FRUIT->value => $fruitCollection,
            GroceryType::VEGETABLE->value => $vegetableCollection
        ];
    }

    public function close(): void
    {
        Assert::resource($this->resource);

        fclose($this->resource);
    }
}

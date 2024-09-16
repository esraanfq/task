<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Grocery;
use App\Repository\GroceryRepository;
use App\Service\Reader\FileOperations;
use App\Transformer\DtoToEntityTransformer;
use Exception;
use App\Entity\Grocery as GroceryEntity;

final readonly class GroceryService
{
    public function __construct(
        private FileOperations $reader,
        private DtoToEntityTransformer $dtoToEntityTransformer,
        private GroceryRepository $groceryRepository
    ) {
    }

    /**
     * @throws Exception
     */
    public function processFile(string $filePath): void
    {
        $this->reader->open($filePath);
        $data = $this->reader->process();
        $this->reader->close();

        $entities = $this->transformToEntities($data);

        $this->groceryRepository->bulkInsert($entities);
    }

    /**
     * @param  array<string, Grocery> $data
     * @return GroceryEntity[]
     */
    private function transformToEntities(array $data): array
    {
        $entities = [];

        foreach ($data as $grocery) {
            $entities[] = $this->dtoToEntityTransformer->transform($grocery);
        }

        return array_merge(...$entities);
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Integration\App\Service;

use App\Converter\GramsConverter;
use App\Entity\Grocery;
use App\Repository\GroceryRepository;
use App\Service\GroceryService;
use App\Service\Reader\FileOperations;
use App\Service\Reader\JsonFileOperations;
use App\Transformer\DtoToEntityTransformer;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GroceryServiceTest extends KernelTestCase
{
    private const FILE_PATH = 'tests/Integration/App/Service/grocery.json';

    private FileOperations $jsonFileOperations;

    private GroceryService $groceryService;

    private DtoToEntityTransformer $dtoToEntityTransformer;

    private GroceryRepository $groceryRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->jsonFileOperations = new JsonFileOperations();
        $this->dtoToEntityTransformer = new DtoToEntityTransformer(new GramsConverter());
        $this->groceryRepository = new  GroceryRepository($managerRegistry);
        $this->groceryService = new GroceryService(
            $this->jsonFileOperations,
            $this->dtoToEntityTransformer,
            $this->groceryRepository
        );
    }

    public function testGetGroceries(): void
    {
        $this->groceryService->processFile(self::FILE_PATH);

        $groceries = $this->groceryRepository->findAll();

        $this->assertNotEmpty($groceries);
        $this->assertCount(22, $groceries);

        foreach ($groceries as $grocery) {
            $this->assertInstanceOf(Grocery::class, $grocery);
        }
    }
}

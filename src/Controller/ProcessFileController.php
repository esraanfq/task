<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\GroceryService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ProcessFileController extends AbstractController
{
    public function __construct(private readonly GroceryService $groceryService)
    {
    }

    /**
     * @throws Exception
     * this is just a test end point , to easily process file
     */
    #[Route('/process', name: 'process', methods: ['POST'])]
    public function process(): Response
    {
        $filePath = './../request.json';
        $this->groceryService->processFile($filePath);

        return new Response('File processed', Response::HTTP_OK);
    }
}

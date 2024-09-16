<?php

declare(strict_types=1);

namespace App\Controller;

use App\Converter\GramsConverter;
use App\DTO\Request\GroceryRequest;
use App\DTO\Response\GroceryResponse;
use App\Entity\Grocery;
use App\Enum\GrocerySource;
use App\Enum\GroceryType;
use App\Enum\Unit;
use App\Repository\GroceryRepository;
use App\Validator\GroceryValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Webmozart\Assert\Assert;

#[Route('/api')]
class GroceryController extends AbstractController
{
    public function __construct(
        private readonly GroceryRepository $groceryRepository,
        private readonly GramsConverter $gramsConverter
    ) {
    }

    #[Route('/grocery', name: 'grocery_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $page = (int)$request->query->get('page', 1);
        $limit = (int)$request->query->get('limit', 10);
        $filters = $request->query->all();

        unset($filters['page'], $filters['limit']);

        $paginator = $this->groceryRepository->findPaginated($page, $limit, $filters);

        $data = array_map(function (mixed $grocery) {

            Assert::isInstanceOf($grocery, Grocery::class);
            Assert::notNull($grocery->getCreatedAt());
            Assert::notNull($grocery->getUpdatedAt());

            return (new GroceryResponse(
                $grocery->getId(),
                $grocery->getOriginalId(),
                $grocery->getName(),
                $grocery->getType()->value,
                $grocery->getQuantity(),
                $grocery->getUnit(),
                $grocery->getOriginalUnit()?->value,
                $grocery->getCreatedAt(),
                $grocery->getUpdatedAt()
            ))->toArray();
        }, iterator_to_array($paginator));

        return $this->json([
            'data' => $data,
            'total' => count($paginator),
            'page' => $page,
            'limit' => $limit,
        ]);
    }

    #[Route('/grocery', name: 'grocery_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, GroceryValidator $validator): JsonResponse
    {
        $data = $request->getContent();

        $groceryDTO = $serializer->deserialize($data, GroceryRequest::class, 'json');

        $errors = $validator->validate($groceryDTO);

        if (count($errors) !== 0) {
            return new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $grocery = new Grocery(
            $groceryDTO->name,
            GroceryType::from($groceryDTO->type),
            $groceryDTO->unit == Unit::KILO_GRAMS->value ?
                $this->gramsConverter->fromKiloGrams($groceryDTO->quantity) : $groceryDTO->quantity,
            GrocerySource::API,
            originalUnit: Unit::from($groceryDTO->unit)
        );

        $this->groceryRepository->save($grocery);

        Assert::notNull($grocery->getCreatedAt());
        Assert::notNull($grocery->getUpdatedAt());

        $response = new GroceryResponse(
            $grocery->getId(),
            $grocery->getOriginalId(),
            $grocery->getName(),
            $grocery->getType()->value,
            $grocery->getQuantity(),
            $grocery->getUnit(),
            $grocery->getOriginalUnit()?->value,
            $grocery->getCreatedAt(),
            $grocery->getUpdatedAt()
        );
        return new JsonResponse($response->toArray(), Response::HTTP_CREATED);
    }
}

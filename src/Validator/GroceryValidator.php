<?php

declare(strict_types=1);

namespace App\Validator;

use App\DTO\Request\GroceryRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final readonly class GroceryValidator
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    /**
     * @return array<int, array<string, array<string,string>|string>>
     */
    public function validate(GroceryRequest $grocery): array
    {
        $violations = $this->validator->validate($grocery);

        $errors = [];
        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                Assert::string($violation->getMessage());

                $errors[] = [
                    'attribute' => $violation->getPropertyPath(),
                    'error' => $violation->getMessage(),
                    'parameters' => $violation->getParameters(),
                ];
            }
        }

        return $errors;
    }
}

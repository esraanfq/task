<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator;

use App\DTO\Request\GroceryRequest;
use App\Validator\GroceryValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GroceryValidatorTest extends TestCase
{
    private ValidatorInterface $validator;
    private GroceryValidator $groceryValidator;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->groceryValidator = new GroceryValidator($this->validator);
    }

    public function testValidateWithNoViolations(): void
    {
        $groceryRequest = new GroceryRequest(
            'name',
            "fruit",
            1,
            "g",
        );

        $violations = new ConstraintViolationList();

        $this->validator->method('validate')->willReturn($violations);

        $errors = $this->groceryValidator->validate($groceryRequest);

        $this->assertEmpty($errors);
    }

    public function testValidateWithViolations(): void
    {
        $groceryRequest = new GroceryRequest(
            '',
            "fruitt",
            1,
            "g",
        );
        $violation1 = new ConstraintViolation(
            'This value should not be blank.',
            null,
            [
                '{{ value }}' => '""',
            ],
            '',
            'name',
            ''
        );
        $violation2 = new ConstraintViolation(
            'This value is not a valid choice.',
            null,
            [
                ['{{ value }}' => '"fruitt"', '{{ choices }}' => '"fruit", "vegetable"']
            ],
            '',
            'type',
            ''
        );
        $violations = new ConstraintViolationList([$violation1, $violation2]);

        $this->validator->method('validate')->willReturn($violations);

        $errors = $this->groceryValidator->validate($groceryRequest);

        $this->assertNotEmpty($errors);
        $this->assertCount(2, $errors);
        $this->assertEquals(
            [
                'attribute' => 'name',
                'error' => 'This value should not be blank.',
                'parameters' => ['{{ value }}' => '""'],
            ],
            $errors[0]
        );
        $this->assertEquals(
            [
                'attribute' => 'type',
                'error' => 'This value is not a valid choice.',
                'parameters' => [
                    [
                        '{{ value }}' => '"fruitt"',
                        '{{ choices }}' => '"fruit", "vegetable"'
                    ]
                ],
            ],
            $errors[1]
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GroceryControllerTest extends ApiTestCase
{
    public function testIndex(): void
    {

        $this->requestJson('GET', '/api/grocery');
        $response = $this->getJsonResponse();

        $this->assertResponseStatusCode(Response::HTTP_OK);
        $this->assertEquals(
            [
                "data" => [
                    [
                        "id" => $response['data'][0]['id'],
                        "originalId" => null,
                        "name" => "Banana",
                        "type" => "fruit",
                        "quantity" => 5,
                        "unit" => "g",
                        "originalUnit" => null,
                        "createdAt" => $response['data'][0]['createdAt'],
                        "updatedAt" => $response['data'][0]['updatedAt']
                    ],
                    [
                        "id" => $response['data'][1]['id'],
                        "originalId" => null,
                        "name" => "Carrot",
                        "type" => "vegetable",
                        "quantity" => 3,
                        "unit" => "g",
                        "originalUnit" => null,
                        "createdAt" => $response['data'][1]['createdAt'],
                        "updatedAt" => $response['data'][1]['updatedAt'],
                    ]
                ],
                "total" => 2,
                "page" => 1,
                "limit" => 10,
            ],
            $response
        );
    }

    public function testIndexWithFilters()
    {
        $this->requestJson('GET', '/api/grocery', ['type' => 'fruit']);
        $response = $this->getJsonResponse();

        $this->assertResponseStatusCode(Response::HTTP_OK);
        $this->assertEquals(
            [
                "data" => [
                    [
                        "id" => $response['data'][0]['id'],
                        "originalId" => null,
                        "name" => "Banana",
                        "type" => "fruit",
                        "quantity" => 5,
                        "unit" => "g",
                        "originalUnit" => null,
                        "createdAt" => $response['data'][0]['createdAt'],
                        "updatedAt" => $response['data'][0]['updatedAt']
                    ]
                ],
                "total" => 1,
                "page" => 1,
                "limit" => 10,
            ],
            $response
        );
    }
    public function testCreate(): void
    {
        $data = [
            'name' => 'Apple',
            'type' => 'fruit',
            'quantity' => 1000,
            'unit' => 'g'
        ];

        $this->requestJson(
            'POST',
            '/api/grocery',
            $data,
        );

        $this->assertResponseStatusCode(Response::HTTP_CREATED);

        $responseData = $this->getJsonResponse();

        $this->assertEquals(
            [
                'id' => $responseData['id'],
                'originalId' => null,
                'name' => 'Apple',
                'type' => 'fruit',
                'quantity' => 1000,
                'unit' => 'g',
                'originalUnit' => 'g',
                'createdAt' => $responseData['createdAt'],
                'updatedAt' => $responseData['updatedAt']
            ],
            $responseData
        );
    }

    public function testCreateWithInvalidData(): void
    {
        $data = [
            'name' => '',
            'type' => 'fruitt',
            'quantity' => 1000,
            'unit' => 'kg'
        ];

        $this->requestJson(
            'POST',
            '/api/grocery',
            $data,
        );

        $this->assertResponseStatusCode(Response::HTTP_BAD_REQUEST);

        $responseData = $this->getJsonResponse();

        $this->assertEquals(['errors' =>
            [
                [
                    'attribute' => 'name',
                    'error' => 'This value should not be blank.',
                    'parameters' => [ '{{ value }}' => '""'],
                ]
                ,
                [
                    'attribute' => 'type',
                    'error' => 'The value you selected is not a valid choice.',
                    'parameters' => ['{{ value }}' => '"fruitt"', '{{ choices }}' => '"fruit", "vegetable"'],
                ]
            ]
        ], $responseData);
    }
}

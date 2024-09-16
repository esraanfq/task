<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;

abstract class ApiTestCase extends WebTestCase
{
    protected ?KernelBrowser $kernelBrowser = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kernelBrowser = self::createClient();
        $this->kernelBrowser->disableReboot();
    }

    protected function tearDown(): void
    {
        $this->kernelBrowser = null;
        parent::tearDown();
    }

    protected function requestJson(string $method, string $uri, mixed $payload = null, array $headers = []): void
    {
        if ($method === Request::METHOD_GET && \is_array($payload)) {
            $this->kernelBrowser->request(
                $method,
                $uri,
                $payload,
                [],
                \array_merge(['CONTENT_TYPE' => 'application/json'], $headers),
            );

            return;
        }

        $this->kernelBrowser->request(
            $method,
            $uri,
            [],
            [],
            \array_merge(['CONTENT_TYPE' => 'application/json'], $headers),
            $payload !== null ? json_encode($payload) : null,
        );
    }

    protected function getJsonResponse(): ?array
    {
        $content = $this->kernelBrowser->getResponse()->getContent();

        return $content !== '' ? json_decode($content, true) : null;
    }

    protected function assertResponseStatusCode(int $expectedStatusCode): void
    {
        self::assertSame($expectedStatusCode, $this->kernelBrowser->getResponse()->getStatusCode());
    }
}

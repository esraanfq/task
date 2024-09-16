<?php

namespace App\Service\Reader;

use App\DTO\Grocery;

interface FileOperations
{
    public function open(string $filePath): void;

    /**
     * @return array<string, Grocery>
     */
    public function process(): array;

    public function close(): void;
}

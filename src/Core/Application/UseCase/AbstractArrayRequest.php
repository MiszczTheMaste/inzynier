<?php

declare(strict_types=1);

namespace App\Core\Application\UseCase;

/**
 *
 */
abstract class AbstractArrayRequest
{
    /**
     * @var array<string,string|int|float|bool>
     */
    private array $data;

    /**
     * @param array<string,string|int|float|bool> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array<string,string|int|float|bool>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param string $fieldName
     * @return string|int|float|bool
     */
    public function getField(string $fieldName): string|int|float|bool
    {
        return $this->data[$fieldName];
    }
}

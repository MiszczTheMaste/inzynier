<?php

declare(strict_types=1);

namespace App\Core\Domain\ValueObject;

use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;

final class DbRow extends AbstractCollection
{
    /**
     * @return DbField[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * @throws ItemNotFoundInCollectionException
     */
    public function getFieldValue(string $name): string|int|float|bool
    {
        if (false === array_key_exists($name, $this->collection)) {
            throw new ItemNotFoundInCollectionException();
        }

        return $this->collection[$name]->getValue();
    }

    protected function getCollectionClass(): string
    {
        return DbField::class;
    }

    /**
     * @param DbField[] $collection
     * @throws InvalidObjectTypeInCollectionException
     */
    protected function validate(array $collection): void
    {
        foreach ($collection as $column => $field) {
            if (false === is_string($column)) {
                throw new InvalidObjectTypeInCollectionException();
            }
            if (false === $field instanceof DbField) {
                throw new InvalidObjectTypeInCollectionException();
            }
        }
    }
}

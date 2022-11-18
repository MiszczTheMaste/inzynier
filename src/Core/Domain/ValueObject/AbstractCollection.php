<?php

declare(strict_types=1);

namespace App\Core\Domain\ValueObject;

use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use ArrayIterator;
use Traversable;

abstract class AbstractCollection implements CollectionInterface
{
    /**
     * @var mixed[]
     */
    protected array $collection;

    /**
     * @throws InvalidObjectTypeInCollectionException
     */
    public function __construct(array $collection)
    {
        $this->validate($collection);
        $this->collection = $collection;
    }

    /**
     * @throws ItemNotFoundInCollectionException
     */
    public function getItem(mixed $key): mixed
    {
        if (false === array_key_exists($key, $this->getCollection())) {
            throw new ItemNotFoundInCollectionException();
        }

        return $this->getCollection()[$key];
    }

    public function collectionHasKey(string $key): bool
    {
        return array_key_exists($key, $this->getCollection());
    }

    public function isEmpty(): bool
    {
        return false === (bool) count($this->collection);
    }

    public function count(): int
    {
        return count($this->collection);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->collection);
    }

    abstract public function getCollection(): array;

    abstract protected function getCollectionClass(): string;

    /**
     * @throws InvalidObjectTypeInCollectionException
     */
    protected function validate(array $collection): void
    {
        foreach ($collection as $item) {
            if ($item::class !== $this->getCollectionClass()) {
                throw new InvalidObjectTypeInCollectionException();
            }
        }
    }
}

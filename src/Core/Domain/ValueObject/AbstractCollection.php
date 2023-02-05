<?php

declare(strict_types=1);

namespace App\Core\Domain\ValueObject;

use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use ArrayIterator;
use Traversable;

/**
 *
 */
abstract class AbstractCollection implements CollectionInterface
{
    /**
     * @var array<mixed,mixed>
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
     * @param string $key
     * @return bool
     */
    public function collectionHasKey(string $key): bool
    {
        return array_key_exists($key, $this->getCollection());
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return false === (bool) count($this->collection);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->collection);
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->collection);
    }

    /**
     * @return array
     */
    abstract public function getCollection(): array;

    /**
     * @return string
     */
    abstract protected function getCollectionClass(): string;

    /**
     * @throws InvalidObjectTypeInCollectionException
     */
    protected function validate(array $collection): void
    {
        foreach ($collection as $item) {
            if (is_a($item, $this->getCollectionClass(), true)) {
                continue;
            }

            throw new InvalidObjectTypeInCollectionException();
        }
    }
}

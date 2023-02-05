<?php

declare(strict_types=1);

namespace App\Core\Domain\Event;

use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\ValueObject\AbstractCollection;

/**
 *
 */
final class EventHandlerCollection extends AbstractCollection
{
    /**
     * @return EventHandler[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * @throws InvalidObjectTypeInCollectionException
     */
    public function addHandler(string $handlerFunction, string $eventNamespace): void
    {
        if (strlen($handlerFunction) === 0 || strlen($eventNamespace) === 0) {
            throw new InvalidObjectTypeInCollectionException();
        }
        $this->collection[$eventNamespace] = new EventHandler($eventNamespace, $handlerFunction);
    }

    /**
     * @param string $eventNamespace
     * @return EventHandler
     */
    public function getItem(string $eventNamespace): EventHandler
    {
        return $this->collection[$eventNamespace];
    }

    /**
     * @return string
     */
    protected function getCollectionClass(): string
    {
        return EventHandler::class;
    }
}

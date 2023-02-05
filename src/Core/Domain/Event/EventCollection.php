<?php

declare(strict_types=1);

namespace App\Core\Domain\Event;

use App\Core\Domain\ValueObject\AbstractCollection;

/**
 *
 */
final class EventCollection extends AbstractCollection
{
    /**
     * @return EventInterface[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * @param EventInterface $event
     * @return void
     */
    public function addEvent(EventInterface $event): void
    {
        $this->collection[] = $event;
    }

    /**
     * @return string
     */
    protected function getCollectionClass(): string
    {
        return EventInterface::class;
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Domain\Event;

use App\Core\Domain\ValueObject\AbstractCollection;

final class EventCollection extends AbstractCollection
{
    /**
     * @return EventInterface[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    public function addEvent(EventInterface $event): void
    {
        $this->collection[] = $event;
    }

    protected function getCollectionClass(): string
    {
        return EventInterface::class;
    }
}

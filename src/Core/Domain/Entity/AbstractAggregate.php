<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Core\Domain\Event\EventCollection;
use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\ValueObject\IdInterface;

/**
 *
 */
abstract class AbstractAggregate extends AbstractEntity
{
    private EventCollection $events;

    /**
     * @throws InvalidObjectTypeInCollectionException
     */
    public function __construct(IdInterface $id)
    {
        parent::__construct($id);
        $this->events = new EventCollection([]);
    }

    /**
     * @return EventCollection
     */
    public function getEvents(): EventCollection
    {
        return $this->events;
    }

    /**
     * @param EventInterface $event
     * @return void
     */
    public function raise(EventInterface $event): void
    {
        $this->events->addEvent($event);
    }
}

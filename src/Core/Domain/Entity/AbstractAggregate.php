<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Core\Domain\Event\EventCollection;
use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\ValueObject\IdInterface;

abstract class AbstractAggregate extends AbstractEntity
{
    private EventCollection $events;

    public function __construct(IdInterface $id)
    {
        parent::__construct($id);
        $this->events = new EventCollection([]);
    }

    public function getEvents(): EventCollection
    {
        return $this->events;
    }

    public function raise(EventInterface $event): void
    {
        $this->events->addEvent($event);
    }
}

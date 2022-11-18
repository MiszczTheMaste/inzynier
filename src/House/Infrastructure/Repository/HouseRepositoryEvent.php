<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Repository;

use App\Core\Domain\Entity\AbstractAggregate;
use App\Core\Domain\Event\EventHandlerCollection;
use App\Core\Domain\ValueObject\IdInterface;
use App\Core\Infrastructure\Repository\AbstractEventSQLRepository;
use App\House\Domain\Entity\House;
use App\House\Domain\Event\HouseCreatedEvent;
use App\House\Domain\Event\RoomCreatedEvent;
use App\House\Domain\Repository\HouseRepositoryInterface;

final class HouseRepositoryEvent extends AbstractEventSQLRepository implements HouseRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function implementedEvents(): EventHandlerCollection
    {
        $handlers = new EventHandlerCollection([]);
        $handlers->addHandler('handleHouseCreatedEvent', HouseCreatedEvent::class);
        $handlers->addHandler('handleRoomCreatedEvent', RoomCreatedEvent::class);

        return $handlers;
    }

    /**
     * @inheritDoc
     */
    public function persist(AbstractAggregate $aggregate): void
    {
        $events = $aggregate->getEvents();
        $this->handleEvents($events);

        foreach ($events as $event) {
            $this->getEventDispatcher()->dispatch($event);
        }
    }

    public function get(IdInterface $id): House
    {
    }
}

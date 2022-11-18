<?php

declare(strict_types=1);

namespace App\House\Domain\Entity;

use App\Core\Domain\Entity\AbstractAggregate;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\Event\ChoreCreatedEvent;
use App\House\Domain\Event\ChoreRemovedEvent;
use App\House\Domain\Event\HouseCreatedEvent;
use App\House\Domain\Event\HouseRemovedEvent;
use App\House\Domain\Event\RoomCreatedEvent;
use App\House\Domain\Event\RoomRemovedEvent;
use App\House\Domain\ValueObject\ChoreCollection;
use App\House\Domain\ValueObject\ChoreFulfilmentCollection;
use App\House\Domain\ValueObject\DaysInterval;
use App\House\Domain\ValueObject\Rate;
use App\House\Domain\ValueObject\RoomCollection;
use App\House\Domain\ValueObject\UserIdCollection;
use DateTimeImmutable;

final class House extends AbstractAggregate
{
    private RoomCollection $roomCollection;

    private UserIdCollection $users;

    private DateTimeImmutable $creationTime;

    private bool $removed;

    public function __construct(
        IdInterface        $id,
        RoomCollection     $roomCollection,
        UserIdCollection   $users,
        ?DateTimeImmutable $creationTime = null,
        bool $removed = false,
    )
    {
        parent::__construct($id);
        $this->roomCollection = $roomCollection;
        $this->users = $users;
        $this->creationTime = $creationTime ?? new DateTimeImmutable();
        $this->removed = $removed;

        if (is_null($creationTime)) {
            $this->raise(
                new HouseCreatedEvent(
                    $id,
                    $users,
                    $this->creationTime
                )
            );
        }
    }

    public function addRoom(Idinterface $id, string $name, IdInterface $iconId): void
    {
        $room = new Room(
            $id,
            $name,
            $iconId,
            new ChoreCollection([]),
            new DateTimeImmutable()
        );
        $this->roomCollection->addRoom($room);

        $this->raise(
            new RoomCreatedEvent(
                $room->getId(),
                $room->getName(),
                $room->getIconId(),
                $room->getCreationDate()
            )
        );
    }

    /**
     * @throws InvalidObjectTypeInCollectionException
     */
    public function addChore(
        IdInterface $id,
        IdInterface $initialFulfilmentId,
        IdInterface $roomId,
        DaysInterval $daysInterval,
        DateTimeImmutable $initialDate,
        IdInterface $iconId,
        IdInterface $userId,
    ): void {
        $chore = new Chore(
            $id,
            $roomId,
            $daysInterval,
            $iconId,
            $userId,
            new ChoreFulfilmentCollection([
                    new ChoreFulfilment(
                        $initialFulfilmentId,
                        $initialDate,
                        false,
                        Rate::createWithZeroValue()
                    )
                ])
        );

        $this->raise(
            new ChoreCreatedEvent(
                $chore->getId(),
                $chore->getDaysInterval(),
                $chore->getIconId(),
                $chore->getUserId(),
                $chore->getChoreFulfilmentCollection()->getInitial()->getId(),
                $chore->getChoreFulfilmentCollection()->getInitial()->getDeadline()
            )
        );
    }

    public function removeHouse(): void
    {
        $this->removed = true;

        $this->raise(new HouseRemovedEvent($this->getId()));
    }

    public function removeRoom(IdInterface $id): void
    {
        $room = $this->getRoom($id);
        $room->remove();

        $this->raise(new RoomRemovedEvent($this->getId()));
    }

    public function removeChore(IdInterface $roomId, IdInterface $choreId): void
    {
        $room = $this->getRoom($roomId);
        $room->removeChore($choreId);

        $this->raise(new ChoreRemovedEvent($choreId));
    }

    public function getRoom(IdInterface $id): Room
    {
        return $this->roomCollection->get($id);
    }

    public function getUsers(): UserIdCollection
    {
        return $this->users;
    }
}

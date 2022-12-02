<?php

declare(strict_types=1);

namespace App\House\Domain\Entity;

use App\Core\Domain\Entity\AbstractAggregate;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\Event\ChoreCreatedEvent;
use App\House\Domain\Event\ChoreRemovedEvent;
use App\House\Domain\Event\FulfilmentAddedEvent;
use App\House\Domain\Event\FulfilmentFinishedEvent;
use App\House\Domain\Event\HouseCreatedEvent;
use App\House\Domain\Event\HouseRemovedEvent;
use App\House\Domain\Event\RoomCreatedEvent;
use App\House\Domain\Event\RoomRemovedEvent;
use App\House\Domain\Event\UserAddedToHouseEvent;
use App\House\Domain\Exception\ChoreNotFoundException;
use App\House\Domain\Exception\RoomNotFoundException;
use App\House\Domain\ValueObject\ChoreCollection;
use App\House\Domain\ValueObject\ChoreFulfilmentCollection;
use App\House\Domain\ValueObject\DaysInterval;
use App\House\Domain\ValueObject\Rate;
use App\House\Domain\ValueObject\RoomCollection;
use App\House\Domain\ValueObject\UserIdCollection;
use DateTimeImmutable;

/**
 *
 */
final class House extends AbstractAggregate
{
    /**
     * @var RoomCollection
     */
    private RoomCollection $roomCollection;
    /**
     * @var IdInterface
     */
    private IdInterface $owner;
    /**
     * @var IdInterface
     */
    private IdInterface $iconId;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var UserIdCollection
     */
    private UserIdCollection $users;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $creationDate;

    /**
     * @var bool
     */
    private bool $removed;

    /**
     * @param IdInterface $id
     * @param IdInterface $owner
     * @param IdInterface $iconId
     * @param string $name
     * @param RoomCollection $roomCollection
     * @param UserIdCollection $users
     * @param DateTimeImmutable|null $creationDate
     * @param bool $removed
     * @throws InvalidObjectTypeInCollectionException
     */
    public function __construct(
        IdInterface $id,
        IdInterface $owner,
        IdInterface $iconId,
        string $name,
        RoomCollection $roomCollection,
        UserIdCollection $users,
        ?DateTimeImmutable $creationDate = null,
        bool $removed = false,
    ) {
        parent::__construct($id);
        $this->owner = $owner;
        $this->iconId = $iconId;
        $this->name = $name;
        $this->roomCollection = $roomCollection;
        $this->users = $users;
        $this->creationDate = $creationDate ?? new DateTimeImmutable();
        $this->removed = $removed;

        if (is_null($creationDate)) {
            $this->raise(
                new HouseCreatedEvent(
                    $id,
                    $owner,
                    $iconId,
                    $name,
                    $users,
                    $this->creationDate
                )
            );
        }
    }

    /**
     * @param IdInterface $id
     * @param string $name
     * @param IdInterface $iconId
     * @return void
     * @throws InvalidObjectTypeInCollectionException
     */
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
                $this->getId(),
                $room->getName(),
                $room->getIconId(),
                $room->getCreationDate()
            )
        );
    }

    /**
     * @throws InvalidObjectTypeInCollectionException
     * @throws RoomNotFoundException
     */
    public function addChore(
        IdInterface $id,
        IdInterface $initialFulfilmentId,
        IdInterface $roomId,
        DaysInterval $daysInterval,
        DateTimeImmutable $initialDate,
        IdInterface $iconId,
        IdInterface $userId,
        string $name
    ): void {
        $chore = new Chore(
            $id,
            $daysInterval,
            $iconId,
            $userId,
            $name,
            new ChoreFulfilmentCollection([
                new ChoreFulfilment(
                    $initialFulfilmentId,
                    $initialDate,
                    false,
                    Rate::createWithZeroValue()
                )
            ]),
            new DateTimeImmutable(),
        );

        $this->getRoom($roomId)->addChore($chore);

        $this->raise(
            new ChoreCreatedEvent(
                $chore->getId(),
                $roomId,
                $chore->getDaysInterval(),
                $chore->getIconId(),
                $chore->getUserId(),
                $chore->getChoreFulfilmentCollection()->getInitial()->getId(),
                $chore->getName(),
                $chore->getChoreFulfilmentCollection()->getInitial()->getDeadline(),
                $chore->getCreationDate()
            )
        );
    }

    public function addUser(IdInterface $userId): void
    {
        $this->users->add($userId);

        $this->raise(
            new UserAddedToHouseEvent(
                $this->id,
                $userId
            )
        );
    }

    public function fulfilChore(IdInterface $roomId, IdInterface $choreId, IdInterface $fulfilmentId, IdInterface $nextFulfilmentId): void
    {
        $chore = $this->getRoom($roomId)->getChoreCollection()->get($choreId);
        $fulfilment = $chore->getChoreFulfilmentCollection()->get($fulfilmentId);
        $fulfilment->finish();

        $this->raise(new FulfilmentFinishedEvent($fulfilmentId));

        $newFulfilment = new ChoreFulfilment(
            $nextFulfilmentId,
            new DateTimeImmutable($fulfilment->getDeadline()->format('Y-m-d') .' +'. $chore->getDaysInterval()->toInt() . 'days'),
            false,
            Rate::createWithZeroValue()
        );

        $chore->getChoreFulfilmentCollection()->add($newFulfilment);

        $this->raise(
            new FulfilmentAddedEvent(
                $newFulfilment->getId(),
                $chore->getId(),
                $newFulfilment->getDeadline(),
            )
        );
    }

    /**
     * @return void
     */
    public function removeHouse(): void
    {
        $this->removed = true;

        $this->raise(new HouseRemovedEvent($this->getId()));
    }

    /**
     * @param IdInterface $id
     * @return void
     * @throws RoomNotFoundException
     */
    public function removeRoom(IdInterface $id): void
    {
        $room = $this->getRoom($id);
        $room->remove();

        $this->raise(new RoomRemovedEvent($this->getId()));
    }

    /**
     * @param IdInterface $roomId
     * @param IdInterface $choreId
     * @return void
     * @throws RoomNotFoundException
     * @throws ChoreNotFoundException
     */
    public function removeChore(IdInterface $roomId, IdInterface $choreId): void
    {
        $room = $this->getRoom($roomId);
        $room->removeChore($choreId);

        $this->raise(new ChoreRemovedEvent($choreId));
    }

    /**
     * @param IdInterface $id
     * @return Room
     * @throws RoomNotFoundException
     */
    public function getRoom(IdInterface $id): Room
    {
        return $this->roomCollection->get($id);
    }

    /**
     * @return UserIdCollection
     */
    public function getUsers(): UserIdCollection
    {
        return $this->users;
    }

    /**
     * @return RoomCollection
     */
    public function getRoomCollection(): RoomCollection
    {
        return $this->roomCollection;
    }

    /**
     * @return IdInterface
     */
    public function getOwner(): IdInterface
    {
        return $this->owner;
    }

    /**
     * @return IdInterface
     */
    public function getIconId(): IdInterface
    {
        return $this->iconId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }

    /**
     * @return bool
     */
    public function isRemoved(): bool
    {
        return $this->removed;
    }
}

<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Repository;

use App\Core\Domain\Entity\AbstractAggregate;
use App\Core\Domain\Event\EventHandlerCollection;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidIdException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Domain\ValueObject\DbRow;
use App\Core\Domain\ValueObject\DbRowCollection;
use App\Core\Domain\ValueObject\IdInterface;
use App\Core\Domain\ValueObject\Uuid;
use App\Core\Infrastructure\Repository\AbstractEventSQLRepository;
use App\House\Domain\Entity\Chore;
use App\House\Domain\Entity\ChoreFulfilment;
use App\House\Domain\Entity\House;
use App\House\Domain\Entity\Room;
use App\House\Domain\Event\ChoreCreatedEvent;
use App\House\Domain\Event\ChoreRemovedEvent;
use App\House\Domain\Event\HouseCreatedEvent;
use App\House\Domain\Event\HouseRemovedEvent;
use App\House\Domain\Event\RoomCreatedEvent;
use App\House\Domain\Event\RoomRemovedEvent;
use App\House\Domain\Event\UserAddedToHouseEvent;
use App\House\Domain\Exception\InvalidDaysIntervalException;
use App\House\Domain\Exception\RoomNotFoundException;
use App\House\Domain\Repository\HouseRepositoryInterface;
use App\House\Domain\ValueObject\ChoreCollection;
use App\House\Domain\ValueObject\ChoreFulfilmentCollection;
use App\House\Domain\ValueObject\DaysInterval;
use App\House\Domain\ValueObject\Rate;
use App\House\Domain\ValueObject\RoomCollection;
use App\House\Domain\ValueObject\UserIdCollection;
use DateTimeImmutable;
use Exception;

/**
 *
 */
final class HouseEventRepository extends AbstractEventSQLRepository implements HouseRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function implementedEvents(): EventHandlerCollection
    {
        $handlers = new EventHandlerCollection([]);
        $handlers->addHandler('handleHouseCreatedEvent', HouseCreatedEvent::class);
        $handlers->addHandler('handleRoomCreatedEvent', RoomCreatedEvent::class);
        $handlers->addHandler('handleChoreCreatedEvent', ChoreCreatedEvent::class);
        $handlers->addHandler('handleChoreRemovedEvent', ChoreRemovedEvent::class);
        $handlers->addHandler('handleHouseRemovedEvent', HouseRemovedEvent::class);
        $handlers->addHandler('handleRoomRemovedEvent', RoomRemovedEvent::class);
        $handlers->addHandler('handleUserAddedToHouseEvent', UserAddedToHouseEvent::class);

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

    /**
     * @param IdInterface $id
     * @return House
     * @throws DatabaseException
     * @throws RoomNotFoundException
     */
    public function get(IdInterface $id): House
    {
        $result = $this->fetch(
            'SELECT
            houses.id,
            houses.icon_id,
            houses.owner_id,
            houses.name,
            houses.creation_date,
            houses.removed
            FROM houses
            WHERE id = :id AND removed = false',
            [
                ':id' => $id->toString()
            ]
        );

        if ($result->isEmpty()) {
            throw new RoomNotFoundException();
        }

        try {
            return $this->createHouse($id, $result);
        } catch (Exception) {
            throw new DatabaseException();
        }
    }

    /**
     * @param HouseCreatedEvent $event
     * @return void
     * @throws DatabaseException
     */
    protected function handleHouseCreatedEvent(HouseCreatedEvent $event): void
    {
        $this->execute(
            'INSERT INTO houses 
                (id, icon_id, owner_id, name, creation_date, removed)
                VALUES
                (:id, :icon_id, :owner_id, :name, :creation_date, false)
                ',
            [
                ':id' => $event->getId()->toString(),
                ':icon_id' => $event->getIconId()->toString(),
                ':owner_id' => $event->getOwner()->toString(),
                ':name' => $event->getName(),
                ':creation_date' => $event->getCreationDate()->format('Y-m-d H:i:s'),
            ]
        );

        $this->execute(
            'INSERT INTO houses_users 
                (house_id, user_id)
                VALUES
                (:house_id, :user_id)
                ',
            [
                ':house_id' => $event->getId()->toString(),
                ':user_id' => $event->getOwner()->toString(),
            ]
        );
    }

    protected function handleRoomCreatedEvent(RoomCreatedEvent $event): void
    {
        $this->execute(
            'INSERT INTO rooms 
                (id, house_id, name, icon_id, creation_date, removed)
                VALUES 
                (:id, :house_id, :name, :icon_id, :creation_date, false)',
            [
                ':id' => $event->getId()->toString(),
                ':house_id' => $event->getHouseId()->toString(),
                ':name' => $event->getName(),
                ':icon_id' => $event->getIconId()->toString(),
                ':creation_date' => $event->getCreationDate()->format('Y-m-d H:i:s'),
            ]
        );
    }


    protected function handleChoreCreatedEvent(ChoreCreatedEvent $event): void
    {
        $this->execute(
            'INSERT INTO chores 
                (id, room_id, icon_id, user_id, days_interval, name, creation_date, removed)
                VALUES 
                (:id, :room_id, :icon_id, :user_id, :days_interval, :name, :creation_date, false)',
            [
                ':id' => $event->getId()->toString(),
                ':room_id' => $event->getRoomId()->toString(),
                ':icon_id' => $event->getIconId()->toString(),
                ':user_id' => $event->getUserId()->toString(),
                ':name' => $event->getName(),
                ':days_interval' => $event->getDaysInterval()->toInt(),
                ':creation_date' => $event->getCreationDate()->format('Y-m-d H:i:s'),
            ]
        );

        $this->execute(
            'INSERT INTO chores_fulfilments
                (id, chore_id, rate, finished, deadline) 
                VALUES 
                (:id, :chore_id, 0, false, :deadline) ',
            [
                ':id' => $event->getFulfilmentId()->toString(),
                ':chore_id' => $event->getId()->toString(),
                ':deadline' => $event->getFulfilmentDeadline()->format('Y-m-d H:i:s'),
            ]
        );
    }

    protected function handleUserAddedToHouseEvent(UserAddedToHouseEvent $event): void
    {
        $this->execute(
            'INSERT INTO houses_users 
                (house_id, user_id)
                VALUES 
                (:house_id, :user_id)',
            [
                ':house_id' => $event->getHouseId()->toString(),
                ':user_id' => $event->getUserId()->toString(),
            ]
        );
    }

    /**
     * @param IdInterface $houseId
     * @param DbRow $dbRow
     * @return House
     * @throws DatabaseException
     * @throws InvalidDaysIntervalException
     * @throws InvalidIdException
     * @throws InvalidObjectTypeInCollectionException
     * @throws ItemNotFoundInCollectionException
     * @throws Exception
     */
    private function createHouse(IdInterface $houseId, DbRow $dbRow): House
    {
        return new House(
            Uuid::fromString((string)$dbRow->getFieldValue('id')),
            Uuid::fromString((string)$dbRow->getFieldValue('owner_id')),
            Uuid::fromString((string)$dbRow->getFieldValue('icon_id')),
            (string)$dbRow->getFieldValue('name'),
            $this->getRooms($houseId),
            $this->getHouseUsers($houseId),
            new DateTimeImmutable((string)$dbRow->getFieldValue('creation_date')),
            (bool)$dbRow->getFieldValue('removed')
        );
    }

    /**
     * @param IdInterface $houseId
     * @return RoomCollection
     * @throws DatabaseException
     * @throws InvalidDaysIntervalException
     * @throws InvalidIdException
     * @throws InvalidObjectTypeInCollectionException
     * @throws ItemNotFoundInCollectionException
     */
    private function getRooms(IdInterface $houseId): RoomCollection
    {
        $result = $this->fetchAll(
            'SELECT 
            id,
            icon_id,
            name,
            creation_date,
            house_id,
            removed
            FROM rooms
            WHERE house_id = :house_id AND removed = false',
            [':house_id' => $houseId->toString()]
        );

        return $this->createRoomCollection($result);
    }

    /**
     * @param DbRowCollection $result
     * @return RoomCollection
     * @throws DatabaseException
     * @throws InvalidDaysIntervalException
     * @throws InvalidIdException
     * @throws InvalidObjectTypeInCollectionException
     * @throws ItemNotFoundInCollectionException
     * @throws Exception
     */
    private function createRoomCollection(DbRowCollection $result): RoomCollection
    {
        $collection = [];
        foreach ($result->getCollection() as $row) {
            $collection[] = new Room(
                Uuid::fromString((string)$row->getFieldValue('id')),
                (string)$row->getFieldValue('name'),
                Uuid::fromString((string)$row->getFieldValue('icon_id')),
                $this->getChores(Uuid::fromString((string)$row->getFieldValue('id'))),
                new DateTimeImmutable((string)$row->getFieldValue('creation_date')),
                (bool)$row->getFieldValue('removed'),
            );
        }

        return new RoomCollection($collection);
    }

    /**
     * @param IdInterface $roomId
     * @return ChoreCollection
     * @throws DatabaseException
     * @throws InvalidDaysIntervalException
     * @throws InvalidIdException
     * @throws InvalidObjectTypeInCollectionException
     * @throws ItemNotFoundInCollectionException
     */
    private function getChores(IdInterface $roomId): ChoreCollection
    {
        $result = $this->fetchAll(
            'SELECT
        id,
        icon_id,
        user_id,
        creation_date,
        days_interval,
        removed
        FROM chores
        WHERE room_id = :room_id AND removed = false',
            [':room_id' => $roomId->toString()]
        );

        return $this->createChoreCollection($result);
    }

    /**
     * @param DbRowCollection $result
     * @return ChoreCollection
     * @throws InvalidIdException
     * @throws ItemNotFoundInCollectionException
     * @throws InvalidObjectTypeInCollectionException
     * @throws InvalidDaysIntervalException
     * @throws DatabaseException
     */
    private function createChoreCollection(DbRowCollection $result): ChoreCollection
    {
        $collection = [];
        foreach ($result->getCollection() as $row) {
            $collection[] = new Chore(
                Uuid::fromString((string)$row->getFieldValue('id')),
                new DaysInterval((int)$row->getFieldValue('days_interval')),
                Uuid::fromString((string)$row->getFieldValue('icon_id')),
                Uuid::fromString((string)$row->getFieldValue('user_id')),
                (string)$row->getFieldValue('name'),
                $this->getChoreFulfilment(Uuid::fromString((string)$row->getFieldValue('id'))),
                new DateTimeImmutable($row->getFieldValue('creation_date')),
                (bool)$row->getFieldValue('removed'),
            );
        }

        return new ChoreCollection($collection);
    }

    /**
     * @param IdInterface $choreId
     * @return ChoreFulfilmentCollection
     * @throws DatabaseException
     * @throws InvalidIdException
     * @throws InvalidObjectTypeInCollectionException
     * @throws ItemNotFoundInCollectionException
     */
    private function getChoreFulfilment(IdInterface $choreId): ChoreFulfilmentCollection
    {
        $result = $this->fetchAll(
            'SELECT
            id,
            rate,
            finished,
            deadline
            FROM chores_fulfilments
            WHERE chore_id = :chore_id',
            [':chore_id' => $choreId->toString()]
        );

        return $this->createChoreFulfilmentCollection($result);
    }

    /**
     * @param DbRowCollection $result
     * @return ChoreFulfilmentCollection
     * @throws InvalidIdException
     * @throws ItemNotFoundInCollectionException
     * @throws InvalidObjectTypeInCollectionException
     * @throws Exception
     */
    private function createChoreFulfilmentCollection(DbRowCollection $result): ChoreFulfilmentCollection
    {
        $collection = [];
        foreach ($result->getCollection() as $row) {
            $collection[] = new ChoreFulfilment(
                Uuid::fromString((string)$row->getFieldValue('id')),
                new DateTimeImmutable((string)$row->getFieldValue('deadline')),
                (bool)$row->getFieldValue('finished'),
                new Rate((int)$row->getFieldValue('rate'))
            );
        }

        return new ChoreFulfilmentCollection($collection);
    }

    /**
     * @param IdInterface $houseId
     * @return UserIdCollection
     * @throws DatabaseException
     * @throws InvalidIdException
     * @throws InvalidObjectTypeInCollectionException
     * @throws ItemNotFoundInCollectionException
     */
    private function getHouseUsers(IdInterface $houseId): UserIdCollection
    {
        $result = $this->fetchAll(
            'SELECT user_id FROM houses_users WHERE house_id = :house_id',
            [':house_id' => $houseId->toString()]
        );

        return $this->createUserIdCollection($result);
    }


    /**
     * @param DbRowCollection $result
     * @return UserIdCollection
     * @throws InvalidIdException
     * @throws ItemNotFoundInCollectionException
     * @throws InvalidObjectTypeInCollectionException
     */
    private function createUserIdCollection(DbRowCollection $result): UserIdCollection
    {
        $collection = [];
        foreach ($result->getCollection() as $row) {
            $collection[] = Uuid::fromString((string)$row->getFieldValue('user_id'));
        }

        return new UserIdCollection($collection);
    }
}

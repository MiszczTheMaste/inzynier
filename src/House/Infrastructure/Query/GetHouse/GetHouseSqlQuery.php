<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Query\GetHouse;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Infrastructure\Query\AbstractSqlQuery;
use App\House\Application\DTO\UserDTO;
use App\House\Application\DTO\UserDTOCollection;
use App\House\Application\UseCase\GetHouse\DTO\HouseDTO;
use App\House\Application\UseCase\GetHouse\DTO\RoomDTO;
use App\House\Application\UseCase\GetHouse\DTO\RoomDTOCollection;
use App\House\Application\UseCase\GetHouse\Query\GetHouseQueryInterface;

/**
 *
 */
final class GetHouseSqlQuery extends AbstractSqlQuery implements GetHouseQueryInterface
{
    /**
     * @throws DatabaseException
     * @throws ItemNotFoundInCollectionException
     * @throws InvalidObjectTypeInCollectionException
     */
    public function execute(string $id): HouseDTO
    {
        $house = $this->fetch(
            'SELECT name
                FROM houses 
                WHERE id = :id',
            [':id' => $id]
        );

        $users = $this->fetchAll(
            'SELECT id, username 
                FROM users
                INNER JOIN houses_users hu on users.id = hu.user_id
                WHERE house_id = :house_id
                ',
            [':house_id' => $id]
        );

        $userCollection = [];
        foreach ($users->getCollection() as $row) {
            $userCollection[] = new UserDTO(
                (string)$row->getFieldValue('id'),
                (string)$row->getFieldValue('username'),
            );
        }

        $rooms = $this->fetchAll(
            'SELECT rooms.id, rooms.name, icons.src
                FROM rooms
                INNER JOIN icons on rooms.icon_id = icons.icon_id
                WHERE house_id = :house_id
                ',
            [':house_id' => $id]
        );

        $roomCollection = [];
        foreach ($rooms->getCollection() as $row) {
            $choresAfterDeadline = $this->fetch(
                'SELECT count(1) as after_deadline
                FROM chores_fulfilments 
                JOIN chores c on c.id = chores_fulfilments.chore_id 
                JOIN rooms r on c.room_id = r.id
                WHERE r.id = :room_id AND chores_fulfilments.finished = false AND chores_fulfilments.deadline < NOW()',
                ['room_id' => (string)$row->getFieldValue('id')]
            );

            $roomCollection[] = new RoomDTO(
                (string)$row->getFieldValue('id'),
                (string)$row->getFieldValue('name'),
                (string)$row->getFieldValue('src'),
                (int) $choresAfterDeadline->getFieldValue('after_deadline'),
            );
        }

        return new HouseDTO(
            $id,
            $house->getFieldValue('name'),
            new UserDTOCollection($userCollection),
            new RoomDTOCollection($roomCollection),
        );
    }
}

<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Query\GetHouse;

use App\Core\Infrastructure\Query\AbstractSqlQuery;
use App\House\Application\UseCase\GetHouse\DTO\RoomDTO;
use App\House\Application\UseCase\GetHouse\DTO\RoomDTOCollection;
use App\House\Application\UseCase\GetHouse\DTO\HouseDTO;
use App\House\Application\UseCase\GetHouse\DTO\UserDTO;
use App\House\Application\UseCase\GetHouse\DTO\UserDTOCollection;
use App\House\Application\UseCase\GetHouse\Query\GetHouseQueryInterface;

final class GetHouseSqlQuery extends AbstractSqlQuery implements GetHouseQueryInterface
{
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
            $roomCollection[] = new RoomDTO(
                (string)$row->getFieldValue('id'),
                (string)$row->getFieldValue('name'),
                (string)$row->getFieldValue('src'),
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

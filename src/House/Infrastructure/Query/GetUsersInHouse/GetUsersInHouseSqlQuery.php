<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Query\GetUsersInHouse;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Infrastructure\Query\AbstractSqlQuery;
use App\House\Application\DTO\UserDTO;
use App\House\Application\DTO\UserDTOCollection;
use App\House\Application\UseCase\GetUsersInHouse\Query\GetUsersInHouseQueryInterface;

final class GetUsersInHouseSqlQuery extends AbstractSqlQuery implements GetUsersInHouseQueryInterface
{
    /**
     * @throws DatabaseException
     * @throws ItemNotFoundInCollectionException
     * @throws InvalidObjectTypeInCollectionException
     */
    public function execute(string $houseId): UserDTOCollection
    {
        $users = $this->fetchAll(
            'SELECT username, users.id FROM users INNER JOIN houses_users hu on users.id = hu.user_id WHERE hu.house_id = :house_id',
            [':house_id' => $houseId]
        );

        $userCollection = [];
        foreach ($users->getCollection() as $row) {
            $userCollection[] = new UserDTO(
                (string) $row->getFieldValue('id'),
                (string) $row->getFieldValue('username'),
            );
        }


        return new UserDTOCollection($userCollection);
    }
}

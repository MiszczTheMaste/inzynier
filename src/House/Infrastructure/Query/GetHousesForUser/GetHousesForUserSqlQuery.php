<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Query\GetHousesForUser;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Infrastructure\Query\AbstractSqlQuery;
use App\House\Application\Query\GetHousesForUserQueryInterface;
use App\House\Application\UseCase\GetHousesForUser\DTO\HouseDTO;
use App\House\Application\UseCase\GetHousesForUser\DTO\HouseDTOCollection;

final class GetHousesForUserSqlQuery extends AbstractSqlQuery implements GetHousesForUserQueryInterface
{
    /**
     * @throws DatabaseException
     * @throws ItemNotFoundInCollectionException
     * @throws InvalidObjectTypeInCollectionException
     */
    public function execute(string $userId): HouseDTOCollection
    {
        $result = $this->fetchAll(
            'SELECT houses.id, name, icons.src
                FROM houses 
                INNER JOIN houses_users ON houses.id = houses_users.house_id
                INNER JOIN icons ON houses.icon_id = icons.icon_id
                WHERE houses_users.user_id = :user_id
                ORDER BY creation_date',
            [':user_id' => $userId]
        );

        $collection = [];
        foreach ($result->getCollection() as $row) {
            $collection[] = new HouseDTO(
                (string)$row->getFieldValue('id'),
                (string)$row->getFieldValue('name'),
                (string)$row->getFieldValue('src'),
            );
        }

        return new HouseDTOCollection($collection);
    }
}

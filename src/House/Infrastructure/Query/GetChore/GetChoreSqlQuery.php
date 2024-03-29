<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Query\GetChore;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Infrastructure\Query\AbstractSqlQuery;
use App\House\Application\UseCase\GetChore\DTO\ChoreDTO;
use App\House\Application\UseCase\GetChore\DTO\ChoreFulfilmentDTO;
use App\House\Application\UseCase\GetChore\DTO\ChoreFulfilmentDTOCollection;
use App\House\Application\UseCase\GetChore\Query\GetChoreQueryInterface;
use DateTimeImmutable;
use Exception;

/**
 *
 */
final class GetChoreSqlQuery extends AbstractSqlQuery implements GetChoreQueryInterface
{
    /**
     * @throws DatabaseException
     * @throws ItemNotFoundInCollectionException
     * @throws InvalidObjectTypeInCollectionException
     * @throws Exception
     */
    public function execute(string $choreId): ChoreDTO
    {
        $chore = $this->fetch(
            'SELECT chores.id, chores.name, chores.days_interval, users.username, users.id as user_id
            FROM chores
            INNER JOIN users on chores.user_id = users.id
            WHERE chores.id = :chore_id',
            ['chore_id' => $choreId]
        );

        $fulfilments = $this->fetchAll(
            'SELECT deadline, finished, id, rate
                FROM chores_fulfilments 
                WHERE chore_id = :chore_id',
            [
                ':chore_id' => $choreId
            ]
        );

        $fulfilmentCollection = [];
        foreach ($fulfilments->getCollection() as $row) {
            $deadline = new DateTimeImmutable((string)$row->getFieldValue('deadline'));
            $fulfilmentCollection[] = new ChoreFulfilmentDTO(
                (string) $row->getFieldValue('id'),
                $deadline->format('d-m-Y'),
                (bool)$row->getFieldValue('finished'),
                (int)$row->getFieldValue('rate'),
            );
        }

        $fulfilmentCollection = new ChoreFulfilmentDTOCollection($fulfilmentCollection);

        return new ChoreDTO(
            (string)$chore->getFieldValue('id'),
            (string)$chore->getFieldValue('name'),
            (int)$chore->getFieldValue('days_interval'),
            (string)$chore->getFieldValue('username'),
            (string)$chore->getFieldValue('user_id'),
            $fulfilmentCollection,
            $fulfilmentCollection->getActive(),
        );
    }
}

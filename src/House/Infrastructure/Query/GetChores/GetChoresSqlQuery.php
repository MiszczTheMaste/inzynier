<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Query\GetChores;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Infrastructure\Query\AbstractSqlQuery;
use App\House\Application\UseCase\GetRoom\DTO\ChoreDTO;
use App\House\Application\UseCase\GetRoom\DTO\ChoreDTOCollection;
use App\House\Application\UseCase\GetRoom\Query\GetChoresQueryInterface;
use DateTimeImmutable;
use Exception;

/**
 *
 */
final class GetChoresSqlQuery extends AbstractSqlQuery implements GetChoresQueryInterface
{
    /**
     * @throws DatabaseException
     * @throws ItemNotFoundInCollectionException
     * @throws InvalidObjectTypeInCollectionException
     * @throws Exception
     */
    public function execute(string $roomId): ChoreDTOCollection
    {
        $result = $this->fetchAll(
            'SELECT chores.id, chores.name, chores.days_interval, users.username 
            FROM chores INNER JOIN users on chores.user_id = users.id
            WHERE room_id = :room_id',
            [
                ':room_id' => $roomId
            ]
        );


        $collection = [];
        foreach ($result->getCollection() as $row) {
            $deadline = $this->fetch(
                'SELECT deadline 
                FROM chores_fulfilments 
                WHERE chore_id = :chore_id AND finished = false',
                [
                    ':chore_id' => (string)$row->getFieldValue('id')
                ]
            );
            $collection[] = new ChoreDTO(
                (string)$row->getFieldValue('id'),
                (string)$row->getFieldValue('name'),
                new DateTimeImmutable($deadline->getFieldValue('deadline')),
                (int)$row->getFieldValue('days_interval'),
                (string)$row->getFieldValue('username'),
            );
        }

        return new ChoreDTOCollection($collection);
    }
}

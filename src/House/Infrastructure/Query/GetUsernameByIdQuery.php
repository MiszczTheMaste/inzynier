<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Query;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Infrastructure\Query\AbstractSqlQuery;
use App\House\Application\Query\GetUsernameByIdQueryInterface;

/**
 *
 */
final class GetUsernameByIdQuery extends AbstractSqlQuery implements GetUsernameByIdQueryInterface
{
    /**
     * @throws DatabaseException
     * @throws ItemNotFoundInCollectionException
     */
    public function execute(string $id): string
    {
        $result = $this->fetch(
            'SELECT username FROM users WHERE id = :id',
            [':id' => $id]
        );

        return (string) $result->getFieldValue('username');
    }
}

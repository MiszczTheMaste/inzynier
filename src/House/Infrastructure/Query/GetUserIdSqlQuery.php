<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Query;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Infrastructure\Query\AbstractSqlQuery;
use App\House\Application\Query\GetUserIdQueryInterface;

/**
 *
 */
final class GetUserIdSqlQuery extends AbstractSqlQuery implements GetUserIdQueryInterface
{
    /**
     * @throws DatabaseException
     * @throws ItemNotFoundInCollectionException
     */
    public function execute(string $username): string
    {
        $result = $this->fetch(
            'SELECT id FROM users WHERE username = :username',
            [':username' => $username]
        );

        return (string) $result->getFieldValue('id');
    }
}

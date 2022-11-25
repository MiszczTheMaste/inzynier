<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Query;

use App\Core\Infrastructure\Query\AbstractSqlQuery;
use App\House\Application\Query\GetRoomNameQueryInterface;

final class GetRoomNameSqlQuery extends AbstractSqlQuery implements GetRoomNameQueryInterface
{
    public function execute(string $id): string
    {
        $result = $this->fetch(
            'SELECT name FROM rooms WHERE id = :id',
            ['id' => $id]
        );

        return (string) $result->getFieldValue('name');
    }
}

<?php

declare(strict_types=1);

namespace App\House\Application\Query;

use App\Core\Domain\Exception\DatabaseException;

interface GetUserIdQueryInterface
{
    /**
     * @return string
     * @throws DatabaseException
     */
    public function execute(): string;
}
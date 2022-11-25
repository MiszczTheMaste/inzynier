<?php

declare(strict_types=1);

namespace App\Auth\Application\Query;

use App\Core\Domain\Exception\DatabaseException;

interface GetCurrentlyLoggedInUserIdQueryInterface
{
    /**
     * @return string|null
     * @throws DatabaseException
     */
    public function execute(): ?string;
}

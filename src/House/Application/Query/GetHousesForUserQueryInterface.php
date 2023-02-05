<?php

declare(strict_types=1);

namespace App\House\Application\Query;

use App\House\Application\UseCase\GetHousesForUser\DTO\HouseDTOCollection;

/**
 *
 */
interface GetHousesForUserQueryInterface
{
    /**
     * @param string $userId
     * @return HouseDTOCollection
     */
    public function execute(string $userId): HouseDTOCollection;
}

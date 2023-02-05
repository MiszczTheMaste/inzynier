<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetUsersInHouse\Query;

use App\House\Application\DTO\UserDTOCollection;

/**
 *
 */
interface GetUsersInHouseQueryInterface
{
    /**
     * @param string $houseId
     * @return UserDTOCollection
     */
    public function execute(string $houseId): UserDTOCollection;
}

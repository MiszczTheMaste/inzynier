<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHouse\Query;

use App\House\Application\UseCase\GetHouse\DTO\HouseDTO;

interface GetHouseQueryInterface
{
    public function execute(string $id): HouseDTO;
}

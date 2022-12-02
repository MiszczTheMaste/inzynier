<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetUsersInHouse;

final class GetUsersInHouseRequest
{
    private string $houseId;

    /**
     * @param string $houseId
     */
    public function __construct(string $houseId)
    {
        $this->houseId = $houseId;
    }

    /**
     * @return string
     */
    public function getHouseId(): string
    {
        return $this->houseId;
    }
}

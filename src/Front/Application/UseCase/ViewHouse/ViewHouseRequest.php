<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewHouse;

/**
 *
 */
final class ViewHouseRequest
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

<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\AddNewFulfilment;

/**
 *
 */
final class AddNewFulfilmentRequest
{
    private string $houseId;

    private string $roomId;

    private string $choreId;

    private string $fulfilmentId;

    /**
     * @param string $houseId
     * @param string $roomId
     * @param string $choreId
     * @param string $fulfilmentId
     */
    public function __construct(string $houseId, string $roomId, string $choreId, string $fulfilmentId)
    {
        $this->houseId = $houseId;
        $this->roomId = $roomId;
        $this->choreId = $choreId;
        $this->fulfilmentId = $fulfilmentId;
    }

    /**
     * @return string
     */
    public function getHouseId(): string
    {
        return $this->houseId;
    }

    /**
     * @return string
     */
    public function getRoomId(): string
    {
        return $this->roomId;
    }

    /**
     * @return string
     */
    public function getChoreId(): string
    {
        return $this->choreId;
    }

    /**
     * @return string
     */
    public function getFulfilmentId(): string
    {
        return $this->fulfilmentId;
    }
}

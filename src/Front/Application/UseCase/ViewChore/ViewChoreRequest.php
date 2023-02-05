<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewChore;

/**
 *
 */
final class ViewChoreRequest
{
    private string $houseId;

    private string $roomId;

    private string $choreId;

    /**
     * @param string $houseId
     * @param string $roomId
     * @param string $choreId
     */
    public function __construct(string $houseId, string $roomId, string $choreId)
    {
        $this->houseId = $houseId;
        $this->roomId = $roomId;
        $this->choreId = $choreId;
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
}

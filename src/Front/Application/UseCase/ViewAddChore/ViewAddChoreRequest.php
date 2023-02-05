<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewAddChore;

/**
 *
 */
final class ViewAddChoreRequest
{
    private string $houseId;

    private string $roomId;

    /**
     * @param string $houseId
     * @param string $roomId
     */
    public function __construct(string $houseId, string $roomId)
    {
        $this->houseId = $houseId;
        $this->roomId = $roomId;
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
}

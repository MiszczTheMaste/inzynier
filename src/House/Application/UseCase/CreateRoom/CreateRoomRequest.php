<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\CreateRoom;

final class CreateRoomRequest
{
    private string $houseId;

    private array $data;

    /**
     * @param string $houseId
     * @param array $data
     */
    public function __construct(string $houseId, array $data)
    {
        $this->houseId = $houseId;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getHouseId(): string
    {
        return $this->houseId;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}

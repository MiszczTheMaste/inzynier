<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\CreateChore;

use App\Core\Application\UseCase\AbstractArrayRequest;

/**
 *
 */
final class CreateChoreRequest extends AbstractArrayRequest
{
    private string $houseId;

    private string $roomId;

    /**
     * @param string $houseId
     * @param string $roomId
     * @param array $data
     */
    public function __construct(string $houseId, string $roomId, array $data)
    {
        parent::__construct($data);
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

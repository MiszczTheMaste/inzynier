<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\EditFulfilment;

use App\Core\Application\UseCase\AbstractArrayRequest;

/**
 *
 */
final class EditFulfilmentRequest extends AbstractArrayRequest
{
    private string $houseId;

    private string $roomId;

    private string $choreId;

    private string $fulfilmentId;

    /**
     * @param array $data
     * @param string $houseId
     * @param string $roomId
     * @param string $choreId
     * @param string $fulfilmentId
     */
    public function __construct(array $data, string $houseId, string $roomId, string $choreId, string $fulfilmentId)
    {
        parent::__construct($data);
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

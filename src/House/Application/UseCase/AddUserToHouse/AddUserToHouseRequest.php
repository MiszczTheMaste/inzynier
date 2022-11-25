<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\AddUserToHouse;

use App\Core\Application\UseCase\AbstractArrayRequest;

final class AddUserToHouseRequest extends AbstractArrayRequest
{
    private string $houseId;

    /**
     * @param string $houseId
     * @param array $data
     */
    public function __construct(string $houseId, array $data)
    {
        parent::__construct($data);
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

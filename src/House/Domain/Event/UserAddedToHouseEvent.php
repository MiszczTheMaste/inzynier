<?php

declare(strict_types=1);

namespace App\House\Domain\Event;

use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\ValueObject\IdInterface;

/**
 *
 */
final class UserAddedToHouseEvent implements EventInterface
{
    private IdInterface $houseId;

    private IdInterface $userId;

    /**
     * @param IdInterface $houseId
     * @param IdInterface $userId
     */
    public function __construct(IdInterface $houseId, IdInterface $userId)
    {
        $this->houseId = $houseId;
        $this->userId = $userId;
    }

    /**
     * @return IdInterface
     */
    public function getHouseId(): IdInterface
    {
        return $this->houseId;
    }

    /**
     * @return IdInterface
     */
    public function getUserId(): IdInterface
    {
        return $this->userId;
    }
}

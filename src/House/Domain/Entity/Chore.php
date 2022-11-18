<?php

declare(strict_types=1);

namespace App\House\Domain\Entity;

use App\Core\Domain\Entity\AbstractEntity;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\ValueObject\ChoreFulfilmentCollection;
use App\House\Domain\ValueObject\DaysInterval;
use function Symfony\Component\Translation\t;

final class Chore extends AbstractEntity
{
    private IdInterface $roomId;

    private DaysInterval $daysInterval;

    private IdInterface $iconId;

    private IdInterface $userId;

    private ChoreFulfilmentCollection $choreFulfilmentCollection;

    private bool $removed;
    /**
     * @param IdInterface $id
     * @param IdInterface $roomId
     * @param DaysInterval $daysInterval
     * @param IdInterface $iconId
     * @param IdInterface $userId
     * @param ChoreFulfilmentCollection $choreFulfilmentCollection
     */
    public function __construct(
        IdInterface $id,
        IdInterface $roomId,
        DaysInterval $daysInterval,
        IdInterface $iconId,
        IdInterface $userId,
        ChoreFulfilmentCollection $choreFulfilmentCollection
    ) {
        parent::__construct($id);
        $this->roomId = $roomId;
        $this->daysInterval = $daysInterval;
        $this->iconId = $iconId;
        $this->userId = $userId;
        $this->choreFulfilmentCollection = $choreFulfilmentCollection;
    }

    /**
     * @param IdInterface $roomId
     */
    public function changeRoomTo(IdInterface $roomId): void
    {
        $this->roomId = $roomId;
    }

    /**
     * @param DaysInterval $daysInterval
     */
    public function changeIntervalTo(DaysInterval $daysInterval): void
    {
        $this->daysInterval = $daysInterval;
    }

    /**
     * @param IdInterface $iconId
     */
    public function changeIconTo(IdInterface $iconId): void
    {
        $this->iconId = $iconId;
    }

    /**
     * @param IdInterface $userId
     */
    public function changeUserTo(IdInterface $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param ChoreFulfilmentCollection $choreFulfilmentCollection
     */
    public function changeChoresTo(ChoreFulfilmentCollection $choreFulfilmentCollection): void
    {
        $this->choreFulfilmentCollection = $choreFulfilmentCollection;
    }

    /**
     * @return IdInterface
     */
    public function getRoomId(): IdInterface
    {
        return $this->roomId;
    }

    /**
     * @return DaysInterval
     */
    public function getDaysInterval(): DaysInterval
    {
        return $this->daysInterval;
    }

    /**
     * @return IdInterface
     */
    public function getIconId(): IdInterface
    {
        return $this->iconId;
    }

    /**
     * @return IdInterface
     */
    public function getUserId(): IdInterface
    {
        return $this->userId;
    }

    /**
     * @return ChoreFulfilmentCollection
     */
    public function getChoreFulfilmentCollection(): ChoreFulfilmentCollection
    {
        return $this->choreFulfilmentCollection;
    }

    public function remove(): void
    {
        $this->removed = true;
    }
}

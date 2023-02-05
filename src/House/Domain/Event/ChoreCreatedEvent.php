<?php

declare(strict_types=1);

namespace App\House\Domain\Event;

use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\ValueObject\DaysInterval;
use DateTimeImmutable;

/**
 *
 */
final class ChoreCreatedEvent implements EventInterface
{
    private IdInterface $id;

    private IdInterface $roomId;

    private DaysInterval $daysInterval;

    private IdInterface $iconId;

    private IdInterface $userId;

    private IdInterface $fulfilmentId;

    private string $name;

    private DateTimeImmutable $fulfilmentDeadline;

    private DateTimeImmutable $creationDate;

    /**
     * @param IdInterface $id
     * @param IdInterface $roomId
     * @param DaysInterval $daysInterval
     * @param IdInterface $iconId
     * @param IdInterface $userId
     * @param IdInterface $fulfilmentId
     * @param string $name
     * @param DateTimeImmutable $fulfilmentDeadline
     * @param DateTimeImmutable $creationDate
     */
    public function __construct(IdInterface $id, IdInterface $roomId, DaysInterval $daysInterval, IdInterface $iconId, IdInterface $userId, IdInterface $fulfilmentId, string $name, DateTimeImmutable $fulfilmentDeadline, DateTimeImmutable $creationDate)
    {
        $this->id = $id;
        $this->roomId = $roomId;
        $this->daysInterval = $daysInterval;
        $this->iconId = $iconId;
        $this->userId = $userId;
        $this->fulfilmentId = $fulfilmentId;
        $this->name = $name;
        $this->fulfilmentDeadline = $fulfilmentDeadline;
        $this->creationDate = $creationDate;
    }

    /**
     * @return IdInterface
     */
    public function getId(): IdInterface
    {
        return $this->id;
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
     * @return IdInterface
     */
    public function getFulfilmentId(): IdInterface
    {
        return $this->fulfilmentId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getFulfilmentDeadline(): DateTimeImmutable
    {
        return $this->fulfilmentDeadline;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }
}

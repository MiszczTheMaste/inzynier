<?php

declare(strict_types=1);

namespace App\House\Domain\Event;

use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\ValueObject\DaysInterval;
use DateTimeImmutable;

final class ChoreCreatedEvent implements EventInterface
{
    private IdInterface $roomId;

    private DaysInterval $daysInterval;

    private IdInterface $iconId;

    private IdInterface $userId;

    private IdInterface $fulfilmentId;

    private DateTimeImmutable $fulfilmentDeadline;

    /**
     * @param IdInterface $roomId
     * @param DaysInterval $daysInterval
     * @param IdInterface $iconId
     * @param IdInterface $userId
     * @param IdInterface $fulfilmentId
     * @param DateTimeImmutable $fulfilmentDeadline
     */
    public function __construct(
        IdInterface $roomId,
        DaysInterval $daysInterval,
        IdInterface $iconId,
        IdInterface $userId,
        IdInterface $fulfilmentId,
        DateTimeImmutable $fulfilmentDeadline
    ) {
        $this->roomId = $roomId;
        $this->daysInterval = $daysInterval;
        $this->iconId = $iconId;
        $this->userId = $userId;
        $this->fulfilmentId = $fulfilmentId;
        $this->fulfilmentDeadline = $fulfilmentDeadline;
    }
}

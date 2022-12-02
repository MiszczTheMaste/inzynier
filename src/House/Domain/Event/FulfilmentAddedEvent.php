<?php

declare(strict_types=1);

namespace App\House\Domain\Event;

use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\ValueObject\IdInterface;

final class FulfilmentAddedEvent implements EventInterface
{
    private IdInterface $id;

    private IdInterface $choreId;

    private \DateTimeImmutable $deadline;

    /**
     * @param IdInterface $id
     * @param IdInterface $choreId
     * @param \DateTimeImmutable $deadline
     */
    public function __construct(IdInterface $id, IdInterface $choreId, \DateTimeImmutable $deadline)
    {
        $this->id = $id;
        $this->choreId = $choreId;
        $this->deadline = $deadline;
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
    public function getChoreId(): IdInterface
    {
        return $this->choreId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDeadline(): \DateTimeImmutable
    {
        return $this->deadline;
    }
}

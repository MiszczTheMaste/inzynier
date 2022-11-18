<?php

declare(strict_types=1);

namespace App\House\Domain\Event;

use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\ValueObject\UserIdCollection;
use DateTimeImmutable;

final class HouseCreatedEvent implements EventInterface
{
    private IdInterface $id;

    private UserIdCollection $users;

    private DateTimeImmutable $creationDate;

    /**
     * @param IdInterface $id
     * @param UserIdCollection $users
     * @param DateTimeImmutable $creationDate
     */
    public function __construct(IdInterface $id, UserIdCollection $users, DateTimeImmutable $creationDate)
    {
        $this->id = $id;
        $this->users = $users;
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
     * @return UserIdCollection
     */
    public function getUsers(): UserIdCollection
    {
        return $this->users;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }
}

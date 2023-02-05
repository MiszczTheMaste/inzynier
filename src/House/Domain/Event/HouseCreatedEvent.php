<?php

declare(strict_types=1);

namespace App\House\Domain\Event;

use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\ValueObject\UserIdCollection;
use DateTimeImmutable;

/**
 *
 */
final class HouseCreatedEvent implements EventInterface
{
    private IdInterface $id;

    private IdInterface $owner;

    private IdInterface $iconId;

    private string $name;

    private UserIdCollection $users;

    private DateTimeImmutable $creationDate;

    /**
     * @param IdInterface $id
     * @param IdInterface $owner
     * @param IdInterface $iconId
     * @param string $name
     * @param UserIdCollection $users
     * @param DateTimeImmutable $creationDate
     */
    public function __construct(IdInterface $id, IdInterface $owner, IdInterface $iconId, string $name, UserIdCollection $users, DateTimeImmutable $creationDate)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->iconId = $iconId;
        $this->name = $name;
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
     * @return IdInterface
     */
    public function getOwner(): IdInterface
    {
        return $this->owner;
    }

    /**
     * @return IdInterface
     */
    public function getIconId(): IdInterface
    {
        return $this->iconId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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

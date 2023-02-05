<?php

declare(strict_types=1);

namespace App\Auth\Domain\Event;

use App\Core\Domain\Event\EventInterface;
use DateTimeImmutable;

/**
 *
 */
final class UserCreatedEvent implements EventInterface
{
    private string $id;

    private string $username;

    private string $password;

    private bool $removed;

    private DateTimeImmutable $creationDate;

    /**
     * @param string $id
     * @param string $username
     * @param string $password
     * @param bool $removed
     * @param DateTimeImmutable $creationDate
     */
    public function __construct(
        string $id,
        string $username,
        string $password,
        bool $removed,
        DateTimeImmutable $creationDate
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->removed = $removed;
        $this->creationDate = $creationDate;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function isRemoved(): bool
    {
        return $this->removed;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }
}

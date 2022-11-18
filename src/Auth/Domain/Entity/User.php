<?php

declare(strict_types=1);

namespace App\Auth\Domain\Entity;

use App\Auth\Domain\Event\UserCreatedEvent;
use App\Auth\Domain\ValueObject\PasswordHash;
use App\Auth\Domain\ValueObject\Username;
use App\Core\Domain\Entity\AbstractAggregate;
use App\Core\Domain\ValueObject\IdInterface;
use DateTimeImmutable;

final class User extends AbstractAggregate
{
    private Username $username;

    private PasswordHash $password;

    private bool $removed;

    private DateTimeImmutable $creationDate;

    public function __construct(
        IdInterface $id,
        Username $username,
        PasswordHash $password,
        bool $removed = false,
        ?DateTimeImmutable $creationDate = null
    ) {
        parent::__construct($id);
        $this->username = $username;
        $this->password = $password;
        $this->removed = $removed;
        $this->creationDate = $creationDate ?? new DateTimeImmutable();

        if (is_null($creationDate)) {
            $this->raise(
                new UserCreatedEvent(
                    $id->toString(),
                    $username->toString(),
                    $password->toString(),
                    false,
                    new DateTimeImmutable()
                )
            );
        }
    }

    /**
     * @return Username
     */
    public function getUsername(): Username
    {
        return $this->username;
    }

    /**
     * @return PasswordHash
     */
    public function getPassword(): PasswordHash
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
     * @return DateTimeImmutable|null
     */
    public function getCreationDate(): ?DateTimeImmutable
    {
        return $this->creationDate;
    }
}

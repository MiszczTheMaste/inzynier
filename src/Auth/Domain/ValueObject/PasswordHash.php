<?php

declare(strict_types=1);

namespace App\Auth\Domain\ValueObject;

use App\Auth\Domain\Exception\PasswordHashingException;

final class PasswordHash
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @throws PasswordHashingException
     */
    public static function createHash(string $password): self
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        if (false === (bool) $hash) {
            throw new PasswordHashingException();
        }

        return new self($hash);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function verify(string $password): bool
    {
        return password_verify($password, $this->value);
    }
}

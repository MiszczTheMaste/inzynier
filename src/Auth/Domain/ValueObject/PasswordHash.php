<?php

declare(strict_types=1);

namespace App\Auth\Domain\ValueObject;

use App\Auth\Domain\Exception\PasswordHashingException;

/**
 *
 */
final class PasswordHash
{
    private string $value;

    /**
     * @param string $value
     */
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

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function verify(string $password): bool
    {
        return password_verify($password, $this->value);
    }
}

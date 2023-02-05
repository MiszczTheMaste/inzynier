<?php

declare(strict_types=1);

namespace App\Auth\Domain\ValueObject;

use App\Auth\Domain\Exception\InvalidUsernameException;

/**
 *
 */
final class Username
{
    private const MIN_LENGTH = 3;

    private const MAX_LENGTH = 16;

    private string $value;

    /**
     * @throws InvalidUsernameException
     */
    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    /**
     * @throws InvalidUsernameException
     */
    private function validate(string $value): void
    {
        if (strlen($value) < self::MIN_LENGTH || strlen($value) > self::MAX_LENGTH) {
            throw new InvalidUsernameException();
        }
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }
}

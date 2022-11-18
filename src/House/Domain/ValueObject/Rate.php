<?php

declare(strict_types=1);

namespace App\House\Domain\ValueObject;

use App\House\Domain\Exception\InvalidRateException;

final class Rate
{
    private const MIN_RATE = 1;

    private const MAX_RATE = 5;

    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
    /**
     * @throws InvalidRateException
     */
    public static function create(int $value): self
    {
        self::validate($value);
        return new self($value);
    }
    public static function createWithZeroValue(): self
    {
        return new self(0);
    }

    /**
     * @throws InvalidRateException
     */
    private static function validate(int $value): void
    {
        if ($value < self::MIN_RATE || $value > self::MAX_RATE) {
            throw new InvalidRateException();
        }
    }

    public function toInt(): int
    {
        return $this->value;
    }
}

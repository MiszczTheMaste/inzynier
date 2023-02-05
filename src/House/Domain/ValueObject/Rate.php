<?php

declare(strict_types=1);

namespace App\House\Domain\ValueObject;

use App\House\Domain\Exception\InvalidRateException;

/**
 *
 */
final class Rate
{
    private const MIN_RATE = 1;

    private const MAX_RATE = 5;

    private int $value;

    /**
     * @param int $value
     */
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

    /**
     * @return static
     */
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

    /**
     * @return int
     */
    public function toInt(): int
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isChangeable(): bool
    {
        return $this->value === 0;
    }
}

<?php

declare(strict_types=1);

namespace App\House\Domain\ValueObject;

use App\House\Domain\Exception\InvalidDaysIntervalException;

final class DaysInterval
{
    private int $value;

    /**
     * @throws InvalidDaysIntervalException
     */
    public function __construct(int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    /**
     * @throws InvalidDaysIntervalException
     */
    private function validate(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidDaysIntervalException();
        }
    }

    public function toInt(): int
    {
        return $this->value;
    }
}

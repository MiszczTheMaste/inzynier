<?php

declare(strict_types=1);

namespace App\Core\Domain\ValueObject;

/**
 *
 */
final class DbField
{
    private mixed $value;

    /**
     * @param mixed $value
     */
    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}

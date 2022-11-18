<?php

declare(strict_types=1);

namespace App\Core\Domain\Exception;

use Exception;

/** @phpstan-consistent-constructor */
abstract class AbstractException extends Exception
{
    public static function fromException(Exception $e): static
    {
        return new static($e->getMessage(), $e->getCode(), $e);
    }
}

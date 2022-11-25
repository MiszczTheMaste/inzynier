<?php

declare(strict_types=1);

namespace App\Core\Domain\Exception;

use Exception;
use Throwable;

/** @phpstan-consistent-constructor */
abstract class AbstractException extends Exception
{
    final public function __construct(string $message = '', int $code = 0, ?Throwable $e = null)
    {
        parent::__construct($message, $code, $e);
    }

    public static function fromException(Exception $e): static
    {
        return new static($e->getMessage(), (int) $e->getCode(), $e);
    }
}

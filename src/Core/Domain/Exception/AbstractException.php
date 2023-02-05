<?php

declare(strict_types=1);

namespace App\Core\Domain\Exception;

use Exception;
use Throwable;

/** @phpstan-consistent-constructor */
abstract class AbstractException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $e
     */
    final public function __construct(string $message = '', int $code = 0, ?Throwable $e = null)
    {
        parent::__construct($message, $code, $e);
    }

    /**
     * @param Exception $e
     * @return static
     */
    public static function fromException(Exception $e): static
    {
        return new static($e->getMessage(), (int) $e->getCode(), $e);
    }
}

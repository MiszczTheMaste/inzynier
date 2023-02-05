<?php

declare(strict_types=1);

namespace App\Core\Domain\ValueObject;

/**
 *
 */
interface IdInterface
{
    /**
     * @param string $identifier
     * @return static
     */
    public static function fromString(string $identifier): self;

    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @param IdInterface $id
     * @return bool
     */
    public function equals(IdInterface $id): bool;
}

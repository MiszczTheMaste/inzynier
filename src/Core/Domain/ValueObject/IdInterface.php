<?php

declare(strict_types=1);

namespace App\Core\Domain\ValueObject;

interface IdInterface
{
    public static function fromString(string $identifier): self;

    public function toString(): string;
}

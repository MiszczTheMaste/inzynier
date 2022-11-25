<?php

declare(strict_types=1);

namespace App\Core\Domain\ValueObject;

use App\Core\Domain\Exception\InvalidIdException;
use Ramsey\Uuid\Uuid as BaseUuid;
use Ramsey\Uuid\UuidInterface;

final class Uuid implements IdInterface
{
    private UuidInterface $id;

    private function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    /**
     * @throws InvalidIdException
     */
    public static function fromString(string $identifier): self
    {
        if (false === BaseUuid::isValid($identifier)) {
            throw new InvalidIdException();
        }

        return new self(BaseUuid::fromString($identifier));
    }

    public function equals(IdInterface $id): bool
    {
        return $this->id->toString() === $id->toString();
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->id->toString();
    }

    /**
     * @throws InvalidIdException
     */
    public static function generateUuid(): self
    {
        try {
            return self::fromString(BaseUuid::uuid4()->toString());
        } catch (InvalidIdException $e) {
            throw InvalidIdException::fromException($e);
        }
    }
}

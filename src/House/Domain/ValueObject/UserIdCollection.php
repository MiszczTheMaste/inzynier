<?php

declare(strict_types=1);

namespace App\House\Domain\ValueObject;

use App\Core\Domain\ValueObject\AbstractCollection;
use App\Core\Domain\ValueObject\IdInterface;

final class UserIdCollection extends AbstractCollection
{
    /**
     * @return IdInterface[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    public function add(IdInterface $userId): void
    {
        $this->collection[] = $userId;
    }

    protected function getCollectionClass(): string
    {
        return IdInterface::class;
    }
}

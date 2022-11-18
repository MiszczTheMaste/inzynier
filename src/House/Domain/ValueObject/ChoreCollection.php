<?php

declare(strict_types=1);

namespace App\House\Domain\ValueObject;

use App\Core\Domain\ValueObject\AbstractCollection;
use App\House\Domain\Entity\Chore;

final class ChoreCollection extends AbstractCollection
{
    /**
     * @return Chore[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    protected function getCollectionClass(): string
    {
        return Chore::class;
    }
}
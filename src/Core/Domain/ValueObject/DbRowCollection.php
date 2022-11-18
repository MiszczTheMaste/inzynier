<?php

declare(strict_types=1);

namespace App\Core\Domain\ValueObject;

final class DbRowCollection extends AbstractCollection
{
    /**
     * @return DbRow[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    protected function getCollectionClass(): string
    {
        return DbRow::class;
    }
}

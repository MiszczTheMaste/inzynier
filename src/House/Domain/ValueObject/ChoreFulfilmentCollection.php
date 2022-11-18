<?php

declare(strict_types=1);

namespace App\House\Domain\ValueObject;

use App\Core\Domain\ValueObject\AbstractCollection;
use App\House\Domain\Entity\ChoreFulfilment;

final class ChoreFulfilmentCollection extends AbstractCollection
{
    /**
     * @return ChoreFulfilment[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    public function getInitial(): ChoreFulfilment
    {
        return $this->getCollection()[0];
    }

    protected function getCollectionClass(): string
    {
        return ChoreFulfilment::class;
    }
}

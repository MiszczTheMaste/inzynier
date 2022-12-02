<?php

declare(strict_types=1);

namespace App\House\Domain\ValueObject;

use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Domain\ValueObject\AbstractCollection;
use App\Core\Domain\ValueObject\IdInterface;
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

    public function get(IdInterface $id): ChoreFulfilment
    {
        foreach ($this->getCollection() as $item) {
            if ($item->getId()->equals($id)) {
                return $item;
            }
        }

        throw new ItemNotFoundInCollectionException();
    }

    public function getInitial(): ChoreFulfilment
    {
        return $this->getCollection()[0];
    }

    public function add(ChoreFulfilment $item): void
    {
        $this->collection[] = $item;
    }

    protected function getCollectionClass(): string
    {
        return ChoreFulfilment::class;
    }
}

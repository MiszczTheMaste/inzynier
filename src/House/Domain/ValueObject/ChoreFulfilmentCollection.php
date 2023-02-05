<?php

declare(strict_types=1);

namespace App\House\Domain\ValueObject;

use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Domain\ValueObject\AbstractCollection;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\Entity\ChoreFulfilment;

/**
 *
 */
final class ChoreFulfilmentCollection extends AbstractCollection
{
    /**
     * @return ChoreFulfilment[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * @throws ItemNotFoundInCollectionException
     */
    public function get(IdInterface $id): ChoreFulfilment
    {
        foreach ($this->getCollection() as $item) {
            if ($item->getId()->equals($id)) {
                return $item;
            }
        }

        throw new ItemNotFoundInCollectionException();
    }

    /**
     * @return ChoreFulfilment
     */
    public function getInitial(): ChoreFulfilment
    {
        return $this->getCollection()[0];
    }

    /**
     * @param ChoreFulfilment $item
     * @return void
     */
    public function add(ChoreFulfilment $item): void
    {
        $this->collection[] = $item;
    }

    /**
     * @return string
     */
    protected function getCollectionClass(): string
    {
        return ChoreFulfilment::class;
    }
}

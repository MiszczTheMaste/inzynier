<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetChore\DTO;

use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Domain\ValueObject\AbstractCollection;

/**
 *
 */
final class ChoreFulfilmentDTOCollection extends AbstractCollection
{
    /**
     * @return ChoreFulfilmentDTO[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * @throws ItemNotFoundInCollectionException
     */
    public function getActive(): ChoreFulfilmentDTO
    {
        foreach ($this->getCollection() as $item) {
            if (false === $item->isFinished()) {
                return $item;
            }
        }

        throw new ItemNotFoundInCollectionException();
    }

    /**
     * @return string
     */
    protected function getCollectionClass(): string
    {
        return ChoreFulfilmentDTO::class;
    }
}

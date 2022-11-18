<?php

declare(strict_types=1);

namespace App\House\Domain\ValueObject;

use App\Core\Domain\ValueObject\AbstractCollection;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\Entity\Chore;
use App\House\Domain\Exception\ChoreNotFoundException;

final class ChoreCollection extends AbstractCollection
{
    /**
     * @return Chore[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * @throws ChoreNotFoundException
     */
    public function get(IdInterface $id): Chore
    {
        foreach ($this->getCollection() as $chore){
            if($chore->getId()->equals($id))
            {
                return $chore;
            }
        }

        throw new ChoreNotFoundException();
    }

    protected function getCollectionClass(): string
    {
        return Chore::class;
    }
}
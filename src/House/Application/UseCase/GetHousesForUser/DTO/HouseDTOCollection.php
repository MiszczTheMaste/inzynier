<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHousesForUser\DTO;

use App\Core\Domain\ValueObject\AbstractCollection;

final class HouseDTOCollection extends AbstractCollection
{
    /**
     * @return HouseDTO[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    public function toArray(): array
    {

        return array_map(
            function (HouseDTO $house) {
                return [
                    'id' => $house->getId(),
                    'name' => $house->getName(),
                    'icon_url' => $house->getIconUrl(),
                ];
            },
            $this->collection
        );
    }

    protected function getCollectionClass(): string
    {
        return HouseDTO::class;
    }
}

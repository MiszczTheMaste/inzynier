<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHouse\DTO;

use App\Core\Domain\ValueObject\AbstractCollection;

/**
 *
 */
final class RoomDTOCollection extends AbstractCollection
{
    /**
     * @return RoomDTO[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(
            function (RoomDTO $chore) {
                return [
                    'id' => $chore->getId(),
                    'name' => $chore->getName(),
                    'icon_url' => $chore->getIcon(),
                    'chores_after_deadline' => $chore->getChoresAfterDeadline(),
                ];
            },
            $this->collection
        );
    }

    /**
     * @return string
     */
    protected function getCollectionClass(): string
    {
        return RoomDTO::class;
    }
}

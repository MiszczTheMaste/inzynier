<?php

declare(strict_types=1);

namespace App\House\Domain\ValueObject;

use App\Core\Domain\ValueObject\AbstractCollection;
use App\House\Domain\Entity\Room;

final class RoomCollection extends AbstractCollection
{
    /**
     * @return Room[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    public function addRoom(Room $room):void
    {
        $this->collection[] = $room;
    }

    protected function getCollectionClass(): string
    {
        return Room::class;
    }
}

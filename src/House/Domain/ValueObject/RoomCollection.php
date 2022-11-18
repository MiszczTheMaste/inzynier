<?php

declare(strict_types=1);

namespace App\House\Domain\ValueObject;

use App\Core\Domain\ValueObject\AbstractCollection;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\Entity\Chore;
use App\House\Domain\Entity\Room;
use App\House\Domain\Exception\ChoreNotFoundException;
use App\House\Domain\Exception\RoomNotFoundException;

final class RoomCollection extends AbstractCollection
{
    /**
     * @return Room[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * @throws RoomNotFoundException
     */
    public function get(IdInterface $id): Room
    {
        foreach ($this->getCollection() as $room){
            if($room->getId()->equals($id))
            {
                return $room;
            }
        }

        throw new RoomNotFoundException();
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

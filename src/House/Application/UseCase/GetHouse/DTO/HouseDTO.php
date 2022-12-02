<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHouse\DTO;

use App\House\Application\DTO\UserDTOCollection;

final class HouseDTO
{
    private string $id;

    private string $name;

    private UserDTOCollection $users;

    private RoomDTOCollection $rooms;

    /**
     * @param string $id
     * @param string $name
     * @param UserDTOCollection $users
     * @param RoomDTOCollection $rooms
     */
    public function __construct(string $id, string $name, UserDTOCollection $users, RoomDTOCollection $rooms)
    {
        $this->id = $id;
        $this->name = $name;
        $this->users = $users;
        $this->rooms = $rooms;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return UserDTOCollection
     */
    public function getUsers(): UserDTOCollection
    {
        return $this->users;
    }

    /**
     * @return RoomDTOCollection
     */
    public function getRooms(): RoomDTOCollection
    {
        return $this->rooms;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'users' => $this->getUsers()->toArray(),
            'rooms' => $this->getRooms()->toArray(),
        ];
    }
}

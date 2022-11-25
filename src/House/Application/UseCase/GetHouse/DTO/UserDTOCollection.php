<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHouse\DTO;

use App\Core\Domain\ValueObject\AbstractCollection;

final class UserDTOCollection extends AbstractCollection
{
    /**
     * @return UserDTO[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    public function toArray(): array
    {
        return array_map(
            function (UserDTO $user) {
                return [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                ];
            },
            $this->collection
        );
    }

    protected function getCollectionClass(): string
    {
        return UserDTO::class;
    }
}

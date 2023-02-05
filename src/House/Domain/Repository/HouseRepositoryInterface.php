<?php

declare(strict_types=1);

namespace App\House\Domain\Repository;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\Repository\RepositoryInterface;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\Entity\House;
use App\House\Domain\Exception\RoomNotFoundException;

/**
 *
 */
interface HouseRepositoryInterface extends RepositoryInterface
{
    /**
     * @throws DatabaseException
     * @throws InvalidObjectTypeInCollectionException
     */
    public function persist(House $aggregate): void;

    /**
     * @throws DatabaseException
     * @throws RoomNotFoundException
     */
    public function get(IdInterface $id): House;
}

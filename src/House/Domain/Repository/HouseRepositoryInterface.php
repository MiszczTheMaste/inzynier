<?php

declare(strict_types=1);

namespace App\House\Domain\Repository;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\Repository\RepositoryInterface;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\Entity\House;

interface HouseRepositoryInterface extends RepositoryInterface
{
    /**
     * @throws DatabaseException
     * @throws InvalidObjectTypeInCollectionException
     */
    public function persist(House $aggregate): void;

    /**
     * @throws DatabaseException
     */
    public function get(IdInterface $id): House;
}

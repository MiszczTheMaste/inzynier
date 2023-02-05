<?php

declare(strict_types=1);

namespace App\Auth\Domain\Repository;

use App\Auth\Domain\Entity\User;
use App\Auth\Domain\ValueObject\Username;
use App\Core\Domain\Entity\AbstractAggregate;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\Repository\RepositoryInterface;

/**
 *
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @throws DatabaseException
     * @throws InvalidObjectTypeInCollectionException
     */
    public function persist(AbstractAggregate $aggregate): void;

    /**
     * @throws DatabaseException
     */
    public function get(Username $username): User;
}

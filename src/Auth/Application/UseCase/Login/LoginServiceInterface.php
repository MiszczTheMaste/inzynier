<?php

declare(strict_types=1);

namespace App\Auth\Application\UseCase\Login;

use App\Auth\Domain\Exception\InvalidPasswordException;
use App\Auth\Domain\Exception\InvalidUsernameException;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;

interface LoginServiceInterface
{
    /**
     * @throws DatabaseException
     * @throws InvalidObjectTypeInCollectionException
     * @throws InvalidUsernameException
     * @throws InvalidPasswordException
     */
    public function handle(LoginRequest $request): array;
}
<?php

declare(strict_types=1);

namespace App\Auth\Application\UseCase\Register;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;

interface RegisterServiceInterface
{
    /**
     * @throws DatabaseException
     * @throws InvalidObjectTypeInCollectionException
     * @throws \App\Auth\Domain\Exception\InvalidUsernameException|\App\Auth\Domain\Exception\PasswordHashingException
     */
    public function handle(RegisterRequest $request): array;
}
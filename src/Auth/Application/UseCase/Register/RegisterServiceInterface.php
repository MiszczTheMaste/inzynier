<?php

declare(strict_types=1);

namespace App\Auth\Application\UseCase\Register;

use App\Auth\Domain\Exception\InvalidUsernameException;
use App\Auth\Domain\Exception\PasswordHashingException;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;

interface RegisterServiceInterface
{
    /**
     * @throws DatabaseException
     * @throws InvalidObjectTypeInCollectionException
     * @throws InvalidUsernameException|PasswordHashingException
     */
    public function handle(RegisterRequest $request): UseCasePayload;
}

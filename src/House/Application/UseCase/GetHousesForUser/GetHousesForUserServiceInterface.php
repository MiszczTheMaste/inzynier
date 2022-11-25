<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHousesForUser;

use App\Core\Application\UseCase\UseCasePayload;

interface GetHousesForUserServiceInterface
{
    public function handle(GetHousesForUserRequest $request): UseCasePayload;
}

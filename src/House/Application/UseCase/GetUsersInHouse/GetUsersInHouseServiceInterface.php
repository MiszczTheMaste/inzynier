<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetUsersInHouse;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface GetUsersInHouseServiceInterface
{
    /**
     * @param GetUsersInHouseRequest $request
     * @return UseCasePayload
     */
    public function handle(GetUsersInHouseRequest $request): UseCasePayload;
}

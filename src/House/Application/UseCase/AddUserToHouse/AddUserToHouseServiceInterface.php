<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\AddUserToHouse;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface AddUserToHouseServiceInterface
{
    /**
     * @param AddUserToHouseRequest $request
     * @return UseCasePayload
     */
    public function handle(AddUserToHouseRequest $request): UseCasePayload;
}

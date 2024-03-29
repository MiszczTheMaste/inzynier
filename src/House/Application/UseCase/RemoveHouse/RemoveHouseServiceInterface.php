<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\RemoveHouse;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface RemoveHouseServiceInterface
{
    /**
     * @param RemoveHouseRequest $request
     * @return UseCasePayload
     */
    public function handle(RemoveHouseRequest $request): UseCasePayload;
}

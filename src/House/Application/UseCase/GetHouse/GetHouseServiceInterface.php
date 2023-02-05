<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHouse;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface GetHouseServiceInterface
{
    /**
     * @param GetHouseRequest $request
     * @return UseCasePayload
     */
    public function handle(GetHouseRequest $request): UseCasePayload;
}

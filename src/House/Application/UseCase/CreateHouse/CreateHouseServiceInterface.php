<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\CreateHouse;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface CreateHouseServiceInterface
{
    /**
     * @param CreateHouseRequest $request
     * @return UseCasePayload
     */
    public function handle(CreateHouseRequest $request): UseCasePayload;
}

<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\RemoveHouse;

use App\Core\Application\UseCase\UseCasePayload;

interface RemoveHouseServiceInterface
{
    public function handle(RemoveHouseRequest $request): UseCasePayload;
}

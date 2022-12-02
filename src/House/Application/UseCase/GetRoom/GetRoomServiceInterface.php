<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetRoom;

use App\Core\Application\UseCase\UseCasePayload;

interface GetRoomServiceInterface
{
    public function handle(GerRoomRequest $request): UseCasePayload;
}

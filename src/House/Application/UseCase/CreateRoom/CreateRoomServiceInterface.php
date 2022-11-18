<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\CreateRoom;

use App\Core\Application\UseCase\UseCasePayload;
use App\House\Application\UseCase\CreateHouse\CreateHouseRequest;

interface CreateRoomServiceInterface
{
    public function handle(CreateRoomRequest $request): UseCasePayload;
}

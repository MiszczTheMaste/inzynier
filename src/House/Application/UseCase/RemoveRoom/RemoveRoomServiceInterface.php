<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\RemoveRoom;

use App\Core\Application\UseCase\UseCasePayload;
use App\House\Application\UseCase\RemoveChore\RemoveChoreRequest;

interface RemoveRoomServiceInterface
{
    public function handle(RemoveRoomRequest $request): UseCasePayload;
}

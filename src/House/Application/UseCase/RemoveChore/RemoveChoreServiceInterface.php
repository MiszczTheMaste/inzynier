<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\RemoveChore;

use App\Core\Application\UseCase\UseCasePayload;
use App\House\Application\UseCase\CreateRoom\CreateRoomRequest;

interface RemoveChoreServiceInterface
{
    public function handle(RemoveChoreRequest $request): UseCasePayload;
}

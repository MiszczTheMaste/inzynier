<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\RemoveRoom;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface RemoveRoomServiceInterface
{
    /**
     * @param RemoveRoomRequest $request
     * @return UseCasePayload
     */
    public function handle(RemoveRoomRequest $request): UseCasePayload;
}

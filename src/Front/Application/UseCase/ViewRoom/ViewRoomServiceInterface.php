<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewRoom;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface ViewRoomServiceInterface
{
    /**
     * @param ViewRoomRequest $request
     * @return UseCasePayload
     */
    public function handle(ViewRoomRequest $request): UseCasePayload;
}

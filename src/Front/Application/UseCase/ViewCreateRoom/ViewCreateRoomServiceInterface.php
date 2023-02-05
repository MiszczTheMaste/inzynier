<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewCreateRoom;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface ViewCreateRoomServiceInterface
{
    /**
     * @param ViewCreateRoomRequest $request
     * @return UseCasePayload
     */
    public function handle(ViewCreateRoomRequest $request): UseCasePayload;
}

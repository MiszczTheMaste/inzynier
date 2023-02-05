<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetRoom;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface GetRoomServiceInterface
{
    /**
     * @param GerRoomRequest $request
     * @return UseCasePayload
     */
    public function handle(GerRoomRequest $request): UseCasePayload;
}

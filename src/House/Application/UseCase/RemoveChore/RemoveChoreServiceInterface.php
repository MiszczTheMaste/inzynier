<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\RemoveChore;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface RemoveChoreServiceInterface
{
    /**
     * @param RemoveChoreRequest $request
     * @return UseCasePayload
     */
    public function handle(RemoveChoreRequest $request): UseCasePayload;
}

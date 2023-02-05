<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetChore;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface GetChoreServiceInterface
{
    /**
     * @param GetChoreRequest $request
     * @return UseCasePayload
     */
    public function handle(GetChoreRequest $request): UseCasePayload;
}

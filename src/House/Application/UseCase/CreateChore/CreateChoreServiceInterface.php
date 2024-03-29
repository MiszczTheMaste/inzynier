<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\CreateChore;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface CreateChoreServiceInterface
{
    /**
     * @param CreateChoreRequest $request
     * @return UseCasePayload
     */
    public function handle(CreateChoreRequest $request): UseCasePayload;
}

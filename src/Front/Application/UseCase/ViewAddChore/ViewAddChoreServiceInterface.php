<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewAddChore;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface ViewAddChoreServiceInterface
{
    /**
     * @param ViewAddChoreRequest $request
     * @return UseCasePayload
     */
    public function handle(ViewAddChoreRequest $request): UseCasePayload;
}

<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewChore;

use App\Core\Application\UseCase\UseCasePayload;

interface ViewChoreServiceInterface
{
    public function handle(ViewChoreRequest $request): UseCasePayload;
}

<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewPage;

use App\Core\Application\UseCase\UseCasePayload;

interface ViewPageServiceInterface
{
    public function handle(ViewPageRequest $request): UseCasePayload;
}

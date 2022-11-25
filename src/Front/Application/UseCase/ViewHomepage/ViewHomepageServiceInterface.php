<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewHomepage;

use App\Core\Application\UseCase\UseCasePayload;

interface ViewHomepageServiceInterface
{
    public function handle(ViewHomepageRequest $request): UseCasePayload;
}

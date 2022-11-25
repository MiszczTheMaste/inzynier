<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewHouse;

use App\Core\Application\UseCase\UseCasePayload;

interface ViewHouseServiceInterface
{
    public function handle(ViewHouseRequest $request): UseCasePayload;
}

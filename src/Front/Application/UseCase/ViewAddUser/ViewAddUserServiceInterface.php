<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewAddUser;

use App\Core\Application\UseCase\UseCasePayload;

interface ViewAddUserServiceInterface
{
    public function handle(ViewAddUserRequest $request): UseCasePayload;
}

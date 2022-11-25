<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetChores;

use App\Core\Application\UseCase\UseCasePayload;

interface GetChoresServiceInterface
{
    public function handle(GetChoresRequest $request): UseCasePayload;
}

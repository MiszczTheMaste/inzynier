<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\AddNewFulfilment;

use App\Core\Application\UseCase\UseCasePayload;
use App\House\Application\UseCase\AddUserToHouse\AddUserToHouseRequest;

interface AddNewFulfilmentServiceInterface
{
    public function handle(AddNewFulfilmentRequest $request): UseCasePayload;
}

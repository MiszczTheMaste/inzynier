<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\AddNewFulfilment;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface AddNewFulfilmentServiceInterface
{
    /**
     * @param AddNewFulfilmentRequest $request
     * @return UseCasePayload
     */
    public function handle(AddNewFulfilmentRequest $request): UseCasePayload;
}

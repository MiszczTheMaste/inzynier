<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\EditFulfilment;

use App\Core\Application\UseCase\UseCasePayload;

/**
 *
 */
interface EditFulfilmentServiceInterface
{
    /**
     * @param EditFulfilmentRequest $request
     * @return UseCasePayload
     */
    public function handle(EditFulfilmentRequest $request): UseCasePayload;
}

<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHouse;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\House\Application\UseCase\GetHouse\Query\GetHouseQueryInterface;

/**
 *
 */
final class GetHouseService implements GetHouseServiceInterface
{
    private GetHouseQueryInterface $getHouseQuery;

    /**
     * @param GetHouseQueryInterface $getHouseQuery
     */
    public function __construct(GetHouseQueryInterface $getHouseQuery)
    {
        $this->getHouseQuery = $getHouseQuery;
    }

    /**
     * @param GetHouseRequest $request
     * @return UseCasePayload
     */
    public function handle(GetHouseRequest $request): UseCasePayload
    {
        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_CREATED],
            HttpCodes::HTTP_CREATED,
            [
                'house' => $this->getHouseQuery->execute($request->getHouseId())->toArray()
            ]
        );
    }
}

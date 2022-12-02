<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetUsersInHouse;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\House\Application\UseCase\GetUsersInHouse\Query\GetUsersInHouseQueryInterface;

final class GetUsersInHouseService implements GetUsersInHouseServiceInterface
{
    private GetUsersInHouseQueryInterface $getUsersInHouseQuery;

    /**
     * @param GetUsersInHouseQueryInterface $getUsersInHouseQuery
     */
    public function __construct(GetUsersInHouseQueryInterface $getUsersInHouseQuery)
    {
        $this->getUsersInHouseQuery = $getUsersInHouseQuery;
    }

    public function handle(GetUsersInHouseRequest $request): UseCasePayload
    {
        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_OK],
            HttpCodes::HTTP_OK,
            [
                'house_users' => $this->getUsersInHouseQuery->execute($request->getHouseId())->toArray()
            ]
        );
    }
}

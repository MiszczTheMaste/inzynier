<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHousesForUser;

use App\Auth\Application\Query\GetCurrentlyLoggedInUserIdQueryInterface;
use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\House\Application\Query\GetHousesForUserQueryInterface;

final class GetHousesForUserService implements GetHousesForUserServiceInterface
{
    private GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery;

    private GetHousesForUserQueryInterface $getHousesForUserQuery;

    /**
     * @param GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery
     * @param GetHousesForUserQueryInterface $getHousesForUserQuery
     */
    public function __construct(GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery, GetHousesForUserQueryInterface $getHousesForUserQuery)
    {
        $this->getCurrentlyLoggedInUserIdQuery = $getCurrentlyLoggedInUserIdQuery;
        $this->getHousesForUserQuery = $getHousesForUserQuery;
    }


    public function handle(GetHousesForUserRequest $request): UseCasePayload
    {
        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_OK],
            HttpCodes::HTTP_OK,
            [
                'houses' => $this->getHousesForUserQuery->execute($this->getCurrentlyLoggedInUserIdQuery->execute())->toArray()
            ]
        );
    }
}

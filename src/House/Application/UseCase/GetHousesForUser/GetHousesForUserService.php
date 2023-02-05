<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHousesForUser;

use App\Auth\Application\Query\GetCurrentlyLoggedInUserIdQueryInterface;
use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\Exception\DatabaseException;
use App\House\Application\Query\GetHousesForUserQueryInterface;
use App\House\Application\Query\GetUsernameByIdQueryInterface;

/**
 *
 */
final class GetHousesForUserService implements GetHousesForUserServiceInterface
{
    private GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery;

    private GetHousesForUserQueryInterface $getHousesForUserQuery;

    private GetUsernameByIdQueryInterface $getUsernameByIdQuery;

    /**
     * @param GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery
     * @param GetHousesForUserQueryInterface $getHousesForUserQuery
     * @param GetUsernameByIdQueryInterface $getUsernameByIdQuery
     */
    public function __construct(
        GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery,
        GetHousesForUserQueryInterface $getHousesForUserQuery,
        GetUsernameByIdQueryInterface $getUsernameByIdQuery
    ) {
        $this->getCurrentlyLoggedInUserIdQuery = $getCurrentlyLoggedInUserIdQuery;
        $this->getHousesForUserQuery = $getHousesForUserQuery;
        $this->getUsernameByIdQuery = $getUsernameByIdQuery;
    }


    /**
     * @throws DatabaseException
     */
    public function handle(GetHousesForUserRequest $request): UseCasePayload
    {
        $userId = $this->getCurrentlyLoggedInUserIdQuery->execute();

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_OK],
            HttpCodes::HTTP_OK,
            [
                'owner_username' => $this->getUsernameByIdQuery->execute($userId),
                'houses' => $this->getHousesForUserQuery->execute($userId)->toArray()
            ]
        );
    }
}

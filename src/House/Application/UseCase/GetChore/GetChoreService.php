<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetChore;

use App\Auth\Application\Query\GetCurrentlyLoggedInUserIdQueryInterface;
use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\Exception\DatabaseException;
use App\House\Application\Query\GetRoomNameQueryInterface;
use App\House\Application\UseCase\GetChore\Query\GetChoreQueryInterface;

/**
 *
 */
final class GetChoreService implements GetChoreServiceInterface
{
    private GetChoreQueryInterface $getChoreQuery;

    private GetRoomNameQueryInterface $getRoomNameQuery;

    private GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery;

    /**
     * @param GetChoreQueryInterface $getChoreQuery
     * @param GetRoomNameQueryInterface $getRoomNameQuery
     * @param GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery
     */
    public function __construct(GetChoreQueryInterface $getChoreQuery, GetRoomNameQueryInterface $getRoomNameQuery, GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery)
    {
        $this->getChoreQuery = $getChoreQuery;
        $this->getRoomNameQuery = $getRoomNameQuery;
        $this->getCurrentlyLoggedInUserIdQuery = $getCurrentlyLoggedInUserIdQuery;
    }

    /**
     * @throws DatabaseException
     */
    public function handle(GetChoreRequest $request): UseCasePayload
    {
        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_CREATED],
            HttpCodes::HTTP_CREATED,
            [
                'house' => [
                    'id' => $request->getHouseId()
                ],
                'room' => [
                    'id' => $request->getRoomId(),
                    'name' => $this->getRoomNameQuery->execute($request->getRoomId())
                ],
                'chore' => $this->getChoreQuery->execute($request->getChoreId())->toArray(),
                'user' => [
                    'id' => $this->getCurrentlyLoggedInUserIdQuery->execute()
                ]
            ]
        );
    }
}

<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetChore;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\House\Application\Query\GetRoomNameQueryInterface;
use App\House\Application\UseCase\GetChore\Query\GetChoreQueryInterface;

final class GetChoreService implements GetChoreServiceInterface
{
    private GetChoreQueryInterface $getChoreQuery;

    private GetRoomNameQueryInterface $getRoomNameQuery;

    /**
     * @param GetChoreQueryInterface $getChoreQuery
     * @param GetRoomNameQueryInterface $getRoomNameQuery
     */
    public function __construct(GetChoreQueryInterface $getChoreQuery, GetRoomNameQueryInterface $getRoomNameQuery)
    {
        $this->getChoreQuery = $getChoreQuery;
        $this->getRoomNameQuery = $getRoomNameQuery;
    }

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
                'chore' => $this->getChoreQuery->execute($request->getChoreId())->toArray()
            ]
        );
    }
}

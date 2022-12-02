<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetRoom;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\House\Application\Query\GetRoomNameQueryInterface;
use App\House\Application\UseCase\GetRoom\Query\GetChoresQueryInterface;

final class GetRoomService implements GetRoomServiceInterface
{
    private GetChoresQueryInterface $getChoresQuery;

    private GetRoomNameQueryInterface $getRoomNameQuery;

    /**
     * @param GetChoresQueryInterface $getChoresQuery
     * @param GetRoomNameQueryInterface $getRoomNameQuery
     */
    public function __construct(GetChoresQueryInterface $getChoresQuery, GetRoomNameQueryInterface $getRoomNameQuery)
    {
        $this->getChoresQuery = $getChoresQuery;
        $this->getRoomNameQuery = $getRoomNameQuery;
    }

    public function handle(GerRoomRequest $request): UseCasePayload
    {
        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_OK],
            HttpCodes::HTTP_OK,
            [
                'house' => [
                    'id' => $request->getHouseId()
                ],
                'room' => [
                    'id' => $request->getRoomId(),
                    'name' => $this->getRoomNameQuery->execute($request->getRoomId()),
                ],
                'chores' => $this->getChoresQuery->execute($request->getRoomId())->toArray()
            ]
        );
    }
}

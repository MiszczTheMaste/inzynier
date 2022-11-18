<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\RemoveRoom;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\ValueObject\Uuid;
use App\House\Domain\Repository\HouseRepositoryInterface;

final class RemoveRoomService implements RemoveRoomServiceInterface
{
    private HouseRepositoryInterface $repository;

    /**
     * @param HouseRepositoryInterface $repository
     */
    public function __construct(HouseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function handle(RemoveRoomRequest $request): UseCasePayload{
        $house = $this->repository->get(Uuid::fromString($request->getHouseId()));
        $house->removeRoom(Uuid::fromString($request->getRoomId()));
        $this->repository->persist($house);

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_OK],
            HttpCodes::HTTP_OK
        );
    }
}
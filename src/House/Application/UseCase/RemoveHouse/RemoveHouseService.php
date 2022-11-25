<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\RemoveHouse;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidIdException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\ValueObject\Uuid;
use App\House\Domain\Exception\RoomNotFoundException;
use App\House\Domain\Repository\HouseRepositoryInterface;

/**
 *
 */
final class RemoveHouseService implements RemoveHouseServiceInterface
{
    /**
     * @var HouseRepositoryInterface
     */
    private HouseRepositoryInterface $repository;

    /**
     * @param HouseRepositoryInterface $repository
     */
    public function __construct(HouseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param RemoveHouseRequest $request
     * @return UseCasePayload
     * @throws DatabaseException
     * @throws InvalidIdException
     * @throws InvalidObjectTypeInCollectionException
     * @throws RoomNotFoundException
     */
    public function handle(RemoveHouseRequest $request): UseCasePayload
    {
        $house = $this->repository->get(Uuid::fromString($request->getHouseId()));
        $house->removeHouse();
        $this->repository->persist($house);

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_OK],
            HttpCodes::HTTP_OK
        );
    }
}

<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\CreateHouse;

use App\Auth\Application\Query\GetCurrentlyLoggedInUserIdQueryInterface;
use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidIdException;
use App\Core\Domain\Exception\InvalidInputDataException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\ValueObject\Uuid;
use App\House\Domain\Entity\House;
use App\House\Domain\Repository\HouseRepositoryInterface;
use App\House\Domain\ValueObject\RoomCollection;
use App\House\Domain\ValueObject\UserIdCollection;

final class CreateHouseService implements CreateHouseServiceInterface
{
    private HouseRepositoryInterface $repository;

    private GetCurrentlyLoggedInUserIdQueryInterface $getUserIdQuery;

    /**
     * @param HouseRepositoryInterface $repository
     * @param GetCurrentlyLoggedInUserIdQueryInterface $getUserIdQuery
     */
    public function __construct(
        HouseRepositoryInterface $repository,
        GetCurrentlyLoggedInUserIdQueryInterface $getUserIdQuery
    ) {
        $this->repository = $repository;
        $this->getUserIdQuery = $getUserIdQuery;
    }


    /**
     * @param CreateHouseRequest $request
     * @return UseCasePayload
     * @throws DatabaseException
     * @throws InvalidInputDataException
     * @throws InvalidObjectTypeInCollectionException
     * @throws InvalidIdException
     */
    public function handle(CreateHouseRequest $request): UseCasePayload
    {
        $this->validate($request->getData());
        $creatorId = Uuid::fromString($this->getUserIdQuery->execute());
        $house = new House(
            $this->repository->generateId(),
            $creatorId,
            Uuid::fromString($request->getField('icon_id')),
            $request->getField('name'),
            new RoomCollection([]),
            new UserIdCollection([$creatorId])
        );

        $this->repository->persist($house);

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_CREATED],
            HttpCodes::HTTP_CREATED
        );
    }

    /**
     * @param array $data
     * @return void
     * @throws InvalidInputDataException
     */
    private function validate(array $data): void
    {
        if (false === array_key_exists('name', $data)) {
            throw new InvalidInputDataException();
        }
        if (false === array_key_exists('icon_id', $data)) {
            throw new InvalidInputDataException();
        }
    }
}

<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\CreateHouse;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidInputDataException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\House\Application\Query\GetUserIdQueryInterface;
use App\House\Domain\Entity\House;
use App\House\Domain\Repository\HouseRepositoryInterface;
use App\House\Domain\ValueObject\RoomCollection;
use App\House\Domain\ValueObject\UserIdCollection;

final class CreateHouseService implements CreateHouseServiceInterface
{
    private HouseRepositoryInterface $repository;

    private GetUserIdQueryInterface $getUserIdQuery;

    /**
     * @param HouseRepositoryInterface $repository
     * @param GetUserIdQueryInterface $getUserIdQuery
     */
    public function __construct(
        HouseRepositoryInterface $repository,
        GetUserIdQueryInterface $getUserIdQuery
    )
    {
        $this->repository = $repository;
        $this->getUserIdQuery = $getUserIdQuery;
    }


    /**
     * @param CreateHouseRequest $request
     * @return UseCasePayload
     * @throws DatabaseException
     * @throws InvalidInputDataException
     * @throws InvalidObjectTypeInCollectionException
     */
    public function handle(CreateHouseRequest $request): UseCasePayload
    {
        $this->validate($request->getData());
        $house = new House(
            $this->repository->generateId(),
            new RoomCollection([]),
            new UserIdCollection([$this->getUserIdQuery->execute()])
        );

        $this->repository->persist($house);

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_OK],
            HttpCodes::HTTP_OK
        );
    }

    /**
     * @param array $data
     * @return void
     * @throws InvalidInputDataException
     */
    private function validate(array $data): void
    {
        if(false === array_key_exists('name',$data))  {
            throw new InvalidInputDataException();
        }
    }
}
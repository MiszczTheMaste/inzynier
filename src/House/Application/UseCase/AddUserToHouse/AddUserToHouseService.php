<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\AddUserToHouse;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\ValueObject\Uuid;
use App\House\Application\Query\GetUserIdQueryInterface;
use App\House\Domain\Repository\HouseRepositoryInterface;

final class AddUserToHouseService implements AddUserToHouseServiceInterface
{
    /**
     * @var HouseRepositoryInterface
     */
    private HouseRepositoryInterface $repository;

    private GetUserIdQueryInterface $getUserIdQuery;

    /**
     * @param HouseRepositoryInterface $repository
     * @param GetUserIdQueryInterface $getUserIdQuery
     */
    public function __construct(HouseRepositoryInterface $repository, GetUserIdQueryInterface $getUserIdQuery)
    {
        $this->repository = $repository;
        $this->getUserIdQuery = $getUserIdQuery;
    }


    public function handle(AddUserToHouseRequest $request): UseCasePayload
    {
        $userId = $this->getUserIdQuery->execute($request->getField('username'));
        $house = $this->repository->get(Uuid::fromString($request->getHouseId()));

        $house->addUser(Uuid::fromString($userId));

        $this->repository->persist($house);

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_CREATED],
            HttpCodes::HTTP_CREATED
        );
    }
}

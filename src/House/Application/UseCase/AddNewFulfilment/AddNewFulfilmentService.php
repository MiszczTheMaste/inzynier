<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\AddNewFulfilment;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\ValueObject\Uuid;
use App\House\Domain\Repository\HouseRepositoryInterface;

final class AddNewFulfilmentService implements AddNewFulfilmentServiceInterface
{
    private HouseRepositoryInterface $repository;

    /**
     * @param HouseRepositoryInterface $repository
     */
    public function __construct(HouseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(AddNewFulfilmentRequest $request): UseCasePayload
    {
        $house = $this->repository->get(Uuid::fromString($request->getHouseId()));

        $house->fulfilChore(
            Uuid::fromString($request->getRoomId()),
            Uuid::fromString($request->getChoreId()),
            Uuid::fromString($request->getFulfilmentId()),
            $this->repository->generateId()
        );

        $this->repository->persist($house);

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_CREATED],
            HttpCodes::HTTP_CREATED
        );
    }
}
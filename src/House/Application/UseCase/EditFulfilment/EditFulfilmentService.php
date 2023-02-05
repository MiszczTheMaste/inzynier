<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\EditFulfilment;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidIdException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\ValueObject\Uuid;
use App\House\Domain\Exception\ChoreNotFoundException;
use App\House\Domain\Exception\FulfilmentNotFoundException;
use App\House\Domain\Exception\RoomNotFoundException;
use App\House\Domain\Repository\HouseRepositoryInterface;
use App\House\Domain\ValueObject\Rate;

/**
 *
 */
final class EditFulfilmentService implements EditFulfilmentServiceInterface
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
     * @param EditFulfilmentRequest $request
     * @return UseCasePayload
     * @throws DatabaseException
     * @throws InvalidIdException
     * @throws InvalidObjectTypeInCollectionException
     * @throws ChoreNotFoundException
     * @throws FulfilmentNotFoundException
     * @throws RoomNotFoundException
     */
    public function handle(EditFulfilmentRequest $request): UseCasePayload
    {
        $house = $this->repository->get(Uuid::fromString($request->getHouseId()));
        $house->changeFulfillmentRateTo(
            Uuid::fromString($request->getRoomId()),
            Uuid::fromString($request->getChoreId()),
            Uuid::fromString($request->getFulfilmentId()),
            new Rate((int) $request->getField('rate'))
        );

        $this->repository->persist($house);

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_CREATED],
            HttpCodes::HTTP_CREATED
        );
    }
}

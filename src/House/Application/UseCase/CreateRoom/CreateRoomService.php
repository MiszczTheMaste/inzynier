<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\CreateRoom;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidIdException;
use App\Core\Domain\Exception\InvalidInputDataException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\ValueObject\Uuid;
use App\House\Domain\Exception\RoomNotFoundException;
use App\House\Domain\Repository\HouseRepositoryInterface;

/**
 *
 */
final class CreateRoomService implements CreateRoomServiceInterface
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
     * @param CreateRoomRequest $request
     * @return UseCasePayload
     * @throws InvalidInputDataException
     * @throws DatabaseException
     * @throws InvalidIdException
     * @throws InvalidObjectTypeInCollectionException
     * @throws RoomNotFoundException
     */
    public function handle(CreateRoomRequest $request): UseCasePayload
    {
        $this->validate($request->getData());
        $house = $this->repository->get(Uuid::fromString($request->getHouseId()));

        $house->addRoom(
            $this->repository->generateId(),
            $request->getField('name'),
            Uuid::fromString($request->getField('icon_id'))
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

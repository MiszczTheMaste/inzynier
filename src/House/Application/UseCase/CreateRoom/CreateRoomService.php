<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\CreateRoom;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\Exception\InvalidInputDataException;
use App\Core\Domain\ValueObject\Uuid;
use App\House\Application\UseCase\CreateHouse\CreateHouseRequest;
use App\House\Domain\Repository\HouseRepositoryInterface;

final class CreateRoomService implements CreateRoomServiceInterface
{
    private HouseRepositoryInterface $repository;

    /**
     * @param HouseRepositoryInterface $repository
     */
    public function __construct(HouseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CreateRoomRequest $request): UseCasePayload
    {
        $this->validate($request->getData());
        $house = $this->repository->get(Uuid::fromString($request->getHouseId()));
        $house->addRoom(
            $this->repository->generateId(),
            $request->getData()['name'],
            Uuid::fromString($request->getData()['icon_id'])
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
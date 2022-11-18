<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\CreateChore;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\Exception\InvalidInputDataException;
use App\Core\Domain\ValueObject\Uuid;
use App\House\Application\UseCase\CreateHouse\CreateHouseRequest;
use App\House\Domain\Repository\HouseRepositoryInterface;
use App\House\Domain\ValueObject\DaysInterval;

final class CreateChoreService implements CreateChoreServiceInterface
{
    private HouseRepositoryInterface $repository;

    /**
     * @param HouseRepositoryInterface $repository
     */
    public function __construct(HouseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CreateChoreRequest $request): UseCasePayload
    {
        $this->validate($request->getData());
        $house = $this->repository->get(Uuid::fromString($request->getHouseId()));

        $house->addChore(
            $this->repository->generateId(),
            $this->repository->generateId(),
            new (Uuid::fromString($request->getData()['room_id'])),
            new DaysInterval($request->getData()['interval']),
            new \DateTimeImmutable($request->getData()['initial_date']),
            new (Uuid::fromString($request->getData()['icon_id'])),
            new (Uuid::fromString($request->getData()['user_id']))
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
    }
}

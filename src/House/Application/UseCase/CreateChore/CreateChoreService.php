<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\CreateChore;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidIdException;
use App\Core\Domain\Exception\InvalidInputDataException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\ValueObject\Uuid;
use App\House\Domain\Exception\InvalidDaysIntervalException;
use App\House\Domain\Repository\HouseRepositoryInterface;
use App\House\Domain\ValueObject\DaysInterval;
use DateTimeImmutable;
use Exception;

/**
 *
 */
final class CreateChoreService implements CreateChoreServiceInterface
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
     * @param CreateChoreRequest $request
     * @return UseCasePayload
     * @throws InvalidInputDataException
     * @throws DatabaseException
     * @throws InvalidIdException
     * @throws InvalidObjectTypeInCollectionException
     * @throws InvalidDaysIntervalException
     * @throws Exception
     */
    public function handle(CreateChoreRequest $request): UseCasePayload
    {
        $this->validate($request->getData());
        $house = $this->repository->get(Uuid::fromString($request->getHouseId()));

        $house->addChore(
            $this->repository->generateId(),
            $this->repository->generateId(),
            Uuid::fromString($request->getRoomId()),
            new DaysInterval((int) $request->getField('interval')),
            new DateTimeImmutable($request->getField('initial_date')),
            Uuid::fromString($request->getField('icon_id')),
            Uuid::fromString($request->getField('user_id')),
            $request->getField('name')
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
        if (false === array_key_exists('interval', $data)) {
            throw new InvalidInputDataException();
        }
        if (false === array_key_exists('initial_date', $data)) {
            throw new InvalidInputDataException();
        }
        if (false === array_key_exists('icon_id', $data)) {
            throw new InvalidInputDataException();
        }
        if (false === array_key_exists('user_id', $data)) {
            throw new InvalidInputDataException();
        }
    }
}

<?php

declare(strict_types=1);

namespace App\House\Domain\Entity;

use App\Core\Domain\Entity\AbstractEntity;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\Exception\FulfilmentNotFoundException;
use App\House\Domain\ValueObject\ChoreFulfilmentCollection;
use App\House\Domain\ValueObject\DaysInterval;
use DateTimeImmutable;

/**
 *
 */
final class Chore extends AbstractEntity
{
    /**
     * @var DaysInterval
     */
    private DaysInterval $daysInterval;

    /**
     * @var IdInterface
     */
    private IdInterface $iconId;

    /**
     * @var IdInterface
     */
    private IdInterface $userId;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var ChoreFulfilmentCollection
     */
    private ChoreFulfilmentCollection $choreFulfilmentCollection;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $creationDate;

    /**
     * @var bool
     */
    private bool $removed;

    /**
     * @param IdInterface $id
     * @param DaysInterval $daysInterval
     * @param IdInterface $iconId
     * @param IdInterface $userId
     * @param string $name
     * @param ChoreFulfilmentCollection $choreFulfilmentCollection
     * @param DateTimeImmutable $creationDate
     * @param bool $removed
     */
    public function __construct(
        IdInterface $id,
        DaysInterval $daysInterval,
        IdInterface $iconId,
        IdInterface $userId,
        string $name,
        ChoreFulfilmentCollection $choreFulfilmentCollection,
        DateTimeImmutable $creationDate,
        bool $removed = false
    ) {
        parent::__construct($id);
        $this->daysInterval = $daysInterval;
        $this->iconId = $iconId;
        $this->userId = $userId;
        $this->name = $name;
        $this->choreFulfilmentCollection = $choreFulfilmentCollection;
        $this->creationDate = $creationDate;
        $this->removed = $removed;
    }

    /**
     * @return DaysInterval
     */
    public function getDaysInterval(): DaysInterval
    {
        return $this->daysInterval;
    }

    /**
     * @param DaysInterval $daysInterval
     */
    public function setDaysInterval(DaysInterval $daysInterval): void
    {
        $this->daysInterval = $daysInterval;
    }

    /**
     * @return IdInterface
     */
    public function getIconId(): IdInterface
    {
        return $this->iconId;
    }

    /**
     * @param IdInterface $iconId
     */
    public function setIconId(IdInterface $iconId): void
    {
        $this->iconId = $iconId;
    }

    /**
     * @return IdInterface
     */
    public function getUserId(): IdInterface
    {
        return $this->userId;
    }

    /**
     * @param IdInterface $userId
     */
    public function setUserId(IdInterface $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return ChoreFulfilmentCollection
     */
    public function getChoreFulfilmentCollection(): ChoreFulfilmentCollection
    {
        return $this->choreFulfilmentCollection;
    }

    /**
     * @param IdInterface $id
     * @return ChoreFulfilment
     * @throws FulfilmentNotFoundException
     */
    public function getFulfilment(IdInterface $id): ChoreFulfilment
    {
        foreach ($this->choreFulfilmentCollection->getCollection() as $fulfilment) {
            if ($fulfilment->getId()->equals($id)) {
                return $fulfilment;
            }
        }

        throw new FulfilmentNotFoundException();
    }

    /**
     * @param ChoreFulfilmentCollection $choreFulfilmentCollection
     */
    public function setChoreFulfilmentCollection(ChoreFulfilmentCollection $choreFulfilmentCollection): void
    {
        $this->choreFulfilmentCollection = $choreFulfilmentCollection;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }

    /**
     * @param DateTimeImmutable $creationDate
     */
    public function setCreationDate(DateTimeImmutable $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return bool
     */
    public function isRemoved(): bool
    {
        return $this->removed;
    }


    /**
     * @return void
     */
    public function remove(): void
    {
        $this->removed = true;
    }
}

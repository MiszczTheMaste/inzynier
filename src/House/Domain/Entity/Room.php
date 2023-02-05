<?php

declare(strict_types=1);

namespace App\House\Domain\Entity;

use App\Core\Domain\Entity\AbstractEntity;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\Exception\ChoreNotFoundException;
use App\House\Domain\ValueObject\ChoreCollection;
use DateTimeImmutable;

/**
 *
 */
final class Room extends AbstractEntity
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var IdInterface
     */
    private IdInterface $iconId;

    /**
     * @var ChoreCollection
     */
    private ChoreCollection $choreCollection;

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
     * @param string $name
     * @param IdInterface $iconId
     * @param ChoreCollection $choreCollection
     * @param DateTimeImmutable $creationDate
     * @param bool $removed
     */
    public function __construct(
        IdInterface $id,
        string $name,
        IdInterface $iconId,
        ChoreCollection $choreCollection,
        DateTimeImmutable $creationDate,
        bool $removed = false
    ) {
        parent::__construct($id);
        $this->name = $name;
        $this->iconId = $iconId;
        $this->choreCollection = $choreCollection;
        $this->creationDate = $creationDate;
        $this->removed = $removed;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return IdInterface
     */
    public function getIconId(): IdInterface
    {
        return $this->iconId;
    }

    /**
     * @return ChoreCollection
     */
    public function getChoreCollection(): ChoreCollection
    {
        return $this->choreCollection;
    }

    /**
     * @param IdInterface $id
     * @return Chore
     * @throws ChoreNotFoundException
     */
    public function getChore(IdInterface $id): Chore
    {
        foreach ($this->choreCollection->getCollection() as $chore) {
            if ($chore->getId()->equals($id)) {
                return $chore;
            }
        }

        throw new ChoreNotFoundException();
    }

    /**
     * @param Chore $chore
     * @return void
     */
    public function addChore(Chore $chore): void
    {
        $this->choreCollection->add($chore);
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
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

    /**
     * @throws ChoreNotFoundException
     */
    public function removeChore(IdInterface $id): void
    {
        $this->choreCollection->get($id)->remove();
    }
}

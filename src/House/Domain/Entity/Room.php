<?php

declare(strict_types=1);

namespace App\House\Domain\Entity;

use App\Core\Domain\Entity\AbstractEntity;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\ValueObject\ChoreCollection;
use DateTimeImmutable;

final class Room extends AbstractEntity
{
    private string $name;

    private IdInterface $iconId;

    private ChoreCollection $roomCollection;

    private DateTimeImmutable $creationDate;

    private bool $removed;

    /**
     * @param string $name
     * @param IdInterface $iconId
     * @param ChoreCollection $roomCollection
     * @param DateTimeImmutable $creationDate
     * @param bool $removed
     */
    public function __construct(string $name, IdInterface $iconId, ChoreCollection $roomCollection, DateTimeImmutable $creationDate, bool $removed)
    {
        $this->name = $name;
        $this->iconId = $iconId;
        $this->roomCollection = $roomCollection;
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
    public function getRoomCollection(): ChoreCollection
    {
        return $this->roomCollection;
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

    public function remove():void
    {
        $this->removed = true;
    }
}

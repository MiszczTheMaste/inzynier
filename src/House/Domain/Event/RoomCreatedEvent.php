<?php

declare(strict_types=1);

namespace App\House\Domain\Event;

use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\ValueObject\IdInterface;
use DateTimeImmutable;

/**
 *
 */
final class RoomCreatedEvent implements EventInterface
{
    private IdInterface $id;

    private IdInterface $houseId;

    private string $name;

    private IdInterface $iconId;

    private DateTimeImmutable $creationDate;

    /**
     * @param IdInterface $id
     * @param IdInterface $houseId
     * @param string $name
     * @param IdInterface $iconId
     * @param DateTimeImmutable $creationDate
     */
    public function __construct(IdInterface $id, IdInterface $houseId, string $name, IdInterface $iconId, DateTimeImmutable $creationDate)
    {
        $this->id = $id;
        $this->houseId = $houseId;
        $this->name = $name;
        $this->iconId = $iconId;
        $this->creationDate = $creationDate;
    }

    /**
     * @return IdInterface
     */
    public function getId(): IdInterface
    {
        return $this->id;
    }

    /**
     * @return IdInterface
     */
    public function getHouseId(): IdInterface
    {
        return $this->houseId;
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
     * @return DateTimeImmutable
     */
    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }
}

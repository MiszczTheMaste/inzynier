<?php

declare(strict_types=1);

namespace App\House\Domain\Event;

use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\ValueObject\IdInterface;
use DateTimeImmutable;

final class RoomCreatedEvent implements EventInterface
{
    private IdInterface $id;

    private string $name;

    private IdInterface $iconId;

    private DateTimeImmutable $creationDate;

    /**
     * @param IdInterface $id
     * @param string $name
     * @param IdInterface $iconId
     * @param DateTimeImmutable $creationDate
     */
    public function __construct(IdInterface $id, string $name, IdInterface $iconId, DateTimeImmutable $creationDate)
    {
        $this->id = $id;
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

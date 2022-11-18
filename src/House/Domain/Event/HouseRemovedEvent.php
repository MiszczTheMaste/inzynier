<?php

declare(strict_types=1);

namespace App\House\Domain\Event;

use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\ValueObject\IdInterface;

final class HouseRemovedEvent implements EventInterface
{
    private IdInterface $id;

    /**
     * @param IdInterface $id
     */
    public function __construct(IdInterface $id)
    {
        $this->id = $id;
    }

    /**
     * @return IdInterface
     */
    public function getId(): IdInterface
    {
        return $this->id;
    }
}
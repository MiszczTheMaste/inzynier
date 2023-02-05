<?php

declare(strict_types=1);

namespace App\House\Domain\Event;

use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\ValueObject\Rate;

/**
 *
 */
final class FulfilmentRateChangedEvent implements EventInterface
{
    private IdInterface $id;

    private Rate $rate;

    /**
     * @param IdInterface $id
     * @param Rate $rate
     */
    public function __construct(IdInterface $id, Rate $rate)
    {
        $this->id = $id;
        $this->rate = $rate;
    }

    /**
     * @return IdInterface
     */
    public function getId(): IdInterface
    {
        return $this->id;
    }

    /**
     * @return Rate
     */
    public function getRate(): Rate
    {
        return $this->rate;
    }
}

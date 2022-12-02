<?php

declare(strict_types=1);

namespace App\House\Domain\Entity;

use App\Core\Domain\Entity\AbstractEntity;
use App\Core\Domain\ValueObject\IdInterface;
use App\House\Domain\ValueObject\Rate;
use DateTimeImmutable;

final class ChoreFulfilment extends AbstractEntity
{
    private DateTimeImmutable $deadline;

    private bool $finished;

    private Rate $rate;

    /**
     * @param IdInterface $id
     * @param DateTimeImmutable $deadline
     * @param bool $finished
     * @param Rate $rate
 */
    public function __construct(
        IdInterface $id,
        DateTimeImmutable $deadline,
        bool $finished,
        Rate $rate
    ) {
        parent::__construct($id);
        $this->deadline = $deadline;
        $this->finished = $finished;
        $this->rate = $rate;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDeadline(): DateTimeImmutable
    {
        return $this->deadline;
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function finish(): void
    {
        $this->finished = true;
    }

    /**
     * @return Rate
     */
    public function getRate(): Rate
    {
        return $this->rate;
    }
}

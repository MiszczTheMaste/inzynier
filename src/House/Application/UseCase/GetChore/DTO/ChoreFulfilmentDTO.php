<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetChore\DTO;

final class ChoreFulfilmentDTO
{
    private string $id;

    private string $deadline;

    private bool $finished;

    private int $rate;

    /**
     * @param string $id
     * @param string $deadline
     * @param bool $finished
     * @param int $rate
     */
    public function __construct(string $id, string $deadline, bool $finished, int $rate)
    {
        $this->id = $id;
        $this->deadline = $deadline;
        $this->finished = $finished;
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDeadline(): string
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

    /**
     * @return int
     */
    public function getRate(): int
    {
        return $this->rate;
    }
}

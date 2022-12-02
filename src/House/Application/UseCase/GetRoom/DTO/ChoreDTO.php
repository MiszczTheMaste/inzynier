<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetRoom\DTO;

use DateTimeImmutable;

final class ChoreDTO
{
    private string $id;

    private string $name;

    private DateTimeImmutable $deadline;

    private int $interval;

    private string $responsibleUser;

    /**
     * @param string $id
     * @param string $name
     * @param DateTimeImmutable $deadline
     * @param int $interval
     * @param string $responsibleUser
     */
    public function __construct(string $id, string $name, DateTimeImmutable $deadline, int $interval, string $responsibleUser)
    {
        $this->id = $id;
        $this->name = $name;
        $this->deadline = $deadline;
        $this->interval = $interval;
        $this->responsibleUser = $responsibleUser;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDeadline(): DateTimeImmutable
    {
        return $this->deadline;
    }

    /**
     * @return int
     */
    public function getInterval(): int
    {
        return $this->interval;
    }

    /**
     * @return string
     */
    public function getResponsibleUser(): string
    {
        return $this->responsibleUser;
    }
}

<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHouse\DTO;

final class RoomDTO
{
    private string $id;

    private string $name;

    private string $icon;

    private int $choresAfterDeadline;

    /**
     * @param string $id
     * @param string $name
     * @param string $icon
     * @param int $choresAfterDeadline
     */
    public function __construct(string $id, string $name, string $icon, int $choresAfterDeadline)
    {
        $this->id = $id;
        $this->name = $name;
        $this->icon = $icon;
        $this->choresAfterDeadline = $choresAfterDeadline;
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
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return int
     */
    public function getChoresAfterDeadline(): int
    {
        return $this->choresAfterDeadline;
    }
}

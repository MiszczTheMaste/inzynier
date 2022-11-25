<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHouse\DTO;

final class RoomDTO
{
    private string $id;

    private string $name;

    private string $icon;

    /**
     * @param string $id
     * @param string $name
     * @param string $icon
     */
    public function __construct(string $id, string $name, string $icon)
    {
        $this->id = $id;
        $this->name = $name;
        $this->icon = $icon;
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
}

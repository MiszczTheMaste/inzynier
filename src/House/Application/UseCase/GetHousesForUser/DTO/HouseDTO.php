<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetHousesForUser\DTO;

final class HouseDTO
{
    private string $id;

    private string $name;

    private string $iconUrl;

    /**
     * @param string $id
     * @param string $name
     * @param string $iconUrl
     */
    public function __construct(string $id, string $name, string $iconUrl)
    {
        $this->id = $id;
        $this->name = $name;
        $this->iconUrl = $iconUrl;
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
    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }
}

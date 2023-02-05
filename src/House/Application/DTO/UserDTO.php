<?php

declare(strict_types=1);

namespace App\House\Application\DTO;

/**
 *
 */
final class UserDTO
{
    private string $id;

    private string $username;

    /**
     * @param string $id
     * @param string $username
     */
    public function __construct(string $id, string $username)
    {
        $this->id = $id;
        $this->username = $username;
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
    public function getUsername(): string
    {
        return $this->username;
    }
}

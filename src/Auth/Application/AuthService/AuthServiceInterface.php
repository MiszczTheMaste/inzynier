<?php

declare(strict_types=1);

namespace App\Auth\Application\AuthService;

interface AuthServiceInterface
{
    public function isUserLoggedIn(): bool;
}
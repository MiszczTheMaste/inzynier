<?php

declare(strict_types=1);

namespace App\Auth\Application\AuthService;

use Symfony\Component\HttpFoundation\RequestStack;

final class SessionAuthService implements AuthServiceInterface
{
    public const SESSION_KEY = 'auth.user-id';

    private RequestStack $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function isUserLoggedIn(): bool
    {
        return false === is_null($this->requestStack->getSession()->get(SessionAuthService::SESSION_KEY));
    }
}
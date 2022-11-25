<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Query;

use App\Auth\Application\Query\GetCurrentlyLoggedInUserIdQueryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class GetCurrentlyLoggedInUserIdSessionQuery implements GetCurrentlyLoggedInUserIdQueryInterface
{
    private RequestStack $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @inheritdoc
     */
    public function execute(): ?string
    {
        return $this->requestStack->getSession()->get('auth.user-id');
    }
}

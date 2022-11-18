<?php

declare(strict_types=1);

namespace App\House\Infrastructure\Query;

use App\Core\Domain\Exception\DatabaseException;
use App\House\Application\Query\GetCurrentlyLoggedInUserIdQueryInterface;
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
    public function execute(): string
    {
        $userId = $this->requestStack->getSession()->get('auth.user-id');
        if (is_null($userId)) {
            throw new DatabaseException();
        }

        return $userId;
    }
}

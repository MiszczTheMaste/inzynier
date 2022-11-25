<?php

declare(strict_types=1);

namespace App\Auth\Application\UseCase\Login;

use App\Auth\Application\AuthService\SessionAuthService;
use App\Auth\Domain\Exception\InvalidPasswordException;
use App\Auth\Domain\Repository\UserRepositoryInterface;
use App\Auth\Domain\ValueObject\Username;
use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use Symfony\Component\HttpFoundation\RequestStack;

final class LoginService implements LoginServiceInterface
{
    private UserRepositoryInterface $repository;

    private RequestStack $requestStack;

    /**
     * @param UserRepositoryInterface $repository
     * @param RequestStack $requestStack
     */
    public function __construct(UserRepositoryInterface $repository, RequestStack $requestStack)
    {
        $this->repository = $repository;
        $this->requestStack = $requestStack;
    }

    /**
     * @inheritDoc
     */
    public function handle(LoginRequest $request): UseCasePayload
    {
        $username = new Username($request->getUsername());

        $sessionData = $this->requestStack->getSession()->get(SessionAuthService::SESSION_KEY);

        if (false === is_null($sessionData)) {
            return new UseCasePayload(
                'User already logged in',
                HttpCodes::HTTP_BAD_REQUEST
            );
        }

        $user = $this->repository->get($username);

        if (false === $user->getPassword()->verify($request->getPassword())) {
            throw new InvalidPasswordException();
        }

        $this->requestStack->getSession()->set(SessionAuthService::SESSION_KEY, $user->getId()->toString());

        return new UseCasePayload(
            'Logged in',
            HttpCodes::HTTP_OK
        );
    }
}

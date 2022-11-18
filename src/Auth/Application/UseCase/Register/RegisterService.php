<?php

declare(strict_types=1);

namespace App\Auth\Application\UseCase\Register;

use App\Auth\Domain\Entity\User;
use App\Auth\Domain\Repository\UserRepositoryInterface;
use App\Auth\Domain\ValueObject\PasswordHash;
use App\Auth\Domain\ValueObject\Username;

final class RegisterService implements RegisterServiceInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function handle(RegisterRequest $request): array
    {
        $user = new User(
            $this->repository->generateId(),
            new Username($request->getData()['username']),
            PasswordHash::createHash($request->getData()['password']),
        );

        $this->repository->persist($user);

        return [
            'message' => 'User created',
            'username' => $user->getUsername()->toString()
        ];
    }
}

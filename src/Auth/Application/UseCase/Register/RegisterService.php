<?php

declare(strict_types=1);

namespace App\Auth\Application\UseCase\Register;

use App\Auth\Domain\Entity\User;
use App\Auth\Domain\Exception\UserExistsException;
use App\Auth\Domain\Repository\UserRepositoryInterface;
use App\Auth\Domain\ValueObject\PasswordHash;
use App\Auth\Domain\ValueObject\Username;
use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use Exception;

/**
 *
 */
final class RegisterService implements RegisterServiceInterface
{
    private UserRepositoryInterface $repository;

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function handle(RegisterRequest $request): UseCasePayload
    {
        try {
            $user = $this->repository->get(new Username((string) $request->getField('username')));
        } catch (Exception){

        }

        if(false === empty($user)){
            throw new UserExistsException();
        }
        
        $user = new User(
            $this->repository->generateId(),
            new Username((string) $request->getField('username')),
            PasswordHash::createHash((string) $request->getField('password')),
        );

        $this->repository->persist($user);

        return new UseCasePayload(
            'User created',
            HttpCodes::HTTP_CREATED
        );
    }
}

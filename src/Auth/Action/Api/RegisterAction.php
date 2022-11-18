<?php

declare(strict_types=1);

namespace App\Auth\Action\Api;

use App\Auth\Application\UseCase\Register\RegisterRequest;
use App\Auth\Application\UseCase\Register\RegisterServiceInterface;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RegisterAction
{
    private RegisterServiceInterface $service;

    public function __construct(RegisterServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            return new JsonResponse(
                $this->service->handle(new RegisterRequest(json_decode($request->getContent(), true))),
                Response::HTTP_CREATED
            );
        } catch (DatabaseException) {
            return new JsonResponse(
                ['message' => 'Error during saving user'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (InvalidObjectTypeInCollectionException) {
            return new JsonResponse(
                ['message' => 'Unknown error has occurred'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

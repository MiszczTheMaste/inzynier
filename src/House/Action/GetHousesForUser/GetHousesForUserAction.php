<?php

declare(strict_types=1);

namespace App\House\Action\GetHousesForUser;

use App\House\Application\UseCase\GetHousesForUser\GetHousesForUserRequest;
use App\House\Application\UseCase\GetHousesForUser\GetHousesForUserServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetHousesForUserAction
{
    private GetHousesForUserServiceInterface $service;

    public function __construct(GetHousesForUserServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $response = $this->service->handle(new GetHousesForUserRequest());

            return new JsonResponse(
                $response->getPayload(),
                $response->getCode()
            );
        } catch (Exception) {
            return new JsonResponse(
                ['message' => 'Unknown error has occurred'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

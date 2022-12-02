<?php

declare(strict_types=1);

namespace App\House\Action\GetChore;

use App\House\Application\UseCase\GetChore\GetChoreRequest;
use App\House\Application\UseCase\GetChore\GetChoreServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetChoreAction
{
    private GetChoreServiceInterface $service;

    public function __construct(GetChoreServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $response = $this->service->handle(
                new GetChoreRequest(
                    $request->get('house_id'),
                    $request->get('room_id'),
                    $request->get('chore_id')
                )
            );

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

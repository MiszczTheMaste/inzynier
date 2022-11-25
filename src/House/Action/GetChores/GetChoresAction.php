<?php

declare(strict_types=1);

namespace App\House\Action\GetChores;

use App\House\Application\UseCase\GetChores\GetChoresRequest;
use App\House\Application\UseCase\GetChores\GetChoresServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetChoresAction
{
    private GetChoresServiceInterface $service;

    public function __construct(GetChoresServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $response = $this->service->handle(
                new GetChoresRequest(
                    $request->get('house_id'),
                    $request->get('room_id')
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

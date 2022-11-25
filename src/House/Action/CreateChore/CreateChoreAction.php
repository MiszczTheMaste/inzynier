<?php

declare(strict_types=1);

namespace App\House\Action\CreateChore;

use App\House\Application\UseCase\CreateChore\CreateChoreRequest;
use App\House\Application\UseCase\CreateChore\CreateChoreServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateChoreAction
{
    private CreateChoreServiceInterface $service;

    public function __construct(CreateChoreServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $data = json_decode((string)$request->getContent(), true);

            if (false === is_array($data)) {
                throw new Exception();
            }

            $response = $this->service->handle(
                new CreateChoreRequest(
                    $request->get('house_id'),
                    $request->get('room_id'),
                    $data
                )
            );

            return new JsonResponse(
                $response->getMessage(),
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

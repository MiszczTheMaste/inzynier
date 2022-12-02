<?php

declare(strict_types=1);

namespace App\House\Action\GetRoom;

use App\House\Application\UseCase\GetRoom\GerRoomRequest;
use App\House\Application\UseCase\GetRoom\GetRoomServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetRoomAction
{
    private GetRoomServiceInterface $service;

    public function __construct(GetRoomServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $response = $this->service->handle(
                new GerRoomRequest(
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

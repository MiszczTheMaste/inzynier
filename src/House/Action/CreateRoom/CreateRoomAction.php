<?php

declare(strict_types=1);

namespace App\House\Action\CreateRoom;

use App\House\Application\UseCase\CreateRoom\CreateRoomRequest;
use App\House\Application\UseCase\CreateRoom\CreateRoomServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateRoomAction
{
    private CreateRoomServiceInterface $service;

    public function __construct(CreateRoomServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        try {
            if ('json' === $request->get('format')) {
                $data = json_decode((string)$request->getContent(), true);
            } else {
                $data = [
                    'name' => $request->get('name'),
                    'icon_id' => $request->get('icon_id')
                ];
            }

            if (false === is_array($data)) {
                throw new Exception();
            }

            $response = $this->service->handle(new CreateRoomRequest($request->get('house_id'), $data));

            if ('json' === $request->get('format')) {
                return new JsonResponse(
                    $response->getMessage(),
                    $response->getCode()
                );
            }

            return new RedirectResponse($request->get('redirect_address') ?? '/');
        } catch (Exception) {
            return new JsonResponse(
                ['message' => 'Unknown error has occurred'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

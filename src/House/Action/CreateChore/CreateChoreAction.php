<?php

declare(strict_types=1);

namespace App\House\Action\CreateChore;

use App\House\Application\UseCase\CreateChore\CreateChoreRequest;
use App\House\Application\UseCase\CreateChore\CreateChoreServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class CreateChoreAction
{
    private CreateChoreServiceInterface $service;

    /**
     * @param CreateChoreServiceInterface $service
     */
    public function __construct(CreateChoreServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        try {
            if ('json' === $request->get('format')) {
                $data = json_decode((string)$request->getContent(), true);
            } else {
                $data = [
                    'interval' => $request->get('interval'),
                    'initial_date' => $request->get('initial_date'),
                    'icon_id' => $request->get('icon_id'),
                    'user_id' => $request->get('user_id'),
                    'name' => $request->get('name'),
                ];
            }

            $response = $this->service->handle(
                new CreateChoreRequest(
                    $request->get('house_id'),
                    $request->get('room_id'),
                    $data
                )
            );


            if ('json' === $request->get('format')) {
                return new JsonResponse(
                    $response->getMessage(),
                    $response->getCode()
                );
            }

            return new RedirectResponse($request->get('redirect_address') ?? '/');
        } catch (Exception) {
            if ('json' === $request->get('format')) {
                return new JsonResponse(
                    ['message' => 'Unknown error has occurred'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $request->getSession()->getFlashBag()->add('error', 'Wystąpił problem.');
            return new RedirectResponse($request->get('redirect_address') ?? '/');
        }
    }
}

<?php

declare(strict_types=1);

namespace App\House\Action\GetUsersInHouse;

use App\House\Application\UseCase\GetUsersInHouse\GetUsersInHouseRequest;
use App\House\Application\UseCase\GetUsersInHouse\GetUsersInHouseServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class GetUsersInHouseAction
{
    private GetUsersInHouseServiceInterface $service;

    /**
     * @param GetUsersInHouseServiceInterface $service
     */
    public function __construct(GetUsersInHouseServiceInterface $service)
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
            $response = $this->service->handle(
                new GetUsersInHouseRequest(
                    $request->get('house_id')
                )
            );

            return new JsonResponse(
                $response->getPayload(),
                $response->getCode()
            );
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

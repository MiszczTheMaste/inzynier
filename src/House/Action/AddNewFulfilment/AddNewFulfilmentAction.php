<?php

declare(strict_types=1);

namespace App\House\Action\AddNewFulfilment;

use App\House\Application\UseCase\AddNewFulfilment\AddNewFulfilmentRequest;
use App\House\Application\UseCase\AddNewFulfilment\AddNewFulfilmentServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class AddNewFulfilmentAction
{
    private AddNewFulfilmentServiceInterface $service;

    /**
     * @param AddNewFulfilmentServiceInterface $service
     */
    public function __construct(AddNewFulfilmentServiceInterface $service)
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
                new AddNewFulfilmentRequest(
                    $request->get('house_id'),
                    $request->get('room_id'),
                    $request->get('chore_id'),
                    $request->get('fulfilment_id'),
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

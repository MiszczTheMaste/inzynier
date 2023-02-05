<?php

declare(strict_types=1);

namespace App\House\Action\EditFulfilment;

use App\House\Application\UseCase\EditFulfilment\EditFulfilmentRequest;
use App\House\Application\UseCase\EditFulfilment\EditFulfilmentServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class EditFulfilmentAction
{
    private EditFulfilmentServiceInterface $service;

    /**
     * @param EditFulfilmentServiceInterface $service
     */
    public function __construct(EditFulfilmentServiceInterface $service)
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
            $this->service->handle(
                new EditFulfilmentRequest(
                    ['rate' => $request->get('rate')],
                    $request->get('house_id'),
                    $request->get('room_id'),
                    $request->get('chore_id'),
                    $request->get('fulfilment_id'),
                )
            );

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
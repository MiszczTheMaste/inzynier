<?php

declare(strict_types=1);

namespace App\House\Action\AddUserToHouse;

use App\House\Application\UseCase\AddUserToHouse\AddUserToHouseRequest;
use App\House\Application\UseCase\AddUserToHouse\AddUserToHouseServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class AddUserToHouseAction
{
    private AddUserToHouseServiceInterface $service;

    /**
     * @param AddUserToHouseServiceInterface $service
     */
    public function __construct(AddUserToHouseServiceInterface $service)
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
                    'username' => $request->get('username')
                ];
            }

            if (false === is_array($data)) {
                throw new Exception();
            }

            $response = $this->service->handle(
                new AddUserToHouseRequest(
                    $request->get('house_id'),
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
            $request->getSession()->getFlashBag()->add('error', 'Nie znaleziono użytkownika.');
            return new RedirectResponse($request->get('redirect_address') ?? '/');
        }
    }
}

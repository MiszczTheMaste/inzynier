<?php

declare(strict_types=1);

namespace App\House\Action\CreateHouse;

use App\House\Application\UseCase\CreateHouse\CreateHouseRequest;
use App\House\Application\UseCase\CreateHouse\CreateHouseServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class CreateHouseAction
{
    private CreateHouseServiceInterface $service;

    /**
     * @param CreateHouseServiceInterface $service
     */
    public function __construct(CreateHouseServiceInterface $service)
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
                $data = json_decode((string) $request->getContent(), true);
            } else {
                $data = [
                    'name' => $request->get('name'),
                    'icon_id' => $request->get('icon_id')
                ];
            }

            if (false === is_array($data)) {
                throw new Exception();
            }

            $response = $this->service->handle(new CreateHouseRequest($data));

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

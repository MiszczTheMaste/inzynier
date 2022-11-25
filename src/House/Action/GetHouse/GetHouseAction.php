<?php

declare(strict_types=1);

namespace App\House\Action\GetHouse;

use App\House\Application\UseCase\GetHouse\GetHouseRequest;
use App\House\Application\UseCase\GetHouse\GetHouseServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetHouseAction
{
    private GetHouseServiceInterface $service;

    public function __construct(GetHouseServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        //try {
            $response = $this->service->handle(new GetHouseRequest($request->get('house_id')));

            return new JsonResponse(
                $response->getPayload(),
                $response->getCode()
            );
       /* } catch (Exception) {
            return new JsonResponse(
                ['message' => 'Unknown error has occurred'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }*/
    }
}

<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewHouse\ViewHouseRequest;
use App\Front\Application\UseCase\ViewHouse\ViewHouseServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class ViewHouseAction
{
    private ViewHouseServiceInterface $service;

    /**
     * @param ViewHouseServiceInterface $service
     */
    public function __construct(ViewHouseServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $response = $this->service->handle(new ViewHouseRequest($request->get('house_id')));
        return $response->getPayload()['page'];
    }
}

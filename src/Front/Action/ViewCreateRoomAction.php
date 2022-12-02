<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewCreateRoom\ViewCreateRoomRequest;
use App\Front\Application\UseCase\ViewCreateRoom\ViewCreateRoomServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewCreateRoomAction
{
    private ViewCreateRoomServiceInterface $service;

    /**
     * @param ViewCreateRoomServiceInterface $service
     */
    public function __construct(ViewCreateRoomServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        $response = $this->service->handle(new ViewCreateRoomRequest($request->get('house_id')));
        return $response->getPayload()['page'];
    }
}

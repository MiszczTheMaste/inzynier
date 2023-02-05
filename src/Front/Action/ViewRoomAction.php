<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewRoom\ViewRoomRequest;
use App\Front\Application\UseCase\ViewRoom\ViewRoomServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class ViewRoomAction
{
    private ViewRoomServiceInterface $service;

    /**
     * @param ViewRoomServiceInterface $service
     */
    public function __construct(ViewRoomServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $response = $this->service->handle(
            new ViewRoomRequest(
                $request->get('house_id'),
                $request->get('room_id')
            )
        );
        return $response->getPayload()['page'];
    }
}

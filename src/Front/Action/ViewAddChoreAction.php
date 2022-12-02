<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewAddChore\ViewAddChoreRequest;
use App\Front\Application\UseCase\ViewAddChore\ViewAddChoreServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewAddChoreAction
{
    private ViewAddChoreServiceInterface $service;

    /**
     * @param ViewAddChoreServiceInterface $service
     */
    public function __construct(ViewAddChoreServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        $response = $this->service->handle(
            new ViewAddChoreRequest(
                $request->get('house_id'),
                $request->get('room_id'),
            )
        );
        return $response->getPayload()['page'];
    }
}

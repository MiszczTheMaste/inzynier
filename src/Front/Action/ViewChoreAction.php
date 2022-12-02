<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewChore\ViewChoreRequest;
use App\Front\Application\UseCase\ViewChore\ViewChoreServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewChoreAction
{
    private ViewChoreServiceInterface $service;

    /**
     * @param ViewChoreServiceInterface $service
     */
    public function __construct(ViewChoreServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        $response = $this->service->handle(
            new ViewChoreRequest(
                $request->get('house_id'),
                $request->get('room_id'),
                $request->get('chore_id')
            )
        );
        return $response->getPayload()['page'];
    }
}

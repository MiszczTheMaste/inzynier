<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewAddUser\ViewAddUserRequest;
use App\Front\Application\UseCase\ViewAddUser\ViewAddUserServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewAddUserAction
{
    private ViewAddUserServiceInterface $service;

    /**
     * @param ViewAddUserServiceInterface $service
     */
    public function __construct(ViewAddUserServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        $response = $this->service->handle(new ViewAddUserRequest($request->get('house_id')));
        return $response->getPayload()['page'];
    }
}

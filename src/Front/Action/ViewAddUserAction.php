<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewAddUser\ViewAddUserRequest;
use App\Front\Application\UseCase\ViewAddUser\ViewAddUserServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewAddUserAction
{
    private ViewAddUserServiceInterface $viewHomepageService;

    /**
     * @param ViewAddUserServiceInterface $viewHomepageService
     */
    public function __construct(ViewAddUserServiceInterface $viewHomepageService)
    {
        $this->viewHomepageService = $viewHomepageService;
    }

    public function __invoke(Request $request): Response
    {
        $response = $this->viewHomepageService->handle(new ViewAddUserRequest($request->get('house_id')));
        return $response->getPayload()['page'];
    }
}

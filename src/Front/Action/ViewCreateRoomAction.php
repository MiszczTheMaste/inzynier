<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewCreateRoom\ViewCreateRoomRequest;
use App\Front\Application\UseCase\ViewCreateRoom\ViewCreateRoomServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewCreateRoomAction
{
    private ViewCreateRoomServiceInterface $viewHomepageService;

    /**
     * @param ViewCreateRoomServiceInterface $viewHomepageService
     */
    public function __construct(ViewCreateRoomServiceInterface $viewHomepageService)
    {
        $this->viewHomepageService = $viewHomepageService;
    }

    public function __invoke(Request $request): Response
    {
        $response = $this->viewHomepageService->handle(new ViewCreateRoomRequest($request->get('house_id')));
        return $response->getPayload()['page'];
    }
}

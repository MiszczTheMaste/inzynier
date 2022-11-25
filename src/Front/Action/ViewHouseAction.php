<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewHouse\ViewHouseRequest;
use App\Front\Application\UseCase\ViewHouse\ViewHouseServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewHouseAction
{
    private ViewHouseServiceInterface $viewHomepageService;

    /**
     * @param ViewHouseServiceInterface $viewHomepageService
     */
    public function __construct(ViewHouseServiceInterface $viewHomepageService)
    {
        $this->viewHomepageService = $viewHomepageService;
    }

    public function __invoke(Request $request): Response
    {
        $response = $this->viewHomepageService->handle(new ViewHouseRequest($request->get('house_id')));
        return $response->getPayload()['page'];
    }
}

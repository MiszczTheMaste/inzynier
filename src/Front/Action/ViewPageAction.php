<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewPage\ViewPageRequest;
use App\Front\Application\UseCase\ViewPage\ViewPageServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewPageAction
{
    private ViewPageServiceInterface $viewHomepageService;

    /**
     * @param ViewPageServiceInterface $viewHomepageService
     */
    public function __construct(ViewPageServiceInterface $viewHomepageService)
    {
        $this->viewHomepageService = $viewHomepageService;
    }

    public function __invoke(Request $request): Response
    {
        $response = $this->viewHomepageService->handle(new ViewPageRequest($request->get('page')));
        return $response->getPayload()['page'];
    }
}

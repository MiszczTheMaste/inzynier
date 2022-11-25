<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewHomepage\ViewHomepageRequest;
use App\Front\Application\UseCase\ViewHomepage\ViewHomepageServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewHomepageAction
{
    private ViewHomepageServiceInterface $viewHomepageService;

    /**
     * @param ViewHomepageServiceInterface $viewHomepageService
     */
    public function __construct(ViewHomepageServiceInterface $viewHomepageService)
    {
        $this->viewHomepageService = $viewHomepageService;
    }

    public function __invoke(Request $request): Response
    {
        $response = $this->viewHomepageService->handle(new ViewHomepageRequest());
        return $response->getPayload()['page'];
    }
}

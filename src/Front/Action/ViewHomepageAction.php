<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewHomepage\ViewHomepageRequest;
use App\Front\Application\UseCase\ViewHomepage\ViewHomepageServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewHomepageAction
{
    private ViewHomepageServiceInterface $service;

    /**
     * @param ViewHomepageServiceInterface $service
     */
    public function __construct(ViewHomepageServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        $response = $this->service->handle(new ViewHomepageRequest());
        return $response->getPayload()['page'];
    }
}

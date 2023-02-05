<?php

declare(strict_types=1);

namespace App\Front\Action;

use App\Front\Application\UseCase\ViewPage\ViewPageRequest;
use App\Front\Application\UseCase\ViewPage\ViewPageServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class ViewPageAction
{
    private ViewPageServiceInterface $service;

    /**
     * @param ViewPageServiceInterface $service
     */
    public function __construct(ViewPageServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $response = $this->service->handle(new ViewPageRequest($request->get('page')));
        return $response->getPayload()['page'];
    }
}

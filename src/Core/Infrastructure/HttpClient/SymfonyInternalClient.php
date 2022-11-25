<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\HttpClient;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;

final class SymfonyInternalClient
{
    /** @var RequestMatcherInterface */
    private RequestMatcherInterface $router;

    /** @var ControllerResolverInterface */
    private ControllerResolverInterface $controllerResolver;

    /**
     * @param RequestMatcherInterface $router
     * @param ControllerResolverInterface $controllerResolver
     */
    public function __construct(
        RequestMatcherInterface $router,
        ControllerResolverInterface $controllerResolver
    ) {
        $this->router = $router;
        $this->controllerResolver = $controllerResolver;
    }

    public function sendRequest(Request $request): Response
    {
        $controller = $this->getControllerForRequest($request);

        foreach ($controller as $key => $row) {
            $request->attributes->add([$key => $row]);
        }

        $controller = $this->controllerResolver->getController($request);
        return $controller($request);
    }

    /**
     * @param Request $symfonyRequest
     * @return array<string,string>
     */
    private function getControllerForRequest(Request $symfonyRequest): array
    {
        $mainRequestMethod = $this->router->getContext()->getMethod();
        $this->router->getContext()->setMethod($symfonyRequest->getMethod());

        $controller = $this->router->matchRequest($symfonyRequest);

        $this->router->getContext()->setMethod($mainRequestMethod);

        return $controller;
    }
}

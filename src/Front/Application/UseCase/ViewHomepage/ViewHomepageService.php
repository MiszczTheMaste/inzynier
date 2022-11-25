<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewHomepage;

use App\Auth\Application\Query\GetCurrentlyLoggedInUserIdQueryInterface;
use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Infrastructure\HttpClient\SymfonyInternalClient;
use App\Front\Application\View\TwigView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewHomepageService implements ViewHomepageServiceInterface
{
    private TwigView $view;

    private SymfonyInternalClient $symfonyInternalClient;

    private GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery;

    /**
     * @param TwigView $view
     * @param SymfonyInternalClient $symfonyInternalClient
     * @param GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery
     */
    public function __construct(TwigView $view, SymfonyInternalClient $symfonyInternalClient, GetCurrentlyLoggedInUserIdQueryInterface $getCurrentlyLoggedInUserIdQuery)
    {
        $this->view = $view;
        $this->symfonyInternalClient = $symfonyInternalClient;
        $this->getCurrentlyLoggedInUserIdQuery = $getCurrentlyLoggedInUserIdQuery;
    }

    public function handle(ViewHomepageRequest $request): UseCasePayload
    {
        if (is_null($this->getCurrentlyLoggedInUserIdQuery->execute())) {
            $page = new Response($this->view->render('base'));
        } else {
            $houses = $this->symfonyInternalClient->sendRequest(
                Request::create(
                    'http://127.0.0.1:8000/api/houses.json',
                    'GET'
                )
            );

            $page = new Response(
                $this->view->render(
                    'home',
                    json_decode($houses->getContent(), true)
                )
            );
        }

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_CREATED],
            HttpCodes::HTTP_CREATED,
            ['page' => $page]
        );
    }
}

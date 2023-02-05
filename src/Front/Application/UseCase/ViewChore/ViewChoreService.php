<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewChore;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Infrastructure\HttpClient\SymfonyInternalClient;
use App\Front\Application\View\TwigView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 *
 */
final class ViewChoreService implements ViewChoreServiceInterface
{
    private TwigView $view;

    private SymfonyInternalClient $symfonyInternalClient;

    /**
     * @param TwigView $view
     * @param SymfonyInternalClient $symfonyInternalClient
     */
    public function __construct(TwigView $view, SymfonyInternalClient $symfonyInternalClient)
    {
        $this->view = $view;
        $this->symfonyInternalClient = $symfonyInternalClient;
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function handle(ViewChoreRequest $request): UseCasePayload
    {
        $houses = $this->symfonyInternalClient->sendRequest(
            Request::create(
                'http://127.0.0.1:8000/api/houses/' .
                $request->getHouseId() .
                '/rooms/' .
                $request->getRoomId() .
                '/chores/' .
                $request->getChoreId() .
                '.json'
            )
        );

        $page = new Response(
            $this->view->render(
                'chore',
                json_decode($houses->getContent(), true)
            )
        );

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_CREATED],
            HttpCodes::HTTP_CREATED,
            ['page' => $page]
        );
    }
}

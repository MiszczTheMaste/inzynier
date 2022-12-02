<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewAddChore;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Infrastructure\HttpClient\SymfonyInternalClient;
use App\Front\Application\View\TwigView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewAddChoreService implements ViewAddChoreServiceInterface
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

    public function handle(ViewAddChoreRequest $request): UseCasePayload
    {
        $room = $this->symfonyInternalClient->sendRequest(
            Request::create('http://127.0.0.1:8000/api/houses/' . $request->getHouseId() . '/rooms/' . $request->getRoomId() . '.json')
        );

        $page = new Response(
            $this->view->render(
                'add-chore-to-room',
                json_decode($room->getContent(), true)
            )
        );

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_CREATED],
            HttpCodes::HTTP_CREATED,
            ['page' => $page]
        );
    }
}

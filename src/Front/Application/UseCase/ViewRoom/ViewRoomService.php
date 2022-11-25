<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewRoom;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Core\Infrastructure\HttpClient\SymfonyInternalClient;
use App\Front\Application\View\TwigView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ViewRoomService implements ViewRoomServiceInterface
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

    public function handle(ViewRoomRequest $request): UseCasePayload
    {
        $houses = $this->symfonyInternalClient->sendRequest(
            Request::create('/api/houses/' . $request->getHouseId() . '/rooms/' . $request->getRoomId() . '/chores.json')
        );

        $page = new Response(
            $this->view->render(
                'room',
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

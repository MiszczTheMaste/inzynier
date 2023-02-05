<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewPage;

use App\Core\Application\Http\HttpCodes;
use App\Core\Application\UseCase\UseCasePayload;
use App\Front\Application\View\TwigView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 *
 */
final class ViewPageService implements ViewPageServiceInterface
{
    private TwigView $view;

    /**
     * @param TwigView $view
     */
    public function __construct(TwigView $view)
    {
        $this->view = $view;
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function handle(ViewPageRequest $request): UseCasePayload
    {
        $page = new Response(
            $this->view->render(
                $request->getPage()
            )
        );

        return new UseCasePayload(
            HttpCodes::STATUS_TEXT[HttpCodes::HTTP_CREATED],
            HttpCodes::HTTP_CREATED,
            ['page' => $page]
        );
    }
}

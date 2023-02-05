<?php

declare(strict_types=1);

namespace App\Front\Application\View;

use Exception;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 *
 */
final class TwigView
{
    /** @var Environment  */
    private Environment $twig;

    /**
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function render(string $name, array $context = []): string
    {
        try {
            return $this->twig->render($name . '.html.twig', $context);
        } catch (Exception $e) {
            dump($e);
            return $this->twig->render('base.html.twig', $context);
        }
    }
}

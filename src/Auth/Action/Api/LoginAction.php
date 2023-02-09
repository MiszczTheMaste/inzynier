<?php

declare(strict_types=1);

namespace App\Auth\Action\Api;

use App\Auth\Application\UseCase\Login\LoginRequest;
use App\Auth\Application\UseCase\Login\LoginServiceInterface;
use App\Auth\Domain\Exception\InvalidPasswordException;
use App\Auth\Domain\Exception\InvalidUsernameException;
use App\Core\Domain\Exception\DatabaseException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class LoginAction
{
    private LoginServiceInterface $service;

    /**
     * @param LoginServiceInterface $service
     */
    public function __construct(LoginServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        try {
            if ('json' === $request->get('format')) {
                $data = json_decode((string)$request->getContent(), true);
            } else {
                $data = [
                    'username' => $request->get('username'),
                    'password' => $request->get('password')
                ];
            }

            if (false === is_array($data)) {
                throw new Exception();
            }

            $response = $this->service->handle(new LoginRequest($data['username'], $data['password']));

            if ('json' === $request->get('format')) {
                return new JsonResponse(
                    $response->getMessage(),
                    $response->getCode()
                );
            }

            return new RedirectResponse('/');
        } catch (Exception) {
            if ('json' === $request->get('format')) {
                return new JsonResponse(
                    ['message' => 'Nie udało się zalogować sprawdź login lub hasło.'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $request->getSession()->getFlashBag()->add('error', 'Nie udało się zalogować sprawdź login lub hasło.');
            return new RedirectResponse($request->get('redirect_address') ?? '/');
        }
    }
}

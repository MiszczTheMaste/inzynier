<?php

declare(strict_types=1);

namespace App\Auth\Action\Api;

use App\Auth\Application\UseCase\Register\RegisterRequest;
use App\Auth\Application\UseCase\Register\RegisterServiceInterface;
use App\Auth\Domain\Exception\UserExistsException;
use App\Core\Domain\Exception\DatabaseException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class RegisterAction
{
    private RegisterServiceInterface $service;

    /**
     * @param RegisterServiceInterface $service
     */
    public function __construct(RegisterServiceInterface $service)
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

            $response = $this->service->handle(new RegisterRequest($data));

            if ('json' === $request->get('format')) {
                return new JsonResponse(
                    $response->getMessage(),
                    $response->getCode()
                );
            }

            $request->getSession()->getFlashBag()->add('info', 'Zarejestrowano.');
            return new RedirectResponse('/');
        } catch (UserExistsException) {
            if ('json' === $request->get('format')) {
                return new JsonResponse(
                    ['message' => 'Nazwa użytkownika jest zajęta.'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $request->getSession()->getFlashBag()->add('error', 'Nazwa użytkownika jest zajęta.');
            return new RedirectResponse($request->get('redirect_address') ?? '/');
        } catch (Exception) {
            if ('json' === $request->get('format')) {
                return new JsonResponse(
                    ['message' => 'Nie udało się zarejestrować.'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $request->getSession()->getFlashBag()->add('error', 'Nie udało się zarejestrować.');
            return new RedirectResponse($request->get('redirect_address') ?? '/');
        }
    }
}

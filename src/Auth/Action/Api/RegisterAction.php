<?php

declare(strict_types=1);

namespace App\Auth\Action\Api;

use App\Auth\Application\UseCase\Register\RegisterRequest;
use App\Auth\Application\UseCase\Register\RegisterServiceInterface;
use App\Core\Domain\Exception\DatabaseException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RegisterAction
{
    private RegisterServiceInterface $service;

    public function __construct(RegisterServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        try {
            if ('json' === $request->get('format')) {
                $data = json_decode((string) $request->getContent(), true);
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

            return new RedirectResponse('/');
        } catch (DatabaseException) {
            return new JsonResponse(
                ['message' => 'Error during saving user'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (Exception) {
            return new JsonResponse(
                ['message' => 'Unknown error has occurred'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

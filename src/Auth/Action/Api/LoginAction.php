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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LoginAction
{
    private LoginServiceInterface $service;

    public function __construct(LoginServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            return new JsonResponse(
                $this->service->handle(new LoginRequest($data['username'], $data['password'])),
                Response::HTTP_CREATED
            );
        } catch (DatabaseException $e ) {
            return new JsonResponse(
                ['message' => 'Error during connection.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }  catch (InvalidUsernameException $e) {
            return new JsonResponse(
                ['message' => 'Nie poprawny login'],
                Response::HTTP_BAD_REQUEST
            );
        } catch (InvalidPasswordException $e) {
            return new JsonResponse(
                ['message' => 'Niewłaściwe hasło'],
                Response::HTTP_BAD_REQUEST
            );
        } catch (Exception) {
            return new JsonResponse(
                ['message' => 'Unknown error has occurred'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
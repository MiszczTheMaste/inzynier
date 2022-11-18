<?php

declare(strict_types=1);

use App\Auth\Action\Api\LoginAction;
use App\Auth\Action\Api\RegisterAction;
use App\Auth\Application\UseCase\Login\LoginService;
use App\Auth\Application\UseCase\Login\LoginServiceInterface;
use App\Auth\Application\UseCase\Register\RegisterService;
use App\Auth\Application\UseCase\Register\RegisterServiceInterface;
use App\Auth\Domain\Repository\UserRepositoryInterface;
use App\Auth\Infrastructure\Repository\UserRepository;
use App\Core\Infrastructure\DBAL\DatabaseAbstractionLayerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\RequestStack;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

/**
 * @param ContainerConfigurator $configurator
 */
return static function (ContainerConfigurator $configurator) {
    $services = $configurator->services();
    $configurator->parameters()
        ->set('db_host', '127.0.0.1')
        ->set('db_port', '3306')
        ->set('db_name', 'app')
        ->set('db_user', 'App')
        ->set('db_pwd', 'app123');

    $services->set(RegisterAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(RegisterServiceInterface::class)
        ]);

    $services->set(LoginAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(LoginServiceInterface::class)
        ]);

    $services->set(LoginServiceInterface::class, LoginService::class)
        ->args([
            service(UserRepositoryInterface::class),
            service(RequestStack::class)
        ]);

    $services->set(RegisterServiceInterface::class, RegisterService::class)
        ->args([
            service(UserRepositoryInterface::class)
        ]);

    $services->set(UserRepositoryInterface::class, UserRepository::class)
        ->args([
            service(DatabaseAbstractionLayerInterface::class),
            service(EventDispatcherInterface::class)
        ]);

    $services->set(DatabaseAbstractionLayerInterface::class, \App\Core\Infrastructure\DBAL\PDO::class)
        ->args([
            '%db_host%',
            '%db_port%',
            '%db_name%',
            '%db_user%',
            '%db_pwd%',
        ]);
};

<?php

declare(strict_types=1);

use App\Auth\Action\Api\LoginAction;
use App\Auth\Action\Api\RegisterAction;
use App\Auth\Application\Query\GetCurrentlyLoggedInUserIdQueryInterface;
use App\Auth\Application\UseCase\Login\LoginService;
use App\Auth\Application\UseCase\Login\LoginServiceInterface;
use App\Auth\Application\UseCase\Register\RegisterService;
use App\Auth\Application\UseCase\Register\RegisterServiceInterface;
use App\Auth\Domain\Repository\UserRepositoryInterface;
use App\Auth\Infrastructure\Query\GetCurrentlyLoggedInUserIdSessionQuery;
use App\Auth\Infrastructure\Repository\UserRepository;
use App\Core\Infrastructure\DBAL\DatabaseAbstractionLayerInterface;
use App\Core\Infrastructure\HttpClient\SymfonyInternalClient;
use App\Front\Action\ViewAddUserAction;
use App\Front\Action\ViewCreateRoomAction;
use App\Front\Action\ViewHomepageAction;
use App\Front\Action\ViewHouseAction;
use App\Front\Action\ViewPageAction;
use App\Front\Action\ViewRoomAction;
use App\Front\Application\UseCase\ViewAddUser\ViewAddUserService;
use App\Front\Application\UseCase\ViewAddUser\ViewAddUserServiceInterface;
use App\Front\Application\UseCase\ViewCreateRoom\ViewCreateRoomService;
use App\Front\Application\UseCase\ViewCreateRoom\ViewCreateRoomServiceInterface;
use App\Front\Application\UseCase\ViewHomepage\ViewHomepageService;
use App\Front\Application\UseCase\ViewHomepage\ViewHomepageServiceInterface;
use App\Front\Application\UseCase\ViewHouse\ViewHouseService;
use App\Front\Application\UseCase\ViewHouse\ViewHouseServiceInterface;
use App\Front\Application\UseCase\ViewPage\ViewPageService;
use App\Front\Application\UseCase\ViewPage\ViewPageServiceInterface;
use App\Front\Application\UseCase\ViewRoom\ViewRoomService;
use App\Front\Application\UseCase\ViewRoom\ViewRoomServiceInterface;
use App\Front\Application\View\TwigView;
use App\House\Action\AddUserToHouse\AddUserToHouseAction;
use App\House\Action\CreateChore\CreateChoreAction;
use App\House\Action\CreateHouse\CreateHouseAction;
use App\House\Action\CreateRoom\CreateRoomAction;
use App\House\Action\GetChores\GetChoresAction;
use App\House\Action\GetHouse\GetHouseAction;
use App\House\Action\GetHousesForUser\GetHousesForUserAction;
use App\House\Application\Query\GetHousesForUserQueryInterface;
use App\House\Application\Query\GetRoomNameQueryInterface;
use App\House\Application\Query\GetUserIdQueryInterface;
use App\House\Application\Query\GetUsernameByIdQueryInterface;
use App\House\Application\UseCase\AddUserToHouse\AddUserToHouseService;
use App\House\Application\UseCase\AddUserToHouse\AddUserToHouseServiceInterface;
use App\House\Application\UseCase\CreateChore\CreateChoreService;
use App\House\Application\UseCase\CreateChore\CreateChoreServiceInterface;
use App\House\Application\UseCase\CreateHouse\CreateHouseService;
use App\House\Application\UseCase\CreateHouse\CreateHouseServiceInterface;
use App\House\Application\UseCase\CreateRoom\CreateRoomService;
use App\House\Application\UseCase\CreateRoom\CreateRoomServiceInterface;
use App\House\Application\UseCase\GetChores\GetChoresService;
use App\House\Application\UseCase\GetChores\GetChoresServiceInterface;
use App\House\Application\UseCase\GetChores\Query\GetChoresQueryInterface;
use App\House\Application\UseCase\GetHouse\GetHouseService;
use App\House\Application\UseCase\GetHouse\GetHouseServiceInterface;
use App\House\Application\UseCase\GetHouse\Query\GetHouseQueryInterface;
use App\House\Application\UseCase\GetHousesForUser\GetHousesForUserService;
use App\House\Application\UseCase\GetHousesForUser\GetHousesForUserServiceInterface;
use App\House\Domain\Repository\HouseRepositoryInterface;
use App\House\Infrastructure\Query\GetChores\GetChoresSqlQuery;
use App\House\Infrastructure\Query\GetHouse\GetHouseSqlQuery;
use App\House\Infrastructure\Query\GetHousesForUser\GetHousesForUserSqlQuery;
use App\House\Infrastructure\Query\GetRoomNameSqlQuery;
use App\House\Infrastructure\Query\GetUserIdSqlQuery;
use App\House\Infrastructure\Query\GetUsernameByIdQuery;
use App\House\Infrastructure\Repository\HouseEventRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

/**
 * @param ContainerConfigurator $configurator
 */
return static function (ContainerConfigurator $configurator) {
    $services = $configurator->services();

    /** CORE */
    $configurator->parameters()
        ->set('db_host', '127.0.0.1')
        ->set('db_port', '3306')
        ->set('db_name', 'app')
        ->set('db_user', 'App')
        ->set('db_pwd', 'app123');

    $services->set(DatabaseAbstractionLayerInterface::class, \App\Core\Infrastructure\DBAL\PDO::class)
        ->args([
            '%db_host%',
            '%db_port%',
            '%db_name%',
            '%db_user%',
            '%db_pwd%',
        ]);

    $services->set(ContainerControllerResolver::class)
        ->args([service('service_container')]);

    $services->set(SymfonyInternalClient::class)
        ->args([
            service('router.default'),
            service(ContainerControllerResolver::class)
        ]);

    /** FRONT */

    $services->set(ViewPageAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(ViewPageServiceInterface::class)
        ]);

    $services->set(ViewHomepageAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(ViewHomepageServiceInterface::class)
        ]);

    $services->set(ViewHouseAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(ViewHouseServiceInterface::class)
        ]);

    $services->set(ViewAddUserAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(ViewAddUserServiceInterface::class)
        ]);

    $services->set(ViewCreateRoomAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(ViewCreateRoomServiceInterface::class)
        ]);

    $services->set(ViewRoomAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(ViewRoomServiceInterface::class)
        ]);

    $services->set(ViewHomepageServiceInterface::class, ViewHomepageService::class)
        ->args([
            service(TwigView::class),
            service(SymfonyInternalClient::class),
            service(GetCurrentlyLoggedInUserIdQueryInterface::class),
        ]);

    $services->set(ViewPageServiceInterface::class, ViewPageService::class)
        ->args([
            service(TwigView::class)
        ]);

    $services->set(ViewAddUserServiceInterface::class, ViewAddUserService::class)
        ->args([
            service(TwigView::class),
            service(SymfonyInternalClient::class)
        ]);

    $services->set(ViewCreateRoomServiceInterface::class, ViewCreateRoomService::class)
        ->args([
            service(TwigView::class),
            service(SymfonyInternalClient::class)
        ]);

    $services->set(ViewHouseServiceInterface::class, ViewHouseService::class)
        ->args([
            service(TwigView::class),
            service(SymfonyInternalClient::class),
        ]);

    $services->set(ViewRoomServiceInterface::class, ViewRoomService::class)
        ->args([
            service(TwigView::class),
            service(SymfonyInternalClient::class),
        ]);

    $services->set(TwigView::class)
        ->args([
            service('twig')
        ]);

    /** AUTH */
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

    $services->set(HouseRepositoryInterface::class, HouseEventRepository::class)
        ->args([
            service(DatabaseAbstractionLayerInterface::class),
            service(EventDispatcherInterface::class)
        ]);

    $services->set(GetCurrentlyLoggedInUserIdQueryInterface::class, GetCurrentlyLoggedInUserIdSessionQuery::class)
        ->args([
            service(RequestStack::class)
        ]);

    $services->set(GetUsernameByIdQueryInterface::class, GetUsernameByIdQuery::class)
        ->args([
            service(DatabaseAbstractionLayerInterface::class)
        ]);


    $services->set(CreateHouseAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(CreateHouseServiceInterface::class)
        ]);

    $services->set(CreateHouseServiceInterface::class, CreateHouseService::class)
        ->args([
            service(HouseRepositoryInterface::class),
            service(GetCurrentlyLoggedInUserIdQueryInterface::class)
        ]);

    $services->set(CreateRoomAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(CreateRoomServiceInterface::class)
        ]);

    $services->set(CreateRoomServiceInterface::class, CreateRoomService::class)
        ->args([
            service(HouseRepositoryInterface::class)
        ]);

    $services->set(CreateChoreAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(CreateChoreServiceInterface::class)
        ]);

    $services->set(CreateChoreServiceInterface::class, CreateChoreService::class)
        ->args([
            service(HouseRepositoryInterface::class)
        ]);


    $services->set(GetHousesForUserAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(GetHousesForUserServiceInterface::class)
        ]);

    $services->set(GetHousesForUserServiceInterface::class, GetHousesForUserService::class)
        ->args([
            service(GetCurrentlyLoggedInUserIdQueryInterface::class),
            service(GetHousesForUserQueryInterface::class),
            service(GetUsernameByIdQueryInterface::class)
        ]);

    $services->set(GetHousesForUserQueryInterface::class, GetHousesForUserSqlQuery::class)
        ->args([
            service(DatabaseAbstractionLayerInterface::class),
        ]);


    $services->set(GetHouseAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(GetHouseServiceInterface::class)
        ]);

    $services->set(GetHouseServiceInterface::class, GetHouseService::class)
        ->args([
            service(GetHouseQueryInterface::class)
        ]);

    $services->set(GetHouseQueryInterface::class, GetHouseSqlQuery::class)
        ->args([
            service(DatabaseAbstractionLayerInterface::class),
        ]);


    $services->set(AddUserToHouseAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(AddUserToHouseServiceInterface::class)
        ]);

    $services->set(AddUserToHouseServiceInterface::class, AddUserToHouseService::class)
        ->args([
            service(HouseRepositoryInterface::class),
            service(GetUserIdQueryInterface::class)
        ]);

    $services->set(GetUserIdQueryInterface::class, GetUserIdSqlQuery::class)
        ->args([
            service(DatabaseAbstractionLayerInterface::class),
        ]);


    $services->set(GetChoresAction::class)
        ->tag('controller.service_arguments')
        ->args([
            service(GetChoresServiceInterface::class)
        ]);

    $services->set(GetChoresServiceInterface::class, GetChoresService::class)
        ->args([
            service(GetChoresQueryInterface::class),
            service(GetRoomNameQueryInterface::class)
        ]);

    $services->set(GetChoresQueryInterface::class, GetChoresSqlQuery::class)
        ->args([
            service(DatabaseAbstractionLayerInterface::class),
        ]);

    $services->set(GetRoomNameQueryInterface::class, GetRoomNameSqlQuery::class)
        ->args([
            service(DatabaseAbstractionLayerInterface::class),
        ]);
};

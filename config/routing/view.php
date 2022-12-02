<?php

use App\Front\Action\ViewAddChoreAction;
use App\Front\Action\ViewAddUserAction;
use App\Front\Action\ViewChoreAction;
use App\Front\Action\ViewCreateRoomAction;
use App\Front\Action\ViewHomepageAction;
use App\Front\Action\ViewHouseAction;
use App\Front\Action\ViewPageAction;
use App\Front\Action\ViewRoomAction;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    /**
     * View routes does not need to follow resource pattern
     */
    $routes->add('view.home', '/')
        ->controller(ViewHomepageAction::class)
        ->methods(['GET']);

    $routes->add('view.page', '/{page}')
        ->controller(ViewPageAction::class)
        ->methods(['GET']);

    $routes->add('view.house', '/houses/{house_id}')
        ->controller(ViewHouseAction::class)
        ->methods(['GET']);

    $routes->add('view.house.add-user', '/houses/{house_id}/add-user')
        ->controller(ViewAddUserAction::class)
        ->methods(['GET']);

    $routes->add('view.house.create-room', '/houses/{house_id}/create-room')
        ->controller(ViewCreateRoomAction::class)
        ->methods(['GET']);

    $routes->add('view.house.room', '/houses/{house_id}/rooms/{room_id}')
        ->controller(ViewRoomAction::class)
        ->methods(['GET']);

    $routes->add('view.house.room.add-chores', '/houses/{house_id}/rooms/{room_id}/create-chore')
        ->controller(ViewAddChoreAction::class)
        ->methods(['GET']);

    $routes->add('view.house.room.add-chores', '/houses/{house_id}/rooms/{room_id}/chore')
        ->controller(ViewAddChoreAction::class)
        ->methods(['GET']);

    $routes->add('view.house.room.add-chores', '/houses/{house_id}/rooms/{room_id}/chores/{chore_id}')
        ->controller(ViewChoreAction::class)
        ->methods(['GET']);
};
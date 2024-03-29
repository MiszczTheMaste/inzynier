<?php

use App\Auth\Action\Api\LoginAction;
use App\Auth\Action\Api\RegisterAction;
use App\House\Action\AddNewFulfilment\AddNewFulfilmentAction;
use App\House\Action\AddUserToHouse\AddUserToHouseAction;
use App\House\Action\CreateChore\CreateChoreAction;
use App\House\Action\CreateHouse\CreateHouseAction;
use App\House\Action\CreateRoom\CreateRoomAction;
use App\House\Action\EditFulfilment\EditFulfilmentAction;
use App\House\Action\GetChore\GetChoreAction;
use App\House\Action\GetRoom\GetRoomAction;
use App\House\Action\GetHouse\GetHouseAction;
use App\House\Action\GetHousesForUser\GetHousesForUserAction;
use App\House\Action\GetUsersInHouse\GetUsersInHouseAction;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('post.api.user', '/api/register.{format}')
        ->controller(RegisterAction::class)
        ->methods(['POST']);

    $routes->add('post.api.login', '/api/login.{format}')
        ->controller(LoginAction::class)
        ->methods(['POST']);

    $routes->add('post.api.house', '/api/houses.{format}')
        ->controller(CreateHouseAction::class)
        ->methods(['POST']);

    $routes->add('get.api.houses', '/api/houses.{format}')
        ->controller(GetHousesForUserAction::class)
        ->methods(['GET']);

    $routes->add('get.api.house', '/api/houses/{house_id}.{format}')
        ->controller(GetHouseAction::class)
        ->methods(['GET']);

    $routes->add('get.api.house.users', '/api/houses/{house_id}/users.{format}')
        ->controller(GetUsersInHouseAction::class)
        ->methods(['GET']);

    $routes->add('post.api.house.user', '/api/houses/{house_id}/users.{format}')
        ->controller(AddUserToHouseAction::class)
        ->methods(['POST']);

    $routes->add('post.api.house.room', '/api/houses/{house_id}/rooms.{format}')
        ->controller(CreateRoomAction::class)
        ->methods(['POST']);

    $routes->add('get.api.house.room', '/api/houses/{house_id}/rooms/{room_id}.{format}')
        ->controller(GetRoomAction::class)
        ->methods(['GET']);

    $routes->add('post.api.house.room.chore', '/api/houses/{house_id}/rooms/{room_id}/chores.{format}')
        ->controller(CreateChoreAction::class)
        ->methods(['POST']);

    $routes->add('get.api.house.room.chore', '/api/houses/{house_id}/rooms/{room_id}/chores/{chore_id}.{format}')
        ->controller(GetChoreAction::class)
        ->methods(['GET']);

    $routes->add('post.api.house.room.chore.fulfilment', '/api/houses/{house_id}/rooms/{room_id}/chores/{chore_id}/fulfilments/{fulfilment_id}.{format}')
        ->controller(AddNewFulfilmentAction::class)
        ->methods(['POST']);

    $routes->add('post.api.house.room.chore.fulfilment.rate', '/api/houses/{house_id}/rooms/{room_id}/chores/{chore_id}/fulfilments/{fulfilment_id}/rate.{format}')
        ->controller(EditFulfilmentAction::class)
        ->methods(['POST']);
};
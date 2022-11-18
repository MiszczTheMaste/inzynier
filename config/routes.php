<?php

use App\Auth\Action\Api\LoginAction;
use App\Auth\Action\Api\RegisterAction;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('post.user', '/api/register.json')
        ->controller(RegisterAction::class)
        ->methods(['POST']);

    $routes->add('post.login', '/api/login.json')
        ->controller(LoginAction::class)
        ->methods(['POST']);
};
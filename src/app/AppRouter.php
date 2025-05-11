<?php
namespace App;

use Soboutils\ExactAccessorMethodTrait;
use Soboutils\Path;
use Soboutils\SoboSingletonTrait;
use Soboutils\PropertyNotFoundException;
use Sobo_PhpRouter\Router;

class AppRouter
{
    use SoboSingletonTrait;


    public function parseRoutesList($routes_list) {
        $router = Router::getInstance();

        $router->setAllowedRouteEnds([Router::ROUTE_END_CALLBACK]);
        $router->setAfterCallbackCallable(function () {});
        
        foreach ($routes_list as $route) {
            $func = strtolower($route['method']);
            call_user_func_array([$router, $func], [
                $route['route'], function () use ($route) {
                    AppKernel::instance()->showFuncPage($route['view']);
                }]
            );
        }
        
    }
}

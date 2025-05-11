<?php

namespace App\Config;

class Routes {
    protected static $routes_list = [
        ['route' => '/', 'method' => 'GET', 'view' => 'App\Views\home_page'],
        ['route' => '/about-us', 'method' => 'GET', 'view' => 'App\Views\about_us'],
        ['route' => '/help', 'method' => 'GET', 'view' => 'App\Views\help'],
        ['route' => '/contact-us', 'method' => 'GET', 'view' => 'App\Views\contact_us'],
        ['route' => '/privacy-policy', 'method' => 'GET', 'view' => 'App\Views\privacy_policy'],
        ['route' => '/log-in', 'method' => 'GET', 'view' => 'App\Views\log_in'],
        ['route' => '/log-out', 'method' => 'GET', 'view' => 'App\Views\log_out'],
    ];

    public static function getRoutesList() {
        return self::$routes_list;
    }    
}

<?php

namespace App\Config;

class Routes {
    protected static $routesList = [
        ['route' => '/', 'method' => 'GET', 'view' => 'App\Views\home_page'],
        ['route' => '/about-us', 'method' => 'GET', 'view' => 'App\Views\about_us'],
        ['route' => '/help', 'method' => 'GET', 'view' => 'App\Views\help'],
        ['route' => '/contact-us', 'method' => 'GET', 'view' => 'App\Views\contact_us'],
        ['route' => '/privacy-policy', 'method' => 'GET', 'view' => 'App\Views\privacy_policy'],
        ['route' => '/log-in', 'method' => 'GET', 'view' => 'App\Views\log_in'],
        ['route' => '/log-out', 'method' => 'GET', 'view' => 'App\Views\log_out'],
        
        // API
        // ['route' => '/api/v1/admin/user/', 'method' => 'GET', 'view' => ],
        // ['route' => '/api', 'method' => 'GET', 'view' => 'App\Views\help'],
        ['route' => '/api/v1/admin/user', 'method' => 'GET', 'view' => ['App\Views\Api\AdminUserApi', 'getUserList']],
        ['route' => '/api/v1/admin/user', 'method' => 'GET', 'view' => ['App\Views\Api\AdminUserApi', 'getUserList']],
        ['route' => '/api/v1/admin/user/id/$id', 'method' => 'GET', 'view' => ['App\Views\Api\AdminUserApi', 'getUser']],
        ['route' => '/api/v1/admin/user/id/$id', 'method' => 'PUT', 'view' => ['App\Views\Api\AdminUserApi', 'updateUser']],
        ['route' => '/api/v1/admin/user/id/$id', 'method' => 'DELETE', 'view' => ['App\Views\Api\AdminUserApi', 'deleteUser']],
        ['route' => '/api/v1/admin/user/create', 'method' => 'POST', 'view' => ['App\Views\Api\AdminUserApi', 'createUser']],
        
        ['route' => '/api/v1/user/login', 'method' => 'POST', 'view' => 'App\Views\Api\user_login'],

    ];

    public static function getRoutesList() {
        return self::$routesList;
    }    
}

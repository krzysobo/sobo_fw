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
        ['route' => '/api/v1/admin/user/id/$id', 'method' => 'GET', 'view' => ['App\Views\Api\AdminUserApi', 'getUser']],
        ['route' => '/api/v1/admin/user/id/$id', 'method' => 'PUT', 'view' => ['App\Views\Api\AdminUserApi', 'updateUser']],
        ['route' => '/api/v1/admin/user/id/$id', 'method' => 'DELETE', 'view' => ['App\Views\Api\AdminUserApi', 'deleteUser']],
        ['route' => '/api/v1/admin/user/create', 'method' => 'POST', 'view' => ['App\Views\Api\AdminUserApi', 'createUser']],

        // private _api_prefix = 'http://localhost:3000/api/v1/';
        // private _api_url_admin_user_get = this._api_prefix + "admin/user/id/{id}/";
        // private _api_url_admin_user_update = this._api_prefix + "admin/user/id/{id}/";
        // private _api_url_admin_user_delete = this._api_prefix + "admin/user/id/{id}/";
        // private _api_url_admin_user_create = this._api_prefix + "admin/user/create/";
        // private _api_url_admin_user_list = this._api_prefix + "admin/user/";        
    ];

    public static function getRoutesList() {
        return self::$routesList;
    }    
}

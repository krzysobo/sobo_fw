<?php
namespace App\Db;

/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

use Soboutils\SoboSingletonTrait;

class UserHelper
{
    use SoboSingletonTrait;

    const USER_STATUS_NEW      = 10;
    const USER_STATUS_ACCEPTED = 20;

    public static function getUserStatus($is_active)
    {
        return $is_active ? self::USER_STATUS_ACCEPTED : self::USER_STATUS_NEW;
    }
}

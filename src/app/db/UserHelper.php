<?php
namespace App\Db;

/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

use Soboutils\SoboSingletonTrait;
use Sobo_fw\Utils\Db\DbHelper;

class UserHelper
{
    use SoboSingletonTrait;

    public const USER_STATUS_NEW      = 10;
    public const USER_STATUS_ACCEPTED = 20;

    public static function makeDjangoCompatibleAuthUserToken()
    {
        $token_len_bytes = 20;
        $token           = random_bytes($token_len_bytes);
        return bin2hex($token);
    }


    public static function getUserStatus($is_active)
    {
        return $is_active ? self::USER_STATUS_ACCEPTED : self::USER_STATUS_NEW;
    }

    public function storeDjangoCompatibleUserToken($user_id, $token, $token_db_table_name, $medoo_conn)
    {
        $data_out = [
            'key'     => $token,
            'user_id' => $user_id,
            'created' => DbHelper::currentDateStrForDb(),
        ];

        $medoo_conn->insert($token_db_table_name, $data_out);
    }

    public function getDjangoCompatibleUserToken($token, $token_db_table_name, $medoo_conn)
    {
        $fields = ['key', 'created', 'user_id'];

        $token = $medoo_conn->get('authtoken_token', $fields, ['key' => $token]);

        return $token;
    }

    public function checkDjangoCompatibleUserToken($token, $token_db_table_name, $medoo_conn)
    {
        $res = $this->getDjangoCompatibleUserToken($token, $token_db_table_name, $medoo_conn);

        return $res ? true : false;
    }

    public function deleteDjangoCompatibleUserToken($token, $user_id, $token_db_table_name, $medoo_conn)
    {

        $token = $medoo_conn->delete('authtoken_token', ['key' => $token, 'user_id' => $user_id]);

        return $token;
    }

}

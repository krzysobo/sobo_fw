<?php
namespace App\Db;

/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

use Medoo\Medoo;
use Soboutils\SoboSingletonTrait;
use Sobo_fw\Utils\Db\DbConfigContainer;
use Sobo_fw\Utils\Db\IDbConnection;

use \PDO;


class DbHelper
{
    use SoboSingletonTrait;

    /**
     * gets the connection
     * @param mixed $db_name - must match the db handle from a config
     * @return void
     */
    public function getConnectionForDbConfig($dbConnectionClassName, DbConfigContainer $db_config): IDbConnection
    {
        $db_conn = $dbConnectionClassName::makeConnection($db_config);
        return $db_conn;
    }
}

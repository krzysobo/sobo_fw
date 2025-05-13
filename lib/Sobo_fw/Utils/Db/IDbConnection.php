<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\Db;

interface IDbConnection
{
    // protected function __construct(DbConfigContainer $db_config);

    public static function makeConnection(DbConfigContainer $db_config): IDbConnection;

    public function getConnection();
}


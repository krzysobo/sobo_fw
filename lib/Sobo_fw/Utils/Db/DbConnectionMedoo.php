<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\Db;
use Sobo_fw\Utils\Db\IDbConnection;
use Medoo\Medoo;
use PDO;

class DbConnectionMedoo implements IDbConnection
{
    private DbConfigContainer $dbConfig;
    private Medoo | null $medooInstance = null;

    protected function __construct(DbConfigContainer $db_config)
    {
        $this->dbConfig = $db_config;
    }

    public static function makeConnection(DbConfigContainer $db_config): IDbConnection
    {
        return new DbConnectionMedoo($db_config);
    }

    public function getConnection()
    {
        if (! isset($this->medooInstance) || ($this->medooInstance === null)) {
            $this->medooInstance = new Medoo([
                // [required]
                'type'      => $this->dbConfig->getDbType(),
                'host'      => $this->dbConfig->getDbHost(),
                'database'  => $this->dbConfig->getDbName(),
                'username'  => $this->dbConfig->getDbUser(),
                'password'  => $this->dbConfig->getDbPass(),

                // [optional]
                'port'      => $this->dbConfig->getDbPort(),
                'charset'   => $this->dbConfig->getCharset(),
                'collation' => $this->dbConfig->getCollation(),

                // [optional] The table prefix. All table names will be prefixed as PREFIX_table.
                // 'prefix' => 'PREFIX_',
                'prefix'    => $this->dbConfig->getTablePrefix(),

                // [optional] To enable logging. It is disabled by default for better performance.
                'logging'   => true,

                // [optional]
                // Error mode
                // Error handling strategies when the error has occurred.
                // PDO::ERRMODE_SILENT (default) | PDO::ERRMODE_WARNING | PDO::ERRMODE_EXCEPTION
                // Read more from https://www.php.net/manual/en/pdo.error-handling.php.
                'error'     => PDO::ERRMODE_SILENT,

                // [optional]
                // The driver_option for connection.
                // Read more from http://www.php.net/manual/en/pdo.setattribute.php.
                'option'    => [
                    PDO::ATTR_CASE => PDO::CASE_NATURAL,
                ],

                // [optional] Medoo will execute those commands after the database is connected.
                'command'   => [
                    'SET SQL_MODE=ANSI_QUOTES',
                ],
            ]);

        }

        return $this->medooInstance;
    }
}


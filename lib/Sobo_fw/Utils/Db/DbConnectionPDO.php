<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\Db;
use Sobo_fw\Utils\Db\IDbConnection;
use PDO;

class DbConnectionPDO implements IDbConnection
{
    private DbConfigContainer $dbConfig;
    private PDO|null $pdoInstance = null;

    protected function __construct(DbConfigContainer $db_config)
    {
        $this->dbConfig = $db_config;
    }

    public static function makeConnection(DbConfigContainer $db_config): IDbConnection
    {
        return new DbConnectionPDO($db_config);
    }

    public function getConnection()
    {
        if (! isset($this->pdoInstance) || ($this->pdoInstance === null)) {

            $dsn = "mysql:host={$this->dbConfig->getDbHost()};dbname={$this->dbConfig->getDbName()};charset={$this->dbConfig->getCharset()}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->pdoInstance = new PDO($dsn, $this->dbConfig->getDbUser(), $this->dbConfig->getDbPass(), $options);
        }

        return $this->pdoInstance;
    }
}

<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\Db;

use Soboutils\SoboSingletonTrait;
use Sobo_fw\Utils\Db\IDbConnection;
use Sobo_fw\Utils\Db\DbConnectionNotFoundException;


/**
 * a singleton class for storing the IDbConnection instances,
 * allowing to get one by handle or all of them.
 */
class DbConnectionStore
{
    use SoboSingletonTrait;

    protected $dbConnections = [];

    /**
     * gets all DbConnections
     * @return IDbConnection[]
     */
    public function getAllDbConnections()
    {
        return $this->dbConnections;
    }

    public function addDbConnection(string $dbHandle, IDbConnection $dbConnection) {
        $this->dbConnections[$dbHandle] = $dbConnection;
    }

    /**
     * gets a DbConnection by DB Handle. Throws exception if not found
     * @param mixed $db_handle
     * @throws DbConnectionNotFoundException
     * @return IDbConnection
     */
    public function getDbConnectionByHandle($db_handle)
    {
        if (! isset($this->dbConnections[$db_handle])) {
            throw new DbConnectionNotFoundException();
        }

        return $this->dbConnections[$db_handle];
    }
    
}

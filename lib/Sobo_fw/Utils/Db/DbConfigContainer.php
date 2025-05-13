<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\Db;

use Soboutils\ExactAccessorMethodTrait;

/**
 *  a data class (container) for storing a Db config. Automatic exact accessors used.
 */
class DbConfigContainer
{
    use ExactAccessorMethodTrait;

    protected string $dbName    = "";
    protected string $dbType    = "";
    protected string $dbHost    = "";
    protected string $dbPort    = "";
    protected string $dbUser    = "";
    protected string $dbPass    = "";
    protected string $charset   = "";
    protected string $collation = "";
    protected string $tablePrefix = "";


    public function __construct(string $dbName = "",
        string $dbType = "",
        string $dbHost = "",
        string $dbPort = "",
        string $dbUser = "",
        string $dbPass = "",
        string $charset = "utf8mb4",
        string $collation = "utf8mb4_general_ci",
        string $tablePrefix = ""

    ) {
        $this->dbName  = $dbName;
        $this->dbType  = $dbType;
        $this->dbHost  = $dbHost;
        $this->dbPort  = $dbPort;
        $this->dbUser  = $dbUser;
        $this->dbPass  = $dbPass;
        $this->charset = $charset;
        $this->collation = $collation;
        $this->tablePrefix = $tablePrefix;
    }

}

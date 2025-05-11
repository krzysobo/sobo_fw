<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\Config;

use Soboutils\ExactAccessorMethodTrait;

/**
 *  a data class (container) for storing a Db config. Automatic exact accessors used.
 */
class DbConfigContainer
{
    use ExactAccessorMethodTrait;

    protected string $dbName = "";
    protected string $dbType = "";
    protected string $dbHost = "";
    protected string $dbPort = "";
    protected string $dbUser = "";
    protected string $dbPass = "";

    public function __construct(string $dbName = "", 
            string $dbType = "", 
            string $dbHost = "", 
            string $dbPort = "", 
            string $dbUser = "", 
            string $dbPass = "")
    {
        $this->dbName = $dbName;
        $this->dbType = $dbType;
        $this->dbHost = $dbHost;
        $this->dbPort = $dbPort;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
    }

}

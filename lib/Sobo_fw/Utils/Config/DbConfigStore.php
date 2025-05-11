<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\Config;

use Soboutils\SoboSingletonTrait;
use Sobo_fw\Utils\Config\DbConfigContainer;
use Sobo_fw\Utils\Config\DbConfigNotFoundException;


/**
 * a singleton class for storing the DBConfigContainer objects by handle, 
 * allowing to get one by handle or all of them.
 */
class DbConfigStore
{
    use SoboSingletonTrait;

    protected $dbConfigs = [];

    // configs - yaml, ini, ENV

    /**
     * gets all DbConfigs
     * @return DbConfigContainer[]
     */
    public function getAllDbConfigs()
    {
        return $this->dbConfigs;
    }

    /**
     * gets a DbConfig by DB Handle. Throws exception if not found
     * @param mixed $db_handle
     * @throws DbConfigNotFoundException
     * @return DbConfigContainer
     */
    public function getDbConfigByHandle($db_handle)
    {
        if (! isset($this->dbConfigs[$db_handle])) {
            throw new DbConfigNotFoundException();
        }

        return $this->dbConfigs[$db_handle];
    }
    
}

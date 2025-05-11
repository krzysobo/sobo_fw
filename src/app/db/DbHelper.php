<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

use Sobo_fw\Utils\Config\DbConfigContainer;
use Soboutils\SoboSingletonTrait;

class DbHelper {
    use SoboSingletonTrait;

    /**
     * gets the connection
     * @param mixed $db_name - must match the db handle from a config
     * @return void
     */
    public function getConnectionForDbConfig(DbConfigContainer $db_config) {
        
    }
}
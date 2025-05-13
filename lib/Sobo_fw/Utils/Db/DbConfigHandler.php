<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\Db;

use Soboutils\FileNotFoundException;
use Soboutils\SoboSingletonTrait;
use Sobo_fw\Utils\Db\DbConfigContainer;
use Sobo_fw\Utils\Db\DbConfigNotFoundException;
use Sobo_fw\Utils\Db\IncorrectDbConfigException;


class DbConfigHandler
{
    use SoboSingletonTrait;

    // configs - yaml, ini, ENV

    public function getDbConfigFromEnv(array $env_mapping)
    {
        $db_config = new DbConfigContainer(
            $_ENV[$env_mapping['db_name']],
            $_ENV[$env_mapping['db_type']],
            $_ENV[$env_mapping['db_host']],
            $_ENV[$env_mapping['db_port']],
            $_ENV[$env_mapping['db_user']],
            $_ENV[$env_mapping['db_pass']]);
        return $db_config;
    }

    public function getDbConfigFromParamArray(array $db_params)
    {
        $db_config = new DbConfigContainer(
            $db_params['db_name'],
            $db_params['db_type'],
            $db_params['db_host'],
            $db_params['db_port'],
            $db_params['db_user'],
            $db_params['db_pass']);
        return $db_config;
    }

    /**
     * Reads the config by parsing an INI file
     * @param mixed $db_handle
     * @param mixed $env_mapping
     * @return void
     */
    public function getDbConfigFromIni($file_path, $ini_section): DbConfigContainer
    {
        // checks whether the file exists
        $filename = basename($file_path);
        if (! file_exists($file_path)) {
            throw new FileNotFoundException("INI file $filename not found");
        }

        // loads an ini file with parse_ini_file and checks its integrity
        $res = parse_ini_file($file_path, true);
        if (! isset($res) || (empty($res)) || (! isset($res[$ini_section])) || (empty($res[$ini_section]))) {
            throw new IncorrectDbConfigException("Incorrect DB config data in the INI file $filename (section [$ini_section])");
        }

        $db_config = new DbConfigContainer(
            $res[$ini_section]['db_name'],
            $res[$ini_section]['db_type'],
            $res[$ini_section]['db_host'],
            $res[$ini_section]['db_port'],
            $res[$ini_section]['db_user'],
            $res[$ini_section]['db_pass']);
        return $db_config;
    }

    /**
     * TODO. Reads the config by parsing a Yaml file.
     * @param mixed $db_handle
     * @param mixed $env_mapping
     * @return void
     */
    public function getDbConfigFromYaml($db_handle, $env_mapping)
    {

    }

}

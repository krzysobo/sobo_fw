<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\App;

use Sobo_fw\Utils\Db\DbConnectionStore;
use Soboutils\ExactAccessorMethodTrait;
use Soboutils\Path;
use Soboutils\SoboSingletonTrait;
use Soboutils\PropertyNotFoundException;

class AppMain
{
    use SoboSingletonTrait;
    use ExactAccessorMethodTrait {
        __call as __callAccessorTrait;
    }

    /**
     * public path - the path where your index.php is present.
     * It may be a subdirectory in your project, eg. ./pub or ./public, but it
     * may be the top directory as well, if your project has index.php in its center.
     * @var
     */
    protected $publicPath;

    /**
     * project root - the TOP directory of your project.
     * @var
     */
    protected $projectRootPath;

    /**
     * app directory, usually src/app. It's best to keep it relative towards project root, but usually you don't need to use it,
     * since it's mostly for classes and they are auto-loaded thanks to composer (remember about composer update autoload though :))
     * The only reason to have appPath set is that it usually contains "templates" and config
     * @var
     */
    protected $appPath;

    /**
     * path for application configuration files - usually located in src/app/config. Remember, that even if you are using
     * environment-wide configuration (.env files), which is usually very good, there should be some PHP mechanism to read those
     * settings and make them either defined constants, or variables/class properties.
     * @var
     */
    protected $configPath;

    /**
     * path for templates. If you're using multiple templating systems, it's a good idea to create directories for
     * each system, eg "sobotemplate", "smarty", "twig" etc
     * @var
     */
    protected $templatePath;
   
    protected $defaultDbConnectionHandle;

    function __call($funcname, $args)
    {
        $this_class = get_class($this);

        if ((str_starts_with($funcname, 'expand')) && (str_ends_with($funcname, 'Path'))) {
            $property = lcfirst(substr($funcname, 6));
            if (strlen($funcname) < 11) {
                throw new \BadMethodCallException("expander name must contain a name of a property finished with 'Path' and existing in its class.");
            }

            if (! property_exists($this, $property)) {
                throw new PropertyNotFoundException("Property $property doesn't exist on $this_class.");
            }

            return Path::joinPaths($this->$property, $args);

            // echo "<br />path expand FUNCTION $funcname PROPERTY: $property<br/>";
        } else {
            return $this->__callAccessorTrait($funcname, $args);
        }
    }

}

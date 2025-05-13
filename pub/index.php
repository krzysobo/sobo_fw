<?php

use App\Db\DbHelper;
use Sobo_fw\Utils\App\AppMain;
use Sobo_fw\Utils\App\AppRouter;
use App\Config\Routes;
use Sobo_fw\Utils\Db\DbConfigHandler;
use Sobo_fw\Utils\Db\DbConnectionStore;
use Soboutils\Path;

use App\Views\Api\AdminUserApi;

error_reporting(E_ALL);
ini_set("display_errors", "1");

$loader = require __DIR__ . '/../vendor/autoload.php';

// ============================== AUTOLOADER INFO =================================
// we've added our PSR-4 paths to composer.json. Otherwise we can include them here, eg.
// $loader->addPsr4('App\\', __DIR__.'/../src/app'); // we did it in composer.json
// of course, mere require_once "{{path}}" would also work.
// for function-based views, we MUST either add require/include for the files
// containing them HERE OR add them
//  to composer.json -> autoload -> "files": [.....] (paths only).
//      $loader->add DOES NOT WORK ON PATHS FOR FUNCTION THINGS.
// require_once __DIR__ . "/../src/app/views/sobotemplate_function_views_sf_response.php";
require_once __DIR__ . "/../src/app/views/sobotemplate_function_views.php";
// $loader->add('App\\Views\\Test\\Test', __DIR__.'/../src/app/views/Test.php');
// ============================== /AUTOLOADER INFO ================================

// ========= application BOOTSTRAPPING ==========
$pub_dir    = __DIR__;
$root_dir   = realpath(Path::joinPaths($pub_dir, '..'));
$app_dir    = realpath(Path::joinPaths($root_dir, 'src/app'));
$tpl_dir    = realpath(Path::joinPaths($app_dir, 'templates'));
$config_dir = realpath(Path::joinPaths($app_dir, 'config'));

$app = AppMain::instance();
$app->setPublicPath($pub_dir);
$app->setProjectRootPath($root_dir);
$app->setAppPath($app_dir);
$app->setTemplatePath($tpl_dir);
$app->setConfigPath($config_dir);


$db_config = DbConfigHandler::instance()->getDbConfigFromIni(Path::joinPaths($config_dir,'db.ini'), 'db_sobosite');
$conn_medoo = DbHelper::instance()->getConnectionForDbConfig('Sobo_fw\Utils\Db\DbConnectionMedoo', $db_config);
$conn_pdo = DbHelper::instance()->getConnectionForDbConfig('Sobo_fw\Utils\Db\DbConnectionPDO', $db_config);
DbConnectionStore::instance()->addDbConnection('medoo', $conn_medoo);
DbConnectionStore::instance()->addDbConnection('pdo', $conn_pdo);
$app->setDefaultDbConnectionHandle('medoo');

AppRouter::instance()->parseRoutesList(Routes::getRoutesList());
// ========= /application BOOTSTRAPPING ==========

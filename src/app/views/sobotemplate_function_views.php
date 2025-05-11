<?php
namespace App\Views;

use Sobo_fw\Utils\App\AppMain;
use App\Utils\LoginHelper;
use Soboutils\SoboTemplate;
use Symfony\Component\HttpFoundation\Response;

require_once "menu.php";

// You can use both class-based and function-based views and mix them as you wish.
// Class-based views are just COLLECTIONS.
// Sobo_Fw doesn't impose any "Controller" interfaces by design, but you may
// create some if you find them useful (I don't).

function get_state()
{
    $lh = LoginHelper::getInstance();

    $logged_in = (isset($_COOKIE['logged_in'])) ? $_COOKIE['logged_in'] : false;
    // echo "logged in".$logged_in;
    $lh->setLoggedIn($logged_in);
}


function home_page()
{
    $tpl = SoboTemplate::instance();

    // rendering template from a path provided as array, including the templates dir.
    $res = $tpl->renderPathArray(
        [AppMain::instance()->getTemplatePath(),
            'sobo_template', 'whole_page', 'home_page.phtml'],
        [
            "title"        => "Home page",
            "is_logged_in" => LoginHelper::getInstance()->isLoggedIn()]);
    echo $res;

    setcookie("visited_home_page_inside", time());
}

function about_us()
{
    // get_menu();

    // rendering template from a path expanded from templates dir using
    // the "expand..." magic from AppMain
    $res = SoboTemplate::instance()->render(
        AppMain::instance()->expandTemplatePath(
            'sobo_template', 'whole_page', 'about_us.phtml'),
        [
            "title"        => "About us",
            "is_logged_in" => LoginHelper::getInstance()->isLoggedIn()]);

    // here we RETURN Symfony Response object, created with out content
    $response = new Response(
        $res,
        Response::HTTP_OK,
        ['content-type' => 'text/html']
    );

    return $response;    
}

function contact_us()
{
    // get_menu();

    $tpl = SoboTemplate::instance();
    // rendering template from a path expanded from templates dir using
    // the "expand..." magic from AppMain
    $res = $tpl->render(
        AppMain::instance()->expandTemplatePath(
            'sobo_template', 'whole_page', 'contact_us.phtml'),
        [
            "title"        => "Contact us",
            "is_logged_in" => LoginHelper::getInstance()->isLoggedIn(),
        ]);

    // here we RETURN the result of rendering - this is the preferred way,
    // but of course you can also echo it directly in the view.
    return $res;
}

function help()
{
    // get_menu();
    // rendering template from a path expanded from templates dir using
    // the "expand..." magic from AppMain
    $res = SoboTemplate::instance()->render(
        AppMain::instance()->expandTemplatePath(
            'sobo_template', 'whole_page', 'help.phtml'),
        [
            "title"        => "Help!",
            "is_logged_in" => LoginHelper::getInstance()->isLoggedIn(),
        ]);

    return $res;
}

function privacy_policy()
{
    // get_menu();
    setcookie("visited_privacy_policy_inside", time());
    $res = SoboTemplate::instance()->render(
        AppMain::instance()->expandTemplatePath(
            'sobo_template', 'whole_page', 'privacy_policy.phtml'),
        [
            "title"        => "Privacy Policy & GDPR",
            "is_logged_in" => LoginHelper::getInstance()->isLoggedIn(),
        ]);

    return $res;
}

function log_in()
{
    $lh = LoginHelper::getInstance();
    $lh->logIn([]);

    setcookie("visited_log_in_inside", time());
    $lh = LoginHelper::getInstance();
    $lh->logIn([]);
    setcookie('logged_in', true);
    $_COOKIE['logged_in'] = true;

    return get_menu();
}

function log_out()
{
    setcookie('logged_in', false);
    $_COOKIE['logged_in'] = false;
    $lh                   = LoginHelper::getInstance();
    $lh->logOut();

    // echo "LOG OUT";
    return get_menu();
}

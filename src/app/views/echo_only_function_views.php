<?php
namespace App\Views;

use App\Utils\LoginHelper;
use Soboutils\SoboTemplate;

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

function display_menu($logged_in = false)
{
    // echo "cookie ";    print_r($_COOKIE);
    echo <<<MENU
    <ul>
        <li><a href="/">Home Page</a></li>
        <li><a href="/about-us">About Us</a></li>
        <li><a href="/help">Help</a></li>
        <li><a href="/contact-us">Contact Us</a></li>
        <li><a href="/privacy-policy">Privacy Policy</a></li>
    MENU;

    if ($logged_in) {
        echo '<li><a href="/log-out">Log Out</a></li>';
    } else {
        echo '<li><a href="/log-in">Log In</a></li>';
    }

    echo <<<MENU
    </ul>
    MENU;
}

function get_menu()
{
    get_state();
    $lh = LoginHelper::getInstance();
    display_menu($lh->isLoggedIn());
}

function home_page()
{
    get_menu();
    echo "HOME PAGE";
    setcookie("visited_home_page_inside", time());
}

function about_us()
{
    get_menu();
    echo "ABOUT US";
}

function contact_us()
{
    get_menu();
    echo "CONTACT US";
}

function help()
{
    get_menu();
    echo "HELP";
}

function privacy_policy()
{
    get_menu();
    echo "PRIVACY POLICY";
    setcookie("visited_privacy_policy_inside", time());
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
    
    get_menu();
}

function log_out()
{
    setcookie('logged_in', false);    
    $_COOKIE['logged_in'] = false;
    $lh = LoginHelper::getInstance();
    $lh->logOut();

    // echo "LOG OUT";
    get_menu();
}

class FunctionViewsInfo
{
    public function info()
    {
        echo "this is function views-located class";
    }
}

<?php
namespace App\Utils;

use Soboutils\SoboSingletonTrait;

class LoginHelper
{
    protected bool $isLoggedIn = false;

    use SoboSingletonTrait;

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    public function logIn($user_data)
    {
        $this->setLoggedIn(true);
    }

    public function logOut()
    {
        $this->setLoggedIn(false);
    }

    public function setLoggedIn($is_logged_in) {
        $this->isLoggedIn = $is_logged_in;
    }

}

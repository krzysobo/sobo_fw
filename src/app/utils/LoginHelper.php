<?php
namespace App\Utils;

use Soboutils\SoboSingletonTrait;

class LoginHelper
{
    protected bool $is_logged_in = false;

    use SoboSingletonTrait;

    public function isLoggedIn()
    {
        return $this->is_logged_in;
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
        $this->is_logged_in = $is_logged_in;
    }

}

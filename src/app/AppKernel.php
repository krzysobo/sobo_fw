<?php
namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Soboutils\ExactAccessorMethodTrait;
use Soboutils\Path;
use Soboutils\SoboSingletonTrait;
use Soboutils\PropertyNotFoundException;


class AppKernel
{
    use SoboSingletonTrait;

    public function getRequest() {
        $req = Request::createFromGlobals();
        return $req;    
    }

    public function showFuncPage($funcname)
    {
        if (! function_exists($funcname)) {
            throw new \BadFunctionCallException("Function $funcname doesn't exist");
        }
    
        $res = call_user_func($funcname, []);
        if (isset($res) && ($res !== null)) {
            if (is_string($res) && (strval($res) != "")) {
                echo $res;
                exit;
            }elseif ($res instanceof Response) {
                $res->send();
            }
        }
        exit;
    }
    
    


}

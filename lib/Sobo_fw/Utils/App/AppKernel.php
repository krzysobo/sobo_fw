<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\App;

use Soboutils\SoboSingletonTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppKernel
{
    use SoboSingletonTrait;

    public function getRequest()
    {
        $req = Request::createFromGlobals();
        return $req;
    }

    public function showFuncPage($funcname, $func_args)
    {
        if (is_array($funcname) && (count($funcname) == 2) &&
            is_string($funcname[0]) && class_exists($funcname[0])) {
            $obj      = new $funcname[0]();
            $callable = [$obj, $funcname[1]];
        } else {
            $callable = $funcname;
        }

        print_r($callable);

        if (! is_callable($callable)) {
            throw new \BadFunctionCallException("Router error - a callable for the route does not exist.");
        }

        $res = call_user_func_array($callable, $func_args);
        if (isset($res) && ($res !== null)) {
            if (is_string($res) && (strval($res) != "")) {
                echo $res;
                exit;
            } elseif ($res instanceof Response) {
                $res->send();
            }
        }

        exit;
    }

}

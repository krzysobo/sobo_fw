<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\Db;



/**
 *  a data class (container) for storing a Db config. Automatic exact accessors used.
 */
class DbHelper
{
    public static function currentDateStrForDb() {
        date_default_timezone_set('UTC');
        $dt         = new \DateTime();
        $dt_now_str = $dt->format('Y-m-d H:i:s.v O');
        return $dt_now_str;
    }
    
}

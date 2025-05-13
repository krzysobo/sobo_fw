<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils;

use ValueError;

class Path
{

    public static function joinPaths()
    {
        $paths     = func_get_args();
        $paths_out = [];
        // echo "\n<br />PATHS: "; print_r($paths);

        if (! isset($paths) || empty($paths)) {
            throw new ValueError("PATH IS EMPTY");
        }

        $cur_dir_separator     = DIRECTORY_SEPARATOR;
        $another_dir_separator = ($cur_dir_separator == '/') ? '\\' : '/';

        foreach ($paths as $i => $path) {
            // echo "\n<br />PATH: $path";
            if (isset($path) && ($path != "")) {
                if (strstr($path, $another_dir_separator)) {
                    $path = str_replace($another_dir_separator, $cur_dir_separator, $path);
                }

                $path_out    = ($i == 0) ? rtrim($path, $cur_dir_separator) : trim($path, $cur_dir_separator);
                $paths_out[] = $path_out;

            }
        }

        if (! isset($paths_out) || empty($paths_out)) {
            throw new ValueError("PATH IS EMPTY-2");
        }

        // echo_br("PATHS OUT: ".print_r($paths_out,true). " EMPTY? ".empty($paths_out));

        $res = implode($cur_dir_separator, $paths_out);
        // echo_br("JOIN PATH RES: $res");
        return $res;
    }

}

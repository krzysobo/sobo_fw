<?php

/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\Auth;
use Sobo_fw\Utils\Db\DbHelper;


class Password
{
    public static function makeDjangoCompatiblePasswordHash($password)
    {
        $no_iterations = 720000;

        $salt_len_bytes = 16;
        $hash_len_bytes = 32;
        $salt           = random_bytes($salt_len_bytes);

        $hash = hash_pbkdf2("sha256", $password, $salt, $no_iterations, $hash_len_bytes, true);

        $salt_b64 = base64_encode($salt);
        $hash_b64 = base64_encode($hash);

        $whole_pwd_hash = "pbkdf2_sha256\${$no_iterations}\${$salt_b64}\${$hash_b64}";
        return $whole_pwd_hash;
    }

    public static function checkPasswordDjangoCompatiblePasswordHash($password, $whole_pwd_hash)
    {
        list($header, $no_iterations_str, $salt_b64, $hash_b64) = explode("$", $whole_pwd_hash);

        if ($header != 'pbkdf2_sha256') {
            return false;
        }

        if (! is_numeric($no_iterations_str)) {
            return false;
        }

        $no_iterations = intval($no_iterations_str);

        $salt = base64_decode($salt_b64);
        $hash = base64_decode($hash_b64);

        $hash_len_bytes = 32;

        $hash_cmp = hash_pbkdf2("sha256", $password, $salt, $no_iterations, $hash_len_bytes, true);

        return hash_equals($hash_cmp, $hash);

    }
}

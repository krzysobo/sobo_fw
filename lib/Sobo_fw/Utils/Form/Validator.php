<?php
/**
 * @copyright 2025 Krzysztof Sobolewski <krzysztof.sobolewski@gmail.com>, https://github.com/krzysobo
 * @license MIT
 */

namespace Sobo_fw\Utils\Form;

use Sobo_fw\Utils\Db\DbConnectionStore;

class Validator
{
    public static function fieldExistsAndNotEmpty($field, $field_set)
    {
        return isset($field_set[$field]) && ($field_set[$field] !== null) && ($field_set[$field] != "");
    }
    public static function fieldExistsFilledOrEmpty($field, $field_set)
    {
        return isset($field_set[$field]);
    }

    public static function fieldExistsAndNumeric($field, $field_set)
    {
        return isset($field_set[$field]) && ($field_set[$field] !== null) && is_numeric($field_set[$field]);
    }

    public static function normalizeBoolValue($field, $field_set, $default_res = false)
    {
        $val = $field_set[$field];
        if (is_bool($val)) {
            return $val;
        } elseif (is_string($val) && (in_array(strtolower($val), ['true', 'false']))) {
            return strtolower($val) == 'true';
        } elseif (is_numeric($val) && in_array($val, [1, 0])) {
            return intval($val) == 1;
        }

        return $default_res;
    }

    public static function boolFieldExists($field, $field_set)
    {
        if (! isset($field_set[$field])) {
            return false;
        }

        $val = $field_set[$field];

        $res = ((is_bool($val)) ||
            (is_string($val) && (in_array(strtolower($val), ['true', 'false']))) ||
            (is_numeric($val) && in_array($val, [1, 0])));

        return $res;
    }

    public static function checkEmail($email_field, $field_set)
    {
        return self::fieldExistsAndNotEmpty($email_field, $field_set); // TODO - real validation of Email needed
    }

    public static function checkPassword($password_field, $field_set)
    {
        return self::fieldExistsAndNotEmpty($password_field, $field_set);
    }

    public static function isEmailUnique($email, $db_connection_handle, $db_table, $email_field)
    {
        $conn      = DbConnectionStore::instance()->getDbConnectionByHandle($db_connection_handle)->getConnection();
        $res       = $conn->get($db_table, ['id', 'email'], [$email_field => $email]);
        $is_unique = ! (isset($res) && is_array($res) && (! empty($res)));
        return $is_unique;
    }

    public static function anotherUserExistsWithThisEmail($email, $your_id, $db_connection_handle, $db_table, $email_field)
    {
        $conn      = DbConnectionStore::instance()->getDbConnectionByHandle($db_connection_handle)->getConnection();
        $res       = $conn->get($db_table, ['id', 'email'], [$email_field => $email, 'id[!]' => $your_id]);
        $is_unique = ! (isset($res) && is_array($res) && (! empty($res)));
        return $is_unique;
    }

}

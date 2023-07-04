<?php
/**
 * @package Common\Database
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.27
 * @file Register.php
 */
namespace Common\Database;

class Register
{
    protected  static $objects = array();
    static function set($alias, $object){
        self::$objects[$alias] = $object;
    }
    static function get($name){
        return isset(self::$objects[$name]) ? self::$objects[$name] : null;
    }
    static function _unset($alias){
        unset(self::$objects[$alias]);
    }

}
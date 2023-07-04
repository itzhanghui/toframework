<?php
/**
 * @package HuaLang.site.
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.11
 * @id Register.php
 */
namespace Common;

class Register
{
    protected  static $array = array();
    static function set($key, $value){
        self::$array[$key] = $value;
    }
    static function get($key){
        return isset(self::$array[$key]) ? self::$array[$key] : '';
    }
    static function _unset($key){
        unset(self::$array[$key]);
    }

}
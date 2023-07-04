<?php
/**
 * @package Common\TimeZone
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.29
 * @edit date 2022.03.30
 * @file TimeZone.php
 */
namespace Common\TimeZone;
class TimeZone
{
    private static $instance = null;
    private function __construct(){
    }
    public static function getInstance()
    {
        if(self::$instance)
        {
            return self::$instance;
        }
        else
        {
            self::$instance = new self();
            return self::$instance;
        }
    }
    public function set($time_zone){
        if(function_exists('date_default_timezone_set')) date_default_timezone_set($time_zone);
    }
}
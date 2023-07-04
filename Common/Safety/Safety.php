<?php
/**
 * @package Common\Safety
 * @copyright (c) HuaLang Technologies Co.,ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.27
 * @file Safety.php
 */
namespace Common\Safety;

class Safety
{
    private static $POST = array();
    private static $GET = array();
    private static $COOKIE = array();
    private static $REQUEST_URI;
    static function check()
    {
        if(isset($_REQUEST['GLOBALS'])) unset($_REQUEST['GLOBALS']);
        if(isset($_FILES['GLOBALS'])) unset($_FILES['GLOBALS']);
    }
    static function checkPOST()
    {
        if(is_array($_POST) && $_POST)
        {
            foreach($_POST as $k=>$v){
                if(substr($k, 0, 1) == '_') unset($_POST[$k]);
            }
            self::$POST = enhance_key(enhance_sql(enhance_add_slashes($_POST)));
            return true;
        }else
        {
            return false;
        }
    }
    static funCtion getPOST()
    {
        return self::$POST;
    }
    static function checkGET()
    {
        if(is_array($_GET) && $_GET){
            foreach($_GET as $k=>$v){
                if(substr($k, 0, 1) == '_') unset($_GET[$k]);
            }
            self::$GET = enhance_key(enhance_sql(enhance_add_slashes($_GET)));
            return true;
        }else
        {
            return false;
        }
    }
    static funCtion getGET()
    {
        return self::$GET;
    }
    static function checkCOOKIE()
    {
        if($_COOKIE) {
            self::$COOKIE =  enhance_key(enhance_sql($_COOKIE = enhance_add_slashes($_COOKIE)));
            return true;
        }else
        {
            return false;
        }
    }
    static funCtion getCOOKIE()
    {
        return self::$COOKIE;
    }
    static function checkREQUEST_URI()
    {
        if(!empty($_SERVER['REQUEST_URI']))
        {
            enhance_uri($_SERVER['REQUEST_URI']);
            return true;
        }else
        {
            return false;
        }
    }
    static funCtion getREQUEST_URI()
    {
        return self::$REQUEST_URI;
    }
}








<?php
/**
 * @package HuaLang.site.
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.02
 * @id Loader.php
 */
namespace Common;
class Loader
{
    public static $classMap = array();
    public static  function autoload_class($class){
        if(isset(self::$classMap[$class]) == true){
            return true;
        }else{
            $file = auto_str_replace(HL_ROOT.'/'.$class).'.php';
            if(is_file($file)){
                require($file);
                self::$classMap[$class] = $class;
                return true;
            }else{
                return false;
            }
        }

    }
}

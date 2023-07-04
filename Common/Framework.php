<?php
/*
 * @package Common
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.27
 * @edit date 2022.03.31
 * @id Framework.php
 * */
namespace Common;
use Common\Factory\Factory;
use Exception;
class Framework
{
    private $assign = array();

    public static function run(){
        //1. set timezone
        self::loadTimeZone();
        //2.auto load Route
        self::loadRoute();

    }
    public static function loadBanIP()
    {
        $BanIP = Factory::getInstance('Common\\Safety\\BanIP');
        //$BanIP
    }
    //load Route
    public static function loadRoute(){
        $route = Factory::getInstance('\\Common\\Route\\Route');
        $entry = $route->getEntry();
        $ctrl = $route->getCtrl();
        $action = $route->getAction();
        $entry_dir = HL_ROOT.'/'.ucfirst($entry);

        $file = $entry_dir.'/Controller/'.$ctrl.'/'.$ctrl.'.php';
        echo $file;
        if(is_file($file)){
            include($file);
            $ctrlClass = ucfirst($entry).'\\Controller\\'.$ctrl.'\\'.$ctrl;
            $controller = Factory::getInstance($ctrlClass);
            $controller->$action();
        }else{
            throw new Exception('Controller not found '.$ctrl);
        }
    }
    public static function loadTimeZone(){
        $config = Factory::getConfig();
        $time_zone = Factory::getInstance('\\Common\\TimeZone\\TimeZone');
        $time_zone->set($config['common']['time_zone']);
    }

}
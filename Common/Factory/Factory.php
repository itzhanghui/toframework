<?php
/**
 * @package Common\Database
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.03
 * @edit date 2022.03.30
 * @file Factory.php
 */
namespace Common\Factory;
use Common\Config;
use Common\Database\DatabaseProxy;
use Common\Database\Register;
use Common\Database\MySQLi;
use Common\Database\MySQL;
use Common\Database\PDO;
class Factory
{
    protected static $config;
    protected static $proxy;
    private static $instance = array();
    static function getDatabase($conn_type = 'MySQLi', $id = 'proxy'){
        if($id == 'proxy')
        {
            if(!self::$proxy){
                self::$proxy = new DatabaseProxy();
            }
            return self::$proxy;
        }
        $key = 'database_'.$id;
        $db = Register::get($key);

        if(!$db){
            $config = self::getConfig();
            if($id == 'slave'){
                $slaves = $config['database']['slave'];
                $db_conf = $slaves[array_rand($slaves)];
            }else{
                $db_conf = $config['database'][$id];
            }

            if(in_array($conn_type, array('MySQL','MySQLi', 'PDO')))
            {
                $db = $conn_type == 'MySQL' ? MySQL::getInstance() : ($conn_type == 'MySQLi' ? MySQLi::getInstance() : PDO::getInstance());
                $db->connect($db_conf['db_host'],$db_conf['db_user'],$db_conf['db_pass'],$db_conf['db_name'],$db_conf['db_charset']);
                Register::set($key,$db);
            }else
            {
                return $conn_type.' is not connected';
            }
        }
        return $db;
    }
    public static function getConfig($dir = 'configs'){
        if(self::$config){
            return self::$config;
        }else{
            self::$config = Config::getInstance(HL_ROOT.'/'.$dir);
            return self::$config;
        }
    }
    public static function getInstance($class)
    {
        if(self::$instance[$class])
        {
            return self::$instance[$class];
        }else
        {
            self::$instance[$class] = $class::getInstance();
            return self::$instance[$class];
        }

    }

}
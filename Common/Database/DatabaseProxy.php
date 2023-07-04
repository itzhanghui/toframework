<?php
/**
 * @package Common\Database
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.09
 * @edit date 2022.03.29
 * @file DatabaseProxy.php
 */
namespace Common\Database;
use Common\Factory\Factory;

class DatabaseProxy implements IDatabaseProxy
{
    protected $array = array();
    protected $databaseProxy;
    function query($sql){
        if(strtolower(substr($sql, 0,6)) == 'select')
        {
            //return Factory::getDatabase('MySQLi', 'slave')->query($sql);
            $this->databaseProxy = Factory::getDatabase('MySQLi', 'master');
            return $this->databaseProxy->query($sql);
        }
        else
        {
            //return Factory::getDatabase('MySQLi', 'master')->query($sql);
            $this->databaseProxy = Factory::getDatabase('MySQLi', 'master');
            return $this->databaseProxy->query($sql);
        }
    }
    function fetchArray($result)
    {
        return $this->databaseProxy->fetchArray($result);
    }

    function __set($key, $value)
    {
        $this->array[$key] = $value;
    }
    function __get($key)
    {
        return isset($this->array[$key]) ? $this->array[$key] : 'property:'.$key.' is not exist.' ;
    }
    function __call($func, $param){
        return 'function method:'.$func.' is not exist';
    }
    static function __callStatic($func, $param){
        return 'function static method:'.$func.' is not exist';
    }
    function __toString(){
        return 'An object of '.__CLASS__.' cannot be printed';
    }
    function __invoke(){
        return 'An object cannot be used as a function';
    }
}
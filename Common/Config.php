<?php
/**
 * @package Common
 * @copyright 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create data 2022.03.30
 * @edit data 2022.03.30
 * @file Config.php
 * */
namespace Common;
use ArrayAccess;
use Exception;
class Config implements ArrayAccess
{
    protected $path;
    protected $config = array();
    private static $instance = null;
    private function __construct($path)
    {
        $this->path = $path;
    }
    public static function getInstance($path)
    {
        if(self::$instance)
        {
            return self::$instance;
        }
        else
        {
            self::$instance = new self($path);
            return self::$instance;
        }
    }
    function offsetGet($offset)
    {
        if(empty($this->config[$offset]))
        {
                $config = require($this->path.'/'.$offset.'.php');
                $this->config[$offset] = $config;
        }
        return $this->config[$offset];
    }
    function offsetSet($offset, $value)
    {
       throw  new Exception("you cannot write the config file.");
    }
    function offsetExists($offset)
    {
        return isset($this->config[$offset]);
    }
    function offsetUnset($offset)
    {
        unset($this->config[$offset]);
    }
}
<?php
/**
 * @pakage App\Controller\Index
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.net
 * @author hui zhang
 * @create date 2022.03.29
 * @edit data 2022.03.30
 * @file Index.php
 */
namespace App\Controller\Index;
class Index
{
    private static $instance;
    public function __constructor(){
        echo 'Index constructor';
    }
    public static function getInstance()
    {
        if(self::$instance)
        {
            return self::$instance;
        }
        else
        {
            return self::$instance  = new self();
        }
    }
    public function Index(){
        echo 'Index function';
    }
}
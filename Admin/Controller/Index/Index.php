<?php
/**
 * @package Admin\Controller\Index
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.30
 * @edit date 2022.03.30
 * @file Index.php
 * */
namespace Admin\Controller\Index;
class Index
{
    private static $instance;
    private function __constructor()
    {
        echo 'Admin Constructor';
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
    public function Index()
    {
        echo 'Admin Index function';
    }
}
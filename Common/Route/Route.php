<?php
/**
 * @package Common\Route;
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.27
 * @edit date 2022.03.29
 * @file Route.php
 * */
namespace Common\Route;
use Common\Factory\Factory;

class Route
{
    private $entry;
    private $ctrl;
    private $action;
    private static $instance;
    private function __construct()
    {
        if($_SERVER['REQUEST_URI'])
        {
            $path = $_SERVER['REQUEST_URI'];
            $arr_path = explode('/',trim($path, '/'));
            $config = Factory::getConfig();
            if(isset($arr_path[0]) && in_array($arr_path[0],$config['common']['entry']))
            {
                //set entry file
                $this->entry = $arr_path[0];

                if(isset($arr_path[1]))
                {
                    $this->ctrl = ucfirst($arr_path[1]);
                    unset($arr_path[1]);
                }else
                {
                    $this->ctrl = 'Index';
                }

                if(isset($arr_path[2]))
                {
                    $this->action = $arr_path[2];
                    unset($arr_path[2]);
                }else
                {
                    $this->action = 'index';
                }
                unset($arr_path[0]);

                //convert url to get
                $count = count($arr_path) + 3;
                $i = 3;
                while ($i < $count)
                {
                    if(isset($arr_path[$i+1]))
                    {
                        $_GET[$arr_path[$i]] = $arr_path[$i+1];
                    }
                    $i = $i +2;
                }
                //print_r($_GET);
                //exit;
            }else
            {
                $this->ctrl = 'Index';
                $this->action = 'index';
            }

        }else
        {
            $this->ctrl = 'Index';
            $this->action = 'index';
        }

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
    public function getEntry()
    {
        return $this->entry;
    }
    public function getCtrl()
    {
        return $this->ctrl;
    }
    public function getAction()
    {
        return $this->action;
    }


}
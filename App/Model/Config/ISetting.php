<?php
/**
 * @package App\Controller\Model
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.27
 * @file ISetting.php
 */
namespace App\Model\Setting;
interface ISetting
{
    //get config file
    function get($config_mark);
    /*
     * @param $config_mark
     * @param $config  this is a array()
     * @description set a config
     * */
    function set($config_mark,$config = array());

}
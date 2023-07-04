<?php
/**
 * @package Common\Database
 * @copyright (c) 2020-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.03
 * @edit date 2022.03.27
 * @file IUserProxy.php
 */
namespace \Common\Database;
interface IUserProxy
{
    function getUserName($id);
    function setUserName($id, $name);
}
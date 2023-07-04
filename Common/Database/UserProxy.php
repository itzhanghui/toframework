<?php
/**
 * @package Common\Database
 * @copyright(c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.03
 * @edit date 2022.03.27
 * @file UserProxy.php
 */
namespace \Common\Database;
class UserProxy implements IUserProxy
{
    function getUserName($id)
    {
        $db = Factory::getDatabase('slave');
        $db->query("select ");
    }
    function setUserName($id, $name)
    {
        $db = Factory::getDatabase('master');
        $db->query("update");

    }
}
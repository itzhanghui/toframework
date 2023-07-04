<?php
/**
 * @package Common\Database
 * @copyright(c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.03
 * @edit date 2022.03.27
 * @file IDatabase.php
 */
namespace Common\Database;
interface IDatabase
{
    function connect($db_host, $db_user, $db_pass, $db_name, $db_charset);
    function query($sql);
    function getInsertId();
    function getQueryNum();
    function fetchArray($result, $result_type = MYSQL_ASSOC);
    function count($tb, $condition = '');
    function affectedRows();
    function numRows($query);
    function numFields($query);
    function getLinked();
    function setTbPre($tb_pre);
    function getTbPre();
    function message($msg, $sql = '');
    function errNo();
    function error();
    function version();
    function freeResult($result);
    function close();
}
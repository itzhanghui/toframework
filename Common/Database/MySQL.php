<?php
/**
 * @package Common\Database
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.03
 * @edit date 2022.03.27
 * @file MySQL.php
 */
namespace Common\Database;
use Exception;
class MySQL implements IDatabase
{
    private $conn;
    private $linked = false;
    private $query_num;
    private $tb_pre;
    private static $db = null;
    private function __construct()
    {

    }
    public static function getInstance()
    {
        if(self::$db)
        {
            return self::$db;
        }else{
            return self::$db = new self();
        }
    }
    function connect($db_host, $db_user, $db_pass, $db_name, $db_charset)
    {
        $this->conn = mysql_connect($db_host,$db_user, $db_pass);
        if($this->conn){
            $this->linked = true;
        }else{
            for($i = 0; $i < 3; $i++){
                if(!$this->linked) $this->conn = mysql_connect($db_host,$db_user, $db_pass);
                if($this->conn){
                    $this->linked = true;
                    break;
                }
            }
        }
        if(!$this->linked) throw new Exception("Cannot link database!please check");
        if(substr(mysql_get_server_info(), 0, 3) < 5.0){
            throw new Exception("your MySQL version is too low, must be greater than 5.0");
        }else{
            mysql_query("SET NAMES $db_charset");
            mysql_query("SET sql_mode=''", $this->conn);
        }
        if($db_name && !mysql_select_db($db_name, $this->conn)) throw new Exception("Cannot use this database of $db_name,please check if Mysql is installed correctly");
        return $this->conn;

    }
    function query($sql)
    {
        if(!($query = mysql_query($sql, $this->conn))) $this->message('Mysql query Error!');
        $this->query_num++;
        return $query;
    }
    function getInsertId()
    {
        return mysql_insert_id($this->conn);
    }
    function getQueryNum()
    {
        return $this->query_num;
    }
    function fetchArray($result, $result_type = MYSQL_ASSOC)
    {
        return mysql_fetch_array($result,$result_type);
    }
    function count($tb, $condition = '')
    {
        $sql = 'SELECT COUNT(*) as amount FROM '.$tb;
        if($condition) $sql .= ' WHERE '.$condition;
        $sql .= ' LIMIT 0,1';
        $result = $this->query($sql);
        $r = $this->fetchArray($result);
        $this->freeResult($result);
        return $r ? $r['amount'] : 0;
    }
    function affectedRows()
    {
       return mysql_affected_rows($this->conn);
    }
    function numRows($query)
    {
        return mysql_num_rows($query);
    }
    function numFields($query)
    {
        return mysql_num_fields($query);
    }
    function getLinked()
    {
        return $this->linked;
    }
    function setTbPre($tb_pre)
    {
        $this->tb_pre = $tb_pre;
    }
    function getTbPre()
    {
        return $this->tb_pre;
    }
    function message($msg, $sql = '')
    {
        if($sql) $sql = str_replace($this->tb_pre,'[pre]', $sql);
        $msg = "MySQL query $sql, error has occurred,error:".str_replace($this->tb_pre,'[pre]',$this->error())."errno".$this->errNo();
        throw new Exception($msg);
    }
    function errNo()
    {
        return intval($this->error());
    }
    function error()
    {
        return @mysql_error($this->conn);
    }
    function version()
    {
        return mysql_get_server_info($this->conn);
    }
    function freeResult($result)
    {
        return @mysql_free_result($result);
    }
    function close()
    {
        return mysql_close($this->conn);
    }
}
<?php
/**
 * @package Common\Database
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.03
 * @edit date 2022.03.27
 * @file MySQLi.php
 */
namespace Common\Database;
use Exception;
class MySQLi implements IDatabase
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
    function connect($db_host, $db_user, $db_pass, $db_name,$db_charset)
    {
        $this->conn = mysqli_connect($db_host,$db_user, $db_pass, $db_name);
        if($this->conn){
            $this->linked = true;
        }else{
            for($i = 0; $i < 3; $i++){
                if(!$this->linked) $this->conn = mysqli_connect($db_host,$db_user, $db_pass, $db_name);
                if($this->conn){
                    $this->linked = true;
                    break;
                }
            }
        }
        if(!$this->linked){
            throw new Exception("Cannot link database!please check");
        }
        if(substr(mysqli_get_server_info($this->conn), 0, 3) < 5.0){
            throw new Exception("your MySQLi version is too low, must be greater than 5.0");
        }else{
            mysqli_query($this->conn, "set sql_mode=''");
            mysqli_query($this->conn,"set names $db_charset");
        }
        return $this->conn;

    }
    function query($sql)
    {
        if(!($query = mysqli_query($this->conn, $sql))) $this->message('Mysql query Error!');
        $this->query_num++;
        return $query;
    }
    function getInsertId()
    {
        return mysqli_insert_id($this->conn);
    }
    function getQueryNum()
    {
        return $this->query_num;
    }
    function fetchArray($result, $result_type = MYSQLI_ASSOC)
    {
        return mysqli_fetch_array($result,$result_type);
    }
    function count($tb, $condition = '')
    {
        if($condition) $condition = " WHERE $condition";
        $result = $this->query("SELECT COUNT(*) AS amount FROM $tb $condition");
        $r = $this->fetchArray($result);
        $this->freeResult($result);
        return $r ? $r['amount'] : 0;
    }
    function affectedRows()
    {
        return mysqli_affected_rows($this->conn);
    }
    function numRows($query)
    {
        return mysqli_num_rows($query);
    }
    function numFields($query)
    {
        return mysqli_num_fields($query);
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
        return @mysqli_error($this->conn);
    }
    function version()
    {
        return mysqli_get_server_info($this->conn);
    }
    function freeResult($result)
    {
        mysqli_free_result($result);
    }
    function close()
    {
        return mysqli_close($this->conn);
    }
    function __call($func, $param){
        return 'magic function';
    }
}
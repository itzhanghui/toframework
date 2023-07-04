<?php
/**
 * @package Common\Database
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.03
 * @edit date 2022.03.31
 * @file PDO.php
 */
namespace Common\Database;
use PDOException;
class PDO implements IDatabase
{
    private $conn = null;
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
        $dsn = "mysql:dbname=$db_name;host=127.0.0.1";
        try
        {
            $this->conn = new \PDO($dsn, $db_user, $db_pass);
            $this->linked = true;
        }
        catch (PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
        return $this->conn;

    }
    function query($sql)
    {
        try{
            $query = $this->conn->query($sql);
            $this->query_num++;
            return $query;
        }
        catch(PDOException $e){
            print $e->getMessage();
            return $e->getMessage();
        }

    }
    function getInsertId()
    {
        return $this->conn->lastInsertId();
    }
    function getQueryNum()
    {
        return $this->query_num;
    }
    function fetchArray($result, $result_type = \PDO::FETCH_ASSOC)
    {
        return $result->fetch($result_type);
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
        //return $this->st->rowCount();
    }
    function numRows($query)
    {
        return $query->columnCount();
    }
    function numFields($query)
    {
        //return mysqli_num_fields($query);
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
        throw new PDOException($msg);
    }
    function errNo()
    {
        return intval($this->conn->errorCode());
    }
    function error()
    {
        return @$this->conn->errorInfo();
    }
    function version()
    {
        return \PDO::ATTR_SERVER_VERSION;
    }
    function freeResult($result)
    {
        $this->conn = null;
    }
    function close()
    {
        unset($this->conn);
    }
}
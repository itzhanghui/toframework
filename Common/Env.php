<?php
/**
 * @package HuaLang.site.
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.11
 * @id Env.php
 */
namespace Common;

class Env{
    private static $ip;
    private static $self;
    private static  $ref;
    private static $domain;
    private static $url;
    static function setIp()
    {
        isset($_SERVER['HTTP_X_FORWARDED_FOR']) or $_SERVER['HTTP_X_FORWARDED_FOR'] = '';
        isset($_SERVER['REMOTE_ADDR']) or $_SERVER['REMOTE_ADDR'] = '';
        isset($_SERVER['HTTP_CLIENT_IP']) or $_SERVER['HTTP_CLIENT_IP'] = '';
        if($_SERVER['HTTP_X_FORWARDED_FOR'] && $_SERVER['REMOTE_ADDR']) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if(strpos($ip, ',') !== false) {
                 $arr_ip =explode(',',$ip);
                $ip = trim(reset($arr_ip));
            }
            if(self::isIp($ip)) {
                self::$ip = $ip;
                return true;
            }
        }else if(self::isIp($_SERVER['HTTP_CLIENT_IP'])) {
            self::$ip = $_SERVER['HTTP_CLIENT_IP'];
            return true;
        }else if(self::isIp($_SERVER['REMOTE_ADDR'])){
            self::$ip = $_SERVER['REMOTE_ADDR'];
            return true;
        }else{
            self::$ip = 'unknown';
            return true;
        }
        return false;
    }
    private static function isIp($ip) {
        return preg_match("/^(\d{1,3}\.){3}\d{1,3}$/", $ip);
    }
    public static function getIp(){
        self::setIp();
        return self::$ip;
    }
    public static function getSelf(){
        if(isset($_SERVER['PHP_SELF'])){
            self::$self = $_SERVER['PHP_SELF'];
            return self::$self;
        }else if(isset($_SERVER['SCRIPT_NAME'])){
            self::$self = $_SERVER['SCRIPT_NAME'];
            return self::$self;
        }else if(isset($_SERVER['ORIG_PATH_INFO'])){
            self::$self = $_SERVER['ORIG_PATH_INFO'];
            return self::$self;
        }
        return '';
    }
    public static function getRef(){
        self::$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        return self::$ref;
    }
    public  static function getDomain(){
        self::$domain = $_SERVER['SERVER_NAME'];
        return self::$domain;
    }
    public static function getScheme(){
        return (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT']) == '443' ? 'https://' : 'http://';
    }
    public static function getPort(){
        return isset($_SERVER['SERVER_PORT']) ? ($_SERVER['SERVER_PORT'] == '80' ? '' : ':'.$_SERVER['SERVER_PORT']) : '';
    }
    public static function getHost(){
        return (isset($_SERVER['HTTP_HOST']) && preg_match("/^[a-z0-9_\-.]{4,}$/i", $_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '';
    }
    public static function getUrl(){
        if(isset($_SERVER['HTTP_X_REWRITE_URL']) && $_SERVER['HTTP_X_REWRITE_URL']) {
            $uri = $_SERVER['HTTP_X_REWRITE_URL'];
        } else if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']) {
            $uri = $_SERVER['REQUEST_URI'];
        } else {
            $uri = $_SERVER['PHP_SELF'];
            if(isset($_SERVER['argv'])) {
                if(isset($_SERVER['argv'][0])) $uri .= '?'.$_SERVER['argv'][0];
            } else {
                $uri .= '?'.$_SERVER['QUERY_STRING'];
            }
        }
        $uri = enhance_html_special_chars($uri);
        $port = strpos(self::getHost(), ':') === false ? self::getPort() : '';
        self::$url = self::getScheme().self::getHost().$port.$uri;
        return self::$url;
    }
    public static function getRobot(){
        return isset($_SERVER['HTTP_USER_AGENT']) ? preg_match("/(Googlebot|Baiduspider|Yahoo! Slurp|msnbot|Sogou web spider|Sogou Orion spider|lycos_spider)/i", $_SERVER['HTTP_USER_AGENT']) : '';
    }
    public static function getHttpUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}
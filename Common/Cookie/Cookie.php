<?php
/**
 * @package Common\Cookie
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.27
 * @file Cookie.php
 */
namespace Common\Cookie;
use common\Env;
use Common\Factory\Factory;
class Cookie
{
    protected static $cookie_pre;

    static function getCookiePre()
    {
        $config = Factory::getConfig();
        self::$cookie_pre = $config['common']['cookie_pre'];
        return self::$cookie_pre;
    }
    static function set($key, $val = '', $expire = 0) {
        $config = Factory::getConfig();
        $key = $config['common']['cookie_pre'].$key;
        $val = trim($val);
        $time = time() + $config['common']['time_diff'];
        $expire = $expire > 0 ? $expire : (empty($val) ? $time - 1800 : 0);
        $cookie_path = trim($config['common']['cookie_path']);
        $cookie_domain = trim($config['common']['cookie_domain']);
        $secure = Env::getPort() == '443' ? 1 : 0;
        return setcookie($key, $val, $expire, $cookie_path, $cookie_domain, $secure);
    }
    static function get($key)
    {
        $key = self::getCookiePre().$key;
        return (isset($_COOKIE[$key]) && $_COOKIE[$key]) ? $_COOKIE[$key] : '';
    }
}
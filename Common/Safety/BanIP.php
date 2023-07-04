<?php
/**
 * @package Common\Safety
 * @copyright (c) HuaLang Technologies Co.,ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.31
 * @file Safety.php
 */
namespace Common\Safety;
use Common\FS\FS;
use Common\Env;
use Common\Factory\Factory;
class BanIP
{
    private static $ip = array();
    private static $ban='';
    static function getIP(){
        self::$ip = FS::getFile(HL_CACHE_IP.Env::getIp().'.php');
    }
    static function getBan(){
        return self::$ban;
    }
    static function checkIP(){
        $bool_ban = false;
        $ban = '';
        if(self::$ip){
            $config = Factory::getInstance('language\\zh_cn\\pc');
            var_dump($config);exit;
            $HL_TIME = time() + $config['common']['time_diff'];
            foreach(self::$ip as $k=>$v) {
                if($v['to_time'] && $v['to_time'] < $HL_TIME) continue;
                $ban = str_replace('{V'.$k.'}', $v, $config['safety']['ban_ip']);
                if($v['ip_address'] == Env::getIp()) { $bool_ban = true; break; }
                if(preg_match("/^".str_replace('*', '[0-9]{1,3}', $v['ip'])."$/", Env::getIp())) { $bool_ban = true; break; }
            }

        }
        if($bool_ban) self::$ban = $ban;
        return $bool_ban;
    }
}

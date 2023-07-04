<?php
/**
 * @package Common\Session
 * @copyright (c) HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.09
 * @edit date 2022.03.27
 * @file File.php
 */
namespace Common\Session;
use Common\FS\FS;
class File
{
    public function __construct() {
        if(HL_DOMAIN) @ini_set('session.cookie_domain', '.'.HL_DOMAIN);
        @ini_set('session.gc_maxlifetime', 1800);
        if(is_dir(HL_ROOT.'/cache/session/')) {
            $dir = HL_ROOT.'/cache/session/'.substr(HL_KEY, 2, 6).'/';
            if(is_dir($dir)) {
                session_save_path($dir);
            } else {
                FS::mk_dir($dir);
            }
        }
        session_cache_limiter('private, must-revalidate');
        @session_start();
        header("cache-control: private");
    }
}
<?php
/*
 * @package configs
 * @copyright(c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.30
 * @id common.php
 * */
defined('GATE') or die('Access Error!');
$config = array(
    'charset' => 'utf-8',
    'url' => 'http://www.hualangcloud.com/',
    'admin_url' => 'admin_saas.php',
    'chmod' => '0777',
    'cache' => 'File',
    'cache_pre' => 'cms_',
    'cache_dir' => '',
    'cache_ip_dir' => 'ip',
    'tag_expire' => '0',
    'tpl_refresh' => '1',
    'tpl_trim' => '0',
    'cookie_domain' => '',
    'cookie_path' => '/',
    'cookie_pre' => 'hl_',
    'session' => 'FileSession',
    'time_zone' => 'Etc/GMT-8',
    'time_diff' => '0',
    'tpl' => 'default1.0',
    'mobi_tpl' => 'default1.0',
    'weixin_tpl' => 'default1.0',
    'language' => 'zh_cn',
    'auth_admin' => 'session',
    'auth_key' => 'hualangauthkey',
    'static' => '',
    'edit_tpl' => '1',
    'execute_sql' => '1',
    'founder_id' => '1',
    'user_dir_alias_name' => 'passport',
    'login_file_name' => 'login.php',
    'register_file_name' => 'register.php',
    'entry' => array('app','admin'),

);
return $config;


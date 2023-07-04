<?php
/**
 * @package Common\Constant
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.29
 * @file define.php
 */
defined('GATE') or die('Access Error!');
define('HL_CHARSET', $config['common']['charset']);
define('HL_CHMOD', $config['common']['chmod']);
//define HL_CACHE,HL_CACHE_IP
define('HL_CACHE', $config['common']['cache_dir'] ? $config['common']['cache_dir'] : HL_ROOT.'/cache');
define('HL_CACHE_IP',HL_CACHE.'/'.$config['common']['cache_ip_dir']);
define('HL_PATH', $config['common']['url']);
const HL_FILE_CACHE = HL_CACHE.'/cache';
define('HL_DOMAIN', $config['common']['cookie_domain'] ? substr($cofig['common']['cookie_domain'], 1) : '');
define('HL_KEY', $config['common']['auth_key']);
const HL_DEF_ERR_MSG = 'operation fail';
define('HL_TPL', HL_ROOT.'/templates/'.$config['common']['tpl']);
const HL_DEBUG = true;
/**

define('HL_LANG_DIR', HL_ROOT.'/language/'.$CONFIG['language']);
define('HL_LIB', HL_ROOT.'/architecture/lib');
define('HL_MODULE', HL_ROOT.'/architecture/module');
define('HL_ETC', HL_ROOT.'/architecture/etc');
define('HL_ADMIN', HL_ROOT.'/wide/adminmanager');
define('HL_ADMIN_MENU', HL_ADMIN.'/menu');
define('HL_ADMIN_MODULE', HL_ADMIN.'/module');
define('HL_ADMIN_MODULE_CORE', HL_ADMIN_MODULE.'/core');
define('HL_ADMIN_FIELD', HL_ROOT.'/wide/adminmanager/field');
define('HL_ADMIN_STRUCT', HL_ADMIN_MODULE.'/struct');

define('HL_ROOT_JS_CONFIG', HL_ROOT.'/wide/static/js/config');
define('HL_INSTALL', HL_ROOT.'/wide/installation');
define('HL_USER_DIR_ALIAS_NAME', $CONFIG['user_dir_alias_name']);

define('HL_UPLOAD_DIR', 'wide/static/uploadfile');
define('HL_UPLOADFILE_PATH', HL_PATH.HL_UPLOAD_DIR);
define('HL_LOGIN_FILE_NAME', $CONFIG['login_file_name']);
define('HL_REGISTER_FILE_NAME', $CONFIG['register_file_name']);
define('IN_ADMIN', defined('HL_IS_ADMIN') ? true : false);
define('HL_OUT', HL_ROOT.'/out');



define('HL_STATIC', $CONFIG['url'].'wide/static/');
define('HL_LANG_NAME', $CONFIG['language']);
define('HL_JS', HL_STATIC.'js/');
define('HL_IMAGES', HL_STATIC.'images/');
define('HL_CSS', HL_STATIC.'images/');
define('HL_LANG_JS', $CONFIG['url'].'language/'.$CONFIG['language'].'/');
define('HL_ADMIN_CSS', $CONFIG['url'].'wide/static/admin_images/');
define('HL_ADMIN_IMAGES', $CONFIG['url'].'wide/static/admin_images/');






define('HL_AVATAR', HL_PATH.'data/avatar/');
define('HL_COMPANY_THUMB', HL_PATH.'data/company_thumb/');
define('HL_DELIMITER', '_');

define('HL_UPLOAD_PATH', HL_PATH.'wide/static/uploadfile/');
define('HL_MALL_UPLOAD_PATH', HL_PATH.'wide/static/uploadfile/');
define('HL_STRUCT_PATH', HL_PATH.'struct/');
define('HL_STRUCT_UPLOAD_PATH', HL_PATH.'wide/static/uploadfile/struct/');
define('HL_STRUCT_IMAGES', HL_IMAGES.'struct/');
define('HL_STRUCT_JS', HL_JS.'struct/');
define('HL_STRUCT_URL',substr($CONFIG['url'], 11));
//echo HL_STRUCT_URL;exit;
define('HL_GENERATOR',$CONFIG['generator']);
//sscmp set
define('HL_SSCMP', HL_ROOT.'/sscmp');
define('HL_SSCMP_PC', HL_SSCMP.'/pc');
define('HL_SSCMP_MOBI', HL_SSCMP.'/mobi');
define('HL_SSCMP_WEIXIN', HL_SSCMP.'/weixin');
define('HL_SSCMP_PC_CLASS', HL_SSCMP_PC.'/class');
define('HL_SSCMP_PC_JS', HL_SSCMP_PC.'/js');
define('HL_SSCMP_PC_CPANEL', HL_SSCMP_PC.'/cpanel');
define('HL_SSCMP_PC_CSS', HL_SSCMP_PC.'/css');
define('HL_SSCMP_PC_ETC', HL_SSCMP_PC.'/etc');
define('HL_SSCMP_PC_FUNCTION', HL_SSCMP_PC.'/function');
define('HL_SSCMP_PC_LANGUAGE', HL_SSCMP_PC.'/language');
define('HL_SSCMP_PC_MENU', HL_SSCMP_PC.'/menu');
define('HL_SSCMP_PC_PANEL', HL_SSCMP_PC.'/panel');
define('HL_SSCMP_PC_TPL', HL_SSCMP_PC.'/tpl');
define('HL_SSCMP_PC_VIEW', HL_SSCMP_PC.'/view');
 */

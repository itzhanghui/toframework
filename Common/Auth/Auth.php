<?php
/**
 * @package Common\Auth
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.27
 * @file Auth.php
 */
namespace Common\Auth;
use Common\Env;
use Common\Factory\Factory;
use Common\Database\DatabaseProxy;
use Common\Cookie\Cookie;
class Auth
{
    public static $_user_id = 0;
    public static $_is_admin = 0;
    public static $_message = 0;
    public static $_is_online = 0;
    public static $_money = 0;
    public static $_credit = 0;
    public static $_sms = 0;
    public static $_category_id = 0;
    public static $_user_name = '';
    public static $_avatar = '';
    public static $_company_name = '';
    public static $_real_name = '';
    public static $_company_url = '';
    private static $_ug_id = 3;
    private static $DatabaseProxy;
    static function init()
    {
        $arr_auth = Cookie::get('auth');
        self::$_user_name = Cookie::get('user_name');
        if($arr_auth && self::$_user_name) {
            $AUTH = explode("\t", decrypt($arr_auth));
            if((isset($AUTH[0]) && $AUTH[0])  && (isset($AUTH[1]) && $AUTH[1]) && (isset($AUTH[2]) && $AUTH[2]) && (isset($AUTH[3]) && $AUTH[3])) {
                self::$_user_id = $AUTH[0];
                self::$_user_name = $AUTH[1];
                self::$_ug_id = $AUTH[2];
                $_user_pwd = $AUTH[3];
            }else{
                self::$_user_id = 0;
            }
            self::$_user_id = isset(self::$_user_id) ? intval(self::$_user_id) : 0;
            self::$_user_name = isset(self::$_user_name) ? trim(self::$_user_name) : '';
            self::$_ug_id = isset(self::$_ug_id) ? intval(self::$_ug_id) : 3;
            if(self::$_user_id && !defined('HL_NONUSER')){
                $_user_pwd = isset($_user_pwd) ? trim($_user_pwd) : '';
                $config = Factory::getConfig();
                $tb_user = $config['table']['tb_pre']['pre'].$config['table']['tb_name']['user'];
                self::$DatabaseProxy =new DatabaseProxy();
                $result = self::$DatabaseProxy->query("SELECT user_pwd,company_name,ug_id,is_admin,is_online,avatar,real_name,message,sms,credit,money FROM $tb_user WHERE user_id=self::$_user_id");
                $_arr_user = self::$DatabaseProxy->fetchArray($result);
                //var_dump($_arr_user);exit;
                if($_arr_user && $_arr_user['user_pwd'] == $_user_pwd){
                    if($_arr_user['ug_id'] == 2) exit($config['safety']['user_auth_denied']);
                    self::$_is_admin = $_arr_user['is_admin'];
                    self::$_company_name = $_arr_user['company_name'];
                    self::$_is_online = $_arr_user['is_online'];
                    self::$_avatar = $_arr_user['avatar'];
                    self::$_message = $_arr_user['message'];
                    self::$_sms = $_arr_user['sms'];
                    self::$_credit = $_arr_user['credit'];
                    self::$_money = $_arr_user['money'];
                    self::$_real_name = $_arr_user['real_name'];

                    $tb_company = $config['table']['tb_pre']['pre'].$config['table']['tb_name']['company'];
                    $result = self::$DatabaseProxy->query("SELECT company_url,category_id FROM $tb_company WHERE user_id=$_user_id");
                    $_arr_company = self::$DatabaseProxy->fetchArray($result);
                    self::$_company_url = $_arr_company['company_url'];
                    self::$_category_id = $_arr_company['category_id'];
                }else{
                    self::$_user_id = 0;
                    self::$_ug_id = 3;
                    self::$_user_name = '';
                    if(self::$DatabaseProxy && !isset($swfupload) && strpos(Env::getHttpUserAgent(), 'Flash') === false) Cookie::set('auth');
                }
                unset($arr_auth, $_arr_user, $_user_pwd);
            }
        }
    }
}




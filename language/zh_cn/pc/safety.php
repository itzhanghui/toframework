<?php
/*
 * @package language\zh_cn_pc
 * @copyright(c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.30
 * @id safety.php
 * */
defined('GATE') or die('Access Error!');
$config = array(
    'user_auth_denied' => '您被拒绝访问',
    'deny_permission' => '您没有此权限',
    'ban_ip' => '您IP {V0} 非法操作已经被网站禁止',
    'ban_words' => '提交的内容含有非法信息',
    'ban_area' => '您不是在指定的地区内操作',
    'captcha_missed' => '请填写验证码',
    'captcha_expired' => '验证码已过期',
    'captcha_error' => '验证码不正确',
    'answer_missed' => '请填写答案',
    'question_expired' => '问题已过期',
    'answer_error' => '答案不正确',
);
return $config;


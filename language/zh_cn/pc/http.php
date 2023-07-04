<?php
/*
 * @package HuaLang.site.
 * @copyright(c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.11
 * @id http.php
 * */
defined('GATE') or die('Access Error!');
$config = array(
    'without_permission' => '非常抱歉，您所在会员组没有权限访问此页面！',
    '404_error_page' => '非常抱歉，您的页面没有找到',
    'reload_msg' => '刷新太快，请间隔{V0}秒访问',
    'defend_proxy' => '禁止使用代理访问本站',
    'url_php' => '动态',
    'url_htm' => '静态',
    'url_eg' => '例',
);
return $config;
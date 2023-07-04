<?php
/**
 * @package configs
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.30
 * @id database.php
 */
defined('GATE') or die('Access Error!');
$config = array(
    'master' => array(
        'db_type' => 'MySQL',
        'db_host' => 'localhost',
        'db_user' => 'root',
        'db_pass' => '',
        'db_name' => 'hualangcloud',
        'db_charset' => 'utf8',
    ),
    'slave' => array(
        'slave1' => array(
            'db_type' => 'MySQL',
            'db_host' => 'localhost',
            'db_user' => 'hualangcloud',
            'db_pass' => 'xxxxxx',
            'db_name' => 'hualangcloud',
            'db_charset' => 'utf8',
        ),
        'slave2' => array(
            'db_type' => 'MySQL',
            'db_host' => 'localhost',
            'db_user' => 'hualangcloud',
            'db_pass' => 'xxxxxx',
            'db_name' => 'hualangcloud',
            'db_charset' => 'utf8',
        ),
    ),
);
return $config;

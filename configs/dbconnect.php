<?php
/**
 * @package configs
 * @copyright(c) HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.08
 * @edit date 2022.03.30
 * @id dbconnect.php
 */
$config = array(
    'master' => array(
        'link' => 'MySQL',
        //'link' => 'MySQLi',
        //'link' => 'PDO',
    ),
    'slave' => array(
        'slave1' =>array(
            'link' => 'MySQL',
            //'link' => 'MySQLi',
            //'link' => 'PDO',
        ),
        'slave2' =>array(
            'link' => 'MySQL',
            //'link' => 'MySQLi',
            //'link' => 'PDO',
        ),
        'slave3' =>array(
            'link' => 'MySQL',
            //'link' => 'MySQLi',
            //'link' => 'PDO',
        ),
    ),
);
return $config;
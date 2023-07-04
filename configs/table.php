<?php
/**
 * @package confis
 * @copyright (c) HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.30
 * @id table.php
 */
defined('GATE') or die('Access Error!');
$config = array(
    'tb_pre' => array(
        'pre' => 'hl_',
    ),
    'tb_name' => array(
        'config' => 'config',
        'company' => 'company',
        'company_data' => 'company_data',
        'user' => 'user',
    ),


);
return $config;

<?php
/*
 * @package HuaLang.site.
 * @copyright(c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.11
 * @id module.php
 * */
defined('GATE') or die('Access Error!');
$config = array(
    'module_id_is_null' => '模型管理ID不能为空',
    'module_id_not_exists' => '您所选的模型管理ID不存在',
    'module_en_name_is_exists' => '您所输入的模型名称已经存在，请更换其他的名称',
    'module_en_name_is_null' => '您所输入的模型名称为空或者太短，填写名称',
    'module_en_name_format_error' => '您所输入的模型名称不是一个合法的名称，请重新填写',
    'module_cn_name_is_exists' => '您所输入的模块名称已经存在，请更换其他的名称',
    'module_cn_name_is_null' => '您所输入的模块名称为空，填写名称',
    'module_cn_name_format_error' => '您所输入的模块名称不是一个合法的名称，请重新填写',
    'module_edit_ok' => '模块修改成功',
    'module_is_null' => '您的模块为空，请填写数据信息',
    'module_en_name_not_allow' => '您不能随意修改成一个根本不存在的模型名称',
    'module_add_ok' => '模块添加成功',
    'module_is_sys_dir' => '您输入的模型名称与系统保护目录名称冲突请更换其他的模型名称',
    'module_sys_not_delete' => '系统的模型是不能删除的，您只有权删除个人添加的目录',
    'module_is_uninstall' => '你选择的模型是不可以删除或者卸载的',
    'module_delete_ok' => '模块删除成功',
    'mod_day' => '天',
    'mod_hour' => '小时',
    'mod_minute' => '分',
    'mod_second' => '秒',
);
return $config;

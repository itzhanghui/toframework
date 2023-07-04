<?php
/**
 * @package Common\Variable
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.27
 * @file Spm.php
 */
namespace Common\Variable;
use Common\Register;
class Spm
{
    static function init($spm)
    {
        if(isset($spm) && $spm){
            $arr_spm = explode(".", $spm);
            if(isset($arr_spm[0])) Register::set('module_id',intval($arr_spm[0]));
            if(isset($arr_spm[1])) Register::set('file',intval($arr_spm[1]));
            if(isset($arr_spm[2])) Register::set('action',intval($arr_spm[2]));
        }
    }
}
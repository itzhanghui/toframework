<?php
/**
 * @package Common\Lib
 * @copyright(c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.27
 * @file base.func.php
 */
defined('GATE') or die("Access Error!");
function auto_str_replace($file_path){
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $file_path = str_replace("\/", '\\', $file_path);
    } else {
        $file_path = str_replace("\\", '/', $file_path);
    }
    return $file_path;
}
function debug_time(){
    error_reporting(E_ALL);
    $arr_debug_time = explode(' ', microtime());
    return $arr_debug_time[0] + $arr_debug_time[1];
}
function encrypt($ciphertext, $key = '') {
    $key or $key = HL_KEY;
    $rnd = random(32);
    $len = strlen($ciphertext);
    $ctr = 0;
    $str = '';
    for($i = 0; $i < $len; $i++) {
        $ctr = $ctr == 32 ? 0 : $ctr;
        $str .= $rnd[$ctr].($ciphertext[$i] ^ $rnd[$ctr++]);
    }
    return str_replace('=', '', base64_encode(factor($str, $key)));
}

function decrypt($ciphertext, $key = '') {
    $key or $key = HL_KEY;
    $ciphertext = factor(base64_decode($ciphertext), $key);
    $len = strlen($ciphertext);
    $str = '';
    for($i = 0; $i < $len; $i++) {
        $tmp = $ciphertext[$i];
        if($i != ($len - 1)) $str .= $ciphertext[++$i] ^ $tmp;
    }
    return $str;
}

function factor($ciphertext, $key) {
    $key = md5($key);
    $len = strlen($ciphertext);
    $ctr = 0;
    $str = '';
    for($i = 0; $i < $len; $i++) {
        $ctr = $ctr == 32 ? 0 : $ctr;
        $str .= $ciphertext[$i] ^ $key[$ctr++];
    }
    return $str;
}


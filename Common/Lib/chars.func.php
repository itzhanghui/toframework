<?php
/**
 * @package Common\Lib
 * @copyright(c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.27
 * @file chars.func.php
 */
defined('GATE') or die("Access Error!");
function enhance_html_special_chars($str){
    if(!is_array($str)){
        $str = htmlspecialchars($str, ENT_QUOTES);
        return defined('HL_IS_ADMIN') ? str_replace(array('&amp;'), array('&'), $str) : str_replace(array('&amp;', '&quot;', '&#34;', '"'), array('&', '', '', ''), $str);
    }else{
        return array_map('enhance_html_special_chars', $str);
    }
}
function enhance_add_slashes($str) {
    if(!is_array($str)){
        $str =  addslashes($str);
    } else{
        foreach($str as $k => $v) $str[$k] = addslashes($v);
    }
    return $str;
}
function enhance_strip_slashes($str) {
    if(!is_array($str)){
        $str = stripslashes($str);
    }else{
        foreach($str as $k => $v) $str[$k] = stripslashes($v);
    }
    return $str;
}
function enhance_uri($uri) {
    if(strpos($uri, '%') !== false) $uri = urldecode($uri);
    if(preg_match("/(<|'|\"|0x)/", $uri)) {
        @header("HTTP/1.1 403 Forbidden");
    }
}
function enhance_sql($arr) {
    $match = array("/union/i","/where/i","/outfile/i","/dumpfile/i","/0x([a-z0-9]{2,})/i","/select([\s\S]*?)from/i","/select([\s*\/\-(+@])/i","/update([\s*\/\-(+@])/i","/replace([\s*\/\-(+@])/i","/delete([\s*\/\-(+@])/i","/drop([\s*\/\-(+@])/i","/load_file[\s]*\(/i","/substring[\s]*\(/i","/substr[\s]*\(/i","/left[\s]*\(/i","/concat[\s]*\(/i","/concat_ws[\s]*\(/i","/make_set[\s]*\(/i","/ascii[\s]*\(/i","/hex[\s]*\(/i","/ord[\s]*\(/i","/char[\s]*\(/i");
    $replace = array('unio&#110;','wher&#101;','outfil&#101;','dumpfil&#101;','0&#120;\\1','selec&#116;\\1from','selec&#116;\\1','updat&#101;\\1','replac&#101;\\1','delet&#101;\\1','dro&#112;\\1','load_fil&#101;(','substrin&#103;(','subst&#114;(','lef&#116;(','conca&#116;(','concat_w&#115;(','make_se&#116;(','asci&#105;(','he&#120;(','or&#100;(','cha&#114;(');
    return is_array($arr) ? array_map('enhance_sql', $arr) : preg_replace($match, $replace, $arr);
}
function enhance_key($arr, $deep = 0) {
    foreach($arr as $k=>$v) {
        if($deep && !preg_match("/^[a-z0-9_\-]+$/i", $k)) {
            @header("HTTP/1.1 403 Forbidden");
        }
        if(is_array($v)) enhance_key($v, 1);
    }
    return $arr;
}
function enhance_safe($string) {
    if(is_array($string)) {
        return array_map('dsafe', $string);
    } else {
        $string = preg_replace("/<!--([\s\S]*?)-->/", "", $string);
        $string = preg_replace("/\/\*([\s\S]*?)\*\//", "", $string);
        $string = preg_replace("/&#([a-z0-9]+)([;]*)/i", "", $string);
        if(preg_match("/&#([a-z0-9]+)([;]*)/i", $string)) return nl2br(strip_tags($string));
        $match = array("/s[\s]*c[\s]*r[\s]*i[\s]*p[\s]*t/i","/d[\s]*a[\s]*t[\s]*a[\s]*:/i","/b[\s]*a[\s]*s[\s]*e/i","/e[\\\]*x[\\\]*p[\\\]*r[\\\]*e[\\\]*s[\\\]*s[\\\]*i[\\\]*o[\\\]*n/i","/i[\\\]*m[\\\]*p[\\\]*o[\\\]*r[\\\]*t/i","/on([a-z]{2,})([(=|\s]+)/i","/about/i","/frame/i","/link/i","/meta/i","/textarea/i","/eval/i","/alert/i","/confirm/i","/prompt/i","/cookie/i","/document/i","/newline/i","/colon/i","/<style/i","/\\\\x/i");
        $replace = array("s<em></em>cript","da<em></em>ta:","ba<em></em>se","ex<em></em>pression","im<em></em>port","o<em></em>n\\1\\2","a<em></em>bout","f<em></em>rame","l<em></em>ink","me<em></em>ta","text<em></em>area","e<em></em>val","a<em></em>lert","/con<em></em>firm/i","prom<em></em>pt","coo<em></em>kie","docu<em></em>ment","new<em></em>line","co<em></em>lon","<sty1e","\<em></em>x");
        return preg_replace($match, $replace, $string);
    }
}
function strip_special_chars($str, $js = false) {
    $str =  str_replace(array(chr(13), chr(10), "\n", "\r", "\t", '  '),array('', '', '', '', '', ''), $str);
    if($js) $str = str_replace("'", "\'", $str);
    return $str;
}
function valid_name($name) {
    return (preg_match("/^[a-z0-9][a-z0-9_\-]*[a-z0-9]$/", $name) && !preg_match("/(__|--)/", $name));
}
function valid_file_path($name) {
    return preg_match("/^[a-z0-9][a-z0-9_\-]*\.[a-z]{3,5}$/", $name);
}
function valid_url($url) {
    return preg_match("/^(http|https):\/\/[A-Za-z0-9_\-\/.#&?;,=%]{4,}$/", $url);
}
function valid_chars($str){
    $arr_chars = array("\\", "'",'"','/','<','>',"\r","\t","\n");
    foreach($arr_chars as $v) {
        if(strpos($str, $v) !== false) return false;
    }
    return true;
}
function key_filter($key) {
    if(!$key) return '';
    $key = htmlspecialchars(urldecode(trim($key)));
    if(strpos($key, '%') !== false) return '';
    return str_replace("'", '', $key);
}
function strip_nr($str, $js = false) {
    $str =  str_replace(array("\n", chr(13), chr(10), "\r", "\t", '  '),array('', '', '', '', '', ''), $str);
    if($js) $str = str_replace("'", "\'", $str);
    return $str;
}
function valid_seo($char){
    $arr_filter_chars = array('<', '>', '(', ')', ';', '?', '\\', '"', "'");
    foreach($arr_filter_chars as $v){
        if(strpos($char, $v) !== false) return false;
    }
    return true;
}


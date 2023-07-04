<?php
/**
 * @package Common\Tpl
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.29
 * @file Tpl.php
 */
namespace Common\Tpl;
class Tpl
{
    private $file;
    private $config;
    public function __construct(){
        global $CONFIG;
        $this->config = $CONFIG;
    }
    public function get($file, $dir = ''){
        $this->file = $dir ? HL_CACHE.'/tpl/'.$dir.'-'.$file.'.php' : HL_CACHE.'/tpl/'.$file.'.php';
        if($this->config['tpl_refresh'] || !is_file($this->file)) $this->set($file,$dir);
        return $this->file;
    }
    public function set($file, $dir){
        if($dir) $dir = FileSystem::check_dir($dir);
        $from_file = HL_TPL.'/'.$dir.$file.'.htm';
        //echo $from_file;exit;
        if(!is_file($file) || filemtime($from_file) > filemtime($file) || (filesize($file) == 0 && filesize($from_file) > 0)){
            $content = $this->pattern(FileSys::get_file_contents($from_file));
            FileSys::file_put($this->file, $content);
        }
    }
    public function mall_get($file, $module_en_name, $dir = ''){
        if(!$dir) exit('dir is null');
        $this->file = HL_CACHE.'/tpl/'.$module_en_name.'/'.$dir.'/'.$file.'.php';
        if($this->config['tpl_refresh'] || !is_file($this->file)) $this->mall_set($file, $module_en_name, $dir);
        return $this->file;
    }
    public function mall_set($file, $module_en_name, $dir){
        if($dir) $dir = FileSystem::check_dir($dir);
        //echo $dir;exit;
        $from_file = HL_TPL.'/'.$module_en_name.'/'.$dir.$file.'.htm';
        //echo $from_file;exit;
        if(!is_file($file) || filemtime($from_file) > filemtime($file) || (filesize($file) == 0 && filesize($from_file) > 0)){
            $content = $this->pattern(FileSys::get_file_contents($from_file));
            FileSys::file_put($this->file, $content);
        }
    }
    private function add_quote($str){
        return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $str));
    }
    private function pattern($content){
        $content = preg_replace("/\<\!\-\-\[(.+?)\]\-\-\>/", "", $content);
        $content = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $content);
        $content = preg_replace("/\{tpl\s+([^\}]+)\}/", "<?php include \$Tpl->get(\\1);?>", $content);
        $content = preg_replace("/\{malltpl\s+([^\}]+)\}/", "<?php include \$Tpl->mall_get(\\1);?>", $content);
        $content = preg_replace("/\{php\s+(.+)\}/", "<?php \\1?>", $content);
        $content = preg_replace("/\{if\s+(.+?)\}/", "<?php if(\\1) { ?>", $content);
        $content = preg_replace("/\{else\}/", "<?php } else { ?>", $content);
        $content = preg_replace("/\{elseif\s+(.+?)\}/", "<?php } else if(\\1) { ?>", $content);
        $content = preg_replace("/\{\/if\}/", "<?php } ?>\r\n", $content);
        $content = preg_replace("/\{loop\s+(\S+)\s+(\S+)\}/", "<?php if(is_array(\\1)) { foreach(\\1 as \\2) { ?>", $content);
        $content = preg_replace("/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/", "<?php if(is_array(\\1)) { foreach(\\1 as \\2 => \\3) { ?>", $content);
        $content = preg_replace("/\{\/loop\}/", "<?php } } ?>", $content);
        $content = preg_replace("/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $content);
        $content = preg_replace("/<\?php([^\?]+)\?>/es", "\$this->add_quote('<?php\\1?>')", $content);
        $content = preg_replace("/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\+\-\x7f-\xff]*)\}/", "<?php echo \\1;?>", $content);
        $content = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "\$this->add_quote('<?php echo \\1;?>')", $content);
        $content = preg_replace("/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>", $content);
        $content = preg_replace("/\'([A-Za-z]+)\[\'([A-Za-z\.]+)\'\](.?)\'/s", "'\\1[\\2]\\3'", $content);
        $content = preg_replace("/(\r?\n)\\1+/", "\\1", $content);
        $content = str_replace(array("post['area_id']", "post['category_id']"), array("post[area_id]", "post[category_id]"), $content);
        $content = str_replace("\t", '', $content);
        $content = "<?php defined('GATE') or exit('Access Error!');?>".$content;
        if($this->config['tpl_trim']) return strip_nr($content);
        return $content;
    }
    public function assign($key, $value){
        $this->$assign[$key] = $value;
    }
    /**
     * @function display view file
     * @$dir set the name under the view directory
     * @$file file name
     * @description load view file,The first parameter DIR is required.
     * */
    public function display($dir, $file){
        $file_path = HL_APP_View_DIR.'/'.$dir.'/'.$file;
        if(is_file($file_path)){
            extract($this->assign);
            include($file_path);
        }
    }
}
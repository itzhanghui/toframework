<?php
/**
 * @package Common\Cache
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.27
 * @edit date 2022.03.27
 * @file File.php
 * */
namespace Common\Cache;
class File{
    private $pre;
    private $time;
    private $db;
    private $tb_pre;
    private $tb_file_cache;
    private $tb_module;
    private $tb_area;
    private $tb_category;
    private $tb_config;
    private $tb_user_group;
    private $tb_marks;
    private $tb_keywords_link;
    private $tb_ban_word;
    private $tb_item_set;
    private $tb_menu;
    private $tty;
    public function __construct(){
        global $db,$HL_TIME,$Config,$tty;
        $this->time = $HL_TIME;
        $this->db = &$db;
        $this->tb_pre = $this->db->get_pre();
        $this->tb_file_cache = $this->tb_pre.'file_cache';
        $this->tb_module = $this->tb_pre.'module';
        $this->tb_area = $this->tb_pre.'area';
        $this->tb_category = $this->tb_pre.'category';
        $this->tb_config = $this->tb_pre.'config';
        $this->tb_user_group = $this->tb_pre.'user_group';
        $this->tb_marks = $this->tb_pre.'marks';
        $this->tb_keywords_link =$this->tb_pre.'keywords_link';
        $this->tb_ban_word = $this->tb_pre.'ban_word';
        $this->tb_item_set = $this->tb_pre.'pc_item_set';
        $this->tb_menu = $this->tb_pre.'menu';
        $this->tty = $tty;
        if(!isset($Config)){
            $Config = new Config();
            $this->config = &$Config;
        }else{
            $this->config = &$Config;
        }
    }
    public function get($key) {
        $cache_file = HL_FILE_CACHE.'/'.$this->tty.'/'.substr($key, 0, 3).'/'.self::md5_key($key).'.php';
        if(!is_file($cache_file)) return '';
        $str = \Common\FileSystem::get_file_contents($cache_file);
        $ttl = substr($str, 53, 10);
        if($ttl < $this->time) return '';
        return substr($str, 63, 1) == '@' ? substr($str, 64) : unserialize(substr($str, 63));
    }
    public function set($key, $val, $expire = 600) {
        $key = self::md5_key($key);
        $last_expire= $this->time + $expire;
        $this->db->replace("REPLACE INTO {$this->tb_file_cache} (`cache_id`,`last_expire`) VALUES ('$key','$last_expire')");
        $val = "<?php defined('IN_GATE') or exit('Access Error!'); ?>".$expire.(is_array($val) ? serialize($val) : '@'.$val);
        return \Common\FileSystem::file_put(HL_FILE_CACHE.'/'.$this->tty.'/'.substr($key, 0, 3).'/'.$key.'.php', $val);
    }
    public function rm($key) {
        return \Common\FileSystem::file_delete(HL_FILE_CACHE.'/'.$this->tty.'/'.substr($key, 0, 3).'/'.self::md5_key($key).'.php');
    }
    private function md5_key($key){
        if(!is_md5($key)) $key = md5($this->tb_pre.$key);
        return $key;
    }
    public function expire() {
        $result = $this->db->get_all("SELECT cache_id FROM {$this->tb_file_cache} WHERE last_expire<$this->time ORDER BY last_expire ASC LIMIT 100");
        while($r = $this->db->fetch_array($result)) {
            $cache_id = $r['cache_id'];
            $this->rm($cache_id);
            $this->db->delete("DELETE FROM {$this->tb_file_cache} WHERE cache_id='$cache_id'");
        }
    }
    public function write($file_name, $arr_data, $dir = ''){
        //print_r($arr_data);exit;
        if(is_array($arr_data)) $str = "<?php defined('IN_GATE') or exit('Access Error!'); return ".strip_special_chars(var_export($arr_data, true))."; ?>";
        $file = $dir ? HL_FILE_CACHE.'/'.$this->tty.'/'.$dir.'/'.$file_name : HL_FILE_CACHE.'/'.$this->tty.'/'.$file_name;
        $strlen = \Common\FileSystem::file_put($file, $str);
        return $strlen;
    }
    public function set_module($module_id = 0) {
        if($module_id) {
            $r = $this->db->get_one("SELECT * FROM {$this->tb_module} WHERE module_id='$module_id'");
            $config = array();
            $config = $this->config->get($module_id);
            $config['module_id'] = $r['module_id'];
            $config['module_cn_name'] = $r['module_cn_name'];
            $config['module_en_name'] = $r['module_en_name'];
            $config['module_dir'] = $r['module_dir'];
            $config['link_url'] = $r['link_url'];
            $this->write('module-'.$module_id.'.php', $config);
            return true;
        } else {
            $result = $this->db->get_all("SELECT module_id,module_en_name,module_cn_name,module_dir,link_url,sort_order FROM {$this->tb_module}  ORDER BY sort_order asc,module_id desc");
            $arr_module = array();
            while($r = $this->db->fetch_array($result)) {
                $link_url = full_url($r['link_url']);
                if($r['module_id'] == 1) $link_url = HL_PATH;
                if($link_url != $r['link_url']) {
                    $r['link_url'] = $link_url;
                    $this->db->update("UPDATE {$this->tb_module} SET link_url='$link_url' WHERE module_id='$r[module_id]'");
                }
                $this->set_module($r['module_id']);
                $arr_module[$r['module_id']] = $r;
            }
            $this->write('modules.php', $arr_module);
        }
    }
    public function all() {
        $this->set_module();
        $this->area();
        $this->category();
        $this->user_group();
        $this->pay();
        //$this->mark();
        //$this->keywords_link();
        return true;
    }
    public function area() {
        $arr_area = array();
        $result = $this->db->get_all("SELECT area_id,area_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_area} ORDER BY sort_order,area_id");
        while($r = $this->db->fetch_array($result)) {
            $arr_area[$r['area_id']] = $r;
        }
        $this->write('areas.php', $arr_area);
    }
    public function category($arr_category = array()) {
        if(!$arr_category) {
            $sql = "SELECT category_id,category_name,category_dir,category_url,letter,level,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_category}  ORDER BY sort_order,category_id";
            $result = $this->db->get_all($sql);
            while($r = $this->db->fetch_array($result)) {
                $arr_category[$r['category_id']] = $r;
            }
        }
        $this->write('category.php', $arr_category);
    }
    public function call_category($arr_category = array()) {
        global $udb;
        $this->udb = &$udb;
        $this->tb_category =  $this->tb_pre.'category';
        if(!$arr_category) {
            $sql = "SELECT category_id,category_name,category_dir,link_url,letter,level,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_category} ORDER BY sort_order,category_id";
            $result = $this->udb->get_all($sql);
            while($r = $this->udb->fetch_array($result)) {
                $arr_category[$r['category_id']] = $r;
            }
        }
        $this->write('pc_call_category.php', $arr_category);
    }
    public function mall_category($arr_category = array()) {
        $this->tb_category =  $this->tb_pre.'mall_category';
        if(!$arr_category) {
            $sql = "SELECT category_id,category_name,category_dir,link_url,letter,level,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_category}  ORDER BY sort_order,category_id";
            //echo $sql;
            $result = $this->db->get_all($sql);
            while($r = $this->db->fetch_array($result)) {
                $arr_category[$r['category_id']] = $r;
            }
        }
        $this->write('mall_category.php', $arr_category);
    }
    public function struct_category($arr_struct_category = array()) {
        $this->tb_struct_category =  $this->tb_pre.'pc_struct_category';
        if(!$arr_struct_category) {
            $result = $this->db->get_all("SELECT struct_category_id,struct_category_name,struct_category_dir,letter,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_struct_category}  ORDER BY sort_order,struct_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_struct_category[$r['struct_category_id']] = $r;
            }
        }
        $this->write('struct_category.php', $arr_struct_category);
    }
    public function struct_tb_category($arr_struct_tb_category = array()) {
        $this->tb_struct_tb_category =  $this->tb_pre.'pc_struct_tb_category';
        if(!$arr_struct_tb_category) {
            $result = $this->db->get_all("SELECT struct_tb_category_id,struct_tb_category_name,struct_tb_name,letter,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_struct_tb_category}  ORDER BY sort_order,struct_tb_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_struct_tb_category[$r['struct_tb_category_id']] = $r;
            }
        }
        $this->write('struct_tb_category.php', $arr_struct_tb_category);
    }
    public function struct_data_tb_category($arr_struct_data_tb_category = array()) {
        $this->tb_struct_data_tb_category =  $this->tb_pre.'pc_struct_data_tb_category';
        if(!$arr_struct_data_tb_category) {
            $result = $this->db->get_all("SELECT struct_data_tb_category_id,struct_data_tb_category_name,struct_data_tb_name,letter,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_struct_data_tb_category}  ORDER BY sort_order,struct_data_tb_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_struct_data_tb_category[$r['struct_data_tb_category_id']] = $r;
            }
        }
        $this->write('struct_data_tb_category.php', $arr_struct_data_tb_category);
    }
    public function color_category($arr_color_category = array()) {
        $this->tb_color_category =  $this->tb_pre.'pc_color_category';
        if(!$arr_color_category) {
            $result = $this->db->get_all("SELECT color_category_id,color_category_name,color_category_dir,letter,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_color_category}  ORDER BY sort_order,color_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_color_category[$r['color_category_id']] = $r;
            }
        }
        $this->write('color_category.php', $arr_color_category);
    }
    public function screen_width_category($arr_screen_width_category = array()) {
        $this->tb_screen_width_category =  $this->tb_pre.'pc_screen_width_category';
        if(!$arr_screen_width_category) {
            $result = $this->db->get_all("SELECT screen_width_category_id,screen_width_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_screen_width_category}  ORDER BY sort_order,screen_width_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_screen_width_category[$r['screen_width_category_id']] = $r;
            }
        }
        $this->write('screen_width_category.php', $arr_screen_width_category);
    }
    public function width_category($arr_width_category = array()) {
        $this->tb_width_category =  $this->tb_pre.'pc_width_category';
        if(!$arr_width_category) {
            $result = $this->db->get_all("SELECT width_category_id,width_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_width_category}  ORDER BY sort_order,width_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_width_category[$r['width_category_id']] = $r;
            }
        }
        $this->write('width_category.php', $arr_width_category);
    }
    public function height_category($arr_height_category = array()) {
        $this->tb_height_category =  $this->tb_pre.'pc_height_category';
        if(!$arr_height_category) {
            $result = $this->db->get_all("SELECT height_category_id,height_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_height_category}  ORDER BY sort_order,height_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_height_category[$r['height_category_id']] = $r;
            }
        }
        $this->write('height_category.php', $arr_height_category);
    }
    public function margin_category($arr_margin_category = array()) {
        $this->tb_margin_category =  $this->tb_pre.'pc_margin_category';
        if(!$arr_margin_category) {
            $result = $this->db->get_all("SELECT margin_category_id,margin_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_margin_category}  ORDER BY sort_order,margin_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_margin_category[$r['margin_category_id']] = $r;
            }
        }
        $this->write('margin_category.php', $arr_margin_category);
    }
    public function padding_category($arr_padding_category = array()) {
        $this->tb_padding_category =  $this->tb_pre.'pc_padding_category';
        if(!$arr_padding_category) {
            $result = $this->db->get_all("SELECT padding_category_id,padding_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_padding_category}  ORDER BY sort_order,padding_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_padding_category[$r['padding_category_id']] = $r;
            }
        }
        $this->write('padding_category.php', $arr_padding_category);
    }
    public function position_category($arr_position_category = array()) {
        $this->tb_position_category =  $this->tb_pre.'pc_position_category';
        if(!$arr_position_category) {
            $result = $this->db->get_all("SELECT position_category_id,position_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_position_category}  ORDER BY sort_order,position_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_position_category[$r['position_category_id']] = $r;
            }
        }
        $this->write('position_category.php', $arr_position_category);
    }
    public function menu($arr_menu = array()) {
        $arr_menu = array();
        if(!$arr_menu) {
            $result = $this->db->get_all("SELECT menu_id,menu_name,menu_url,menu_type,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_menu}  WHERE status=2 ORDER BY sort_order,menu_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_menu[$r['menu_id']] = $r;
            }
        }
        $this->write('menu.php', $arr_menu);
    }
    public function pc_image_type_category($arr_category = array()) {
        $this->tb_category =  $this->tb_pre.'pc_image_type_category';
        if(!$arr_category) {
            $sql = "SELECT category_id,category_name,category_dir,category_letter,category_parent_id,category_parent_ids,category_is_child,category_child_ids FROM {$this->tb_category}  ORDER BY category_order,category_id";
            $result = $this->db->get_all($sql);
            while($r = $this->db->fetch_array($result)) {
                $arr_category[$r['category_id']] = $r;
            }
        }
        $this->write('pc_image_type_category.php', $arr_category);
    }
    public function factory_category($module_id = 0, $user_name, $arr_category = array()) {
        if(!$module_id) return false;
        if(!$user_name) return false;
        if($module_id == 5){
            $factory_tb_category =  $this->tb_pre.'category';
            if(!$arr_category) {
                $sql = "SELECT category_id,category_name,category_dir,category_url,category_letter,category_position,category_parent_id,category_parent_ids,category_is_child,category_child_ids FROM {$factory_tb_category} WHERE module_id=$module_id ORDER BY category_order,category_id";
                $result = $this->db->get_all($sql);
                while($r = $this->db->fetch_array($result)) {
                    $arr_category[$r['category_id']] = $r;
                }
            }
            $this->write('category-'.$user_name.'-'.$module_id.'.php', $arr_category);
        }
    }
    public function user_group() {
        $arr_ug = array();
        $result = $this->db->get_all("SELECT ug_id,ug_name,sort_order FROM {$this->tb_user_group} ORDER BY sort_order ASC,ug_id ASC");
        while($r = $this->db->fetch_array($result)){
            $ug_config = array();
            $ug_config = $this->config->get('user_group-'.$r['ug_id']);
            $arr_ug[$r['ug_id']] = $r;
            if($ug_config) {
                foreach($ug_config as $k=>$v) {
                    isset($r[$k]) or $r[$k] = $v;
                }
            }
            $this->write('user_group-'.$r['ug_id'].'.php', $r);
        }
        $this->write('user_groups.php', $arr_ug);
    }
    public function pay() {
        $arr_pay = $arr_pay_config = $arr_pay_order = array();
        $sql = "SELECT config_mark,config_key,config_val FROM {$this->tb_config} WHERE config_mark LIKE '%pay-%'";
        $result = $this->db->get_all($sql);
        while($r = $this->db->fetch_array($result)) {
            if(substr($r['config_mark'], 0, 4) == 'pay-') {
                $arr_pay_config[substr($r['config_mark'], 4)][$r['config_key']] = $r['config_val'];
                if($r['config_key'] == 'order') $arr_pay_order[substr($r['config_mark'], 4)] = $r['config_val'];
            }
        }
        asort($arr_pay_order);
        foreach($arr_pay_order as $k=>$v) {
            $arr_pay[$k] = $arr_pay_config[$k];
        }
        $this->write('pays.php', $arr_pay);
    }
    public function mark($mark_column = '') {
        if($mark_column) {
            $arr_mark = array();
            $sql = "SELECT mark_id,mark_name FROM {$this->tb_marks} WHERE mark_column='$mark_column' AND mark_cache=1 ORDER BY mark_order ASC,mark_id DESC";
            $result = $this->db->get_all($sql);
            while($r = $this->db->fetch_array($result)) {
                $arr_mark[$r['mark_id']] = $r;
            }
            $this->write('mark-'.$mark_column.'.php', $arr_mark);
            return $arr_mark;
        } else {
            $arr_mark_column = array();
            $sql = "SELECT mark_column FROM {$this->tb_marks} WHERE mark_column!='' AND mark_cache=1 ORDER BY mark_id DESC";
            $result = $this->db->get_all($sql);
            while($r = $this->db->fetch_array($result)) {
                if(in_array($r['mark_column'], $arr_mark_column)) continue;
                $arr_mark_column[] = $r['mark_column'];
                $this->mark($r['mark_column']);
            }
        }
    }
    public function keywords_link($kl_mark = '') {
        if($kl_mark) {
            $arr_keywords_link = array();
            $sql = "SELECT kl_title,kl_url FROM {$this->tb_keywords_link} WHERE kl_mark='$kl_mark' ORDER BY kl_order DESC,kl_id DESC";
            $result = $this->db->get_all($sql);
            while($r = $this->db->fetch_array($result)) {
                $arr_keywords_link[] = $r;
            }
            $this->write('keywords_link-'.$kl_mark.'.php', $arr_keywords_link);
        } else {
            $arr_kl_mark = array();
            $sql = "SELECT kl_mark FROM {$this->tb_keywords_link}";
            $result = $this->db->get_all($sql);
            while($r = $this->db->fetch_array($result)) {
                if(in_array($r['kl_mark'], $arr_kl_mark)) continue;
                $arr_kl_mark[] = $r['kl_mark'];
                $this->keywords_link($r['kl_mark']);
            }
        }
    }
    public function ban_word() {
        $arr_ban_word = array();
        $sql = "SELECT search_word,replace_word,is_ban FROM {$this->tb_ban_word} ORDER BY word_id DESC";
        $result = $this->db->get_all($sql);
        while($r = $this->db->fetch_array($result)) {
            $arr_ban_word[] = $r;
        }
        $this->write('ban_words.php', $arr_ban_word);
    }
    public function read($file_name, $dir = '') {
        $file_name = $dir ? HL_FILE_CACHE.'/'.$this->tty.'/'.$dir.'/'.$file_name : HL_FILE_CACHE.'/'.$this->tty.'/'.$file_name;
        if(!is_file($file_name)) return array();
        $file_name = include($file_name);
        return $file_name;
    }
    public function delete($file_name, $dir = ''){
        $file_name = $dir ? HL_FILE_CACHE.'/'.$this->tty.'/'.$dir.'/'.$file_name : HL_FILE_CACHE.'/'.$this->tty.'/'.$file_name;
        return \Common\FileSystem::file_delete($file_name);
    }
    public function clear($str, $type = '', $dir = '') {
        $dir = $dir ? HL_FILE_CACHE.'/'.$this->tty.'/'.$dir.'/' : HL_FILE_CACHE.'/'.$this->tty.'/';
        $files = glob($dir.'*');
        if(is_array($files)) {
            if($type == 'dir') {
                foreach($files as $file) {
                    if(is_dir($file)) {\Common\FileSystem::dir_delete($file);} else {if(\Common\FileSystem::file_ext($file) == $str) $this->delete($file);}
                }
            } else {
                foreach($files as $file) {
                    if(!is_dir($file) && strpos(basename($file), $str) !== false) $this->delete($file);
                }
            }
        }
    }

    public function item_set($type) {
        $arr_item_set = array();
        $sql = "SELECT item_key,item_val FROM {$this->tb_item_set}  WHERE item_type='$type'";
        $result = $this->db->get_all($sql);
        while($r = $this->db->fetch_array($result)) {
            $arr_item_set[$r['item_key']] = $r['item_val'];
        }
        $this->write($type.'-item_set.php', $arr_item_set);
    }

    public function struct_data($arr_category = array(), $tb) {
        $this->tb_category =  $tb;
        if(!$arr_category) {
            $sql = "SELECT category_id,category_name,category_url,category_position,category_parent_id,category_parent_ids,category_is_child,category_child_ids FROM {$this->tb_category}  ORDER BY category_order,category_id";
            $result = $this->db->get_all($sql);
            while($r = $this->db->fetch_array($result)) {
                $arr_category[$r['category_id']] = $r;
            }
        }
        $this->write($tb.'-data.php', $arr_category);
    }

    public function thumbnail_width_category($arr_thumbnail_width_category = array()) {
        $this->tb_thumbnail_width_category =  $this->tb_pre.'pc_thumbnail_width_category';
        if(!$arr_thumbnail_width_category) {
            $result = $this->db->get_all("SELECT thumbnail_width_category_id,thumbnail_width_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_thumbnail_width_category}  ORDER BY sort_order,thumbnail_width_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_thumbnail_width_category[$r['thumbnail_width_category_id']] = $r;
            }
        }
        $this->write('thumbnail_width_category.php', $arr_thumbnail_width_category);
    }
    public function thumbnail_height_category($arr_thumbnail_height_category = array()) {
        $this->tb_thumbnail_height_category =  $this->tb_pre.'pc_thumbnail_height_category';
        if(!$arr_thumbnail_height_category) {
            $result = $this->db->get_all("SELECT thumbnail_height_category_id,thumbnail_height_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_thumbnail_height_category}  ORDER BY sort_order,thumbnail_height_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_thumbnail_height_category[$r['thumbnail_height_category_id']] = $r;
            }
        }
        $this->write('thumbnail_height_category.php', $arr_thumbnail_height_category);
    }

    public function icon_width_category($arr_icon_width_category = array()) {
        $this->tb_icon_width_category =  $this->tb_pre.'pc_icon_width_category';
        if(!$arr_icon_width_category) {
            $result = $this->db->get_all("SELECT icon_width_category_id,icon_width_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_icon_width_category}  ORDER BY sort_order,icon_width_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_icon_width_category[$r['icon_width_category_id']] = $r;
            }
        }
        $this->write('icon_width_category.php', $arr_icon_width_category);
    }
    public function icon_height_category($arr_icon_height_category = array()) {
        $this->tb_icon_height_category =  $this->tb_pre.'pc_icon_height_category';
        if(!$arr_icon_height_category) {
            $result = $this->db->get_all("SELECT icon_height_category_id,icon_height_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_icon_height_category}  ORDER BY sort_order,icon_height_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_icon_height_category[$r['icon_height_category_id']] = $r;
            }
        }
        $this->write('icon_height_category.php', $arr_icon_height_category);
    }
    public function scroll_width_category($arr_scroll_width_category = array()) {
        $this->tb_scroll_width_category =  $this->tb_pre.'pc_scroll_width_category';
        if(!$arr_scroll_width_category) {
            $result = $this->db->get_all("SELECT scroll_width_category_id,scroll_width_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_scroll_width_category}  ORDER BY sort_order,scroll_width_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_scroll_width_category[$r['scroll_width_category_id']] = $r;
            }
        }
        $this->write('scroll_width_category.php', $arr_scroll_width_category);
    }
    public function scroll_height_category($arr_scroll_height_category = array()) {
        $this->tb_scroll_height_category =  $this->tb_pre.'pc_scroll_height_category';
        if(!$arr_scroll_height_category) {
            $result = $this->db->get_all("SELECT scroll_height_category_id,scroll_height_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_scroll_height_category}  ORDER BY sort_order,scroll_height_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_scroll_height_category[$r['scroll_height_category_id']] = $r;
            }
        }
        $this->write('scroll_height_category.php', $arr_scroll_height_category);
    }

    public function logo_width_category($arr_logo_width_category = array()) {
        $this->tb_logo_width_category =  $this->tb_pre.'pc_logo_width_category';
        if(!$arr_logo_width_category) {
            $result = $this->db->get_all("SELECT logo_width_category_id,logo_width_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_logo_width_category}  ORDER BY sort_order,logo_width_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_logo_width_category[$r['logo_width_category_id']] = $r;
            }
        }
        $this->write('logo_width_category.php', $arr_logo_width_category);
    }
    public function logo_height_category($arr_logo_height_category = array()) {
        $this->tb_logo_height_category =  $this->tb_pre.'pc_logo_height_category';
        if(!$arr_logo_height_category) {
            $result = $this->db->get_all("SELECT logo_height_category_id,logo_height_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_logo_height_category}  ORDER BY sort_order,logo_height_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_logo_height_category[$r['logo_height_category_id']] = $r;
            }
        }
        $this->write('logo_height_category.php', $arr_logo_height_category);
    }

    public function text_size_category($arr_text_size_category = array()) {
        $this->tb_text_size_category =  $this->tb_pre.'pc_text_size_category';
        if(!$arr_text_size_category) {
            $result = $this->db->get_all("SELECT text_size_category_id,text_size_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_text_size_category}  ORDER BY sort_order,text_size_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_text_size_category[$r['text_size_category_id']] = $r;
            }
        }
        $this->write('text_size_category.php', $arr_text_size_category);
    }
    public function text_padding_category($arr_text_padding_category = array()) {
        $this->tb_text_padding_category =  $this->tb_pre.'pc_text_padding_category';
        if(!$arr_text_padding_category) {
            $result = $this->db->get_all("SELECT text_padding_category_id,text_padding_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_text_padding_category}  ORDER BY sort_order,text_padding_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_text_padding_category[$r['text_padding_category_id']] = $r;
            }
        }
        $this->write('text_padding_category.php', $arr_text_padding_category);
    }
    public function text_line_height_category($arr_text_line_height_category = array()) {
        $this->tb_text_line_height_category =  $this->tb_pre.'pc_text_line_height_category';
        if(!$arr_text_line_height_category) {
            $result = $this->db->get_all("SELECT text_line_height_category_id,text_line_height_category_name,parent_id,parent_ids,is_child,child_ids FROM {$this->tb_text_line_height_category}  ORDER BY sort_order,text_line_height_category_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_text_line_height_category[$r['text_line_height_category_id']] = $r;
            }
        }
        $this->write('text_line_height_category.php', $arr_text_line_height_category);
    }

    public function struct_animation($arr_struct_animation = array()) {
        $this->tb_struct_animation =  $this->tb_pre.'pc_struct_animation';
        if(!$arr_struct_animation) {
            $result = $this->db->get_all("SELECT struct_animation_id,struct_animation_name,struct_animation_file FROM {$this->tb_struct_animation}  ORDER BY listorder,struct_animation_id");
            while($r = $this->db->fetch_array($result)) {
                $arr_struct_animation[$r['struct_animation_id']] = $r;
            }
        }
        $this->write('struct_animation.php', $arr_struct_animation);
    }
}

<?php
/**
 * @package App\Controller\Model
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.27
 * @file Setting.php
 */
namespace App\Model\Setting;
use Common\Application;
use Common\Database\Proxy;
class Setting implements ISetting
{
    private $tb;
    private $proxy;
    function __construct()
    {
        $config = Application::getInstance();
        $this->tb = $config['table']['tb_pre']['pre'].$config['table']['tb_name']['config'];
        $this->proxy = new Proxy();

    }
    function get($config_mark)
    {
        $config = array();
        $arr_seo = array('title_index', 'title_list', 'title_show', 'keywords_index', 'keywords_list', 'keywords_show','description_index', 'description_list', 'description_show');
        $result = $this->proxy->query("SELECT * FROM $this->tb WHERE config_mark='$config_mark'");
        while($r = $this->proxy->fetchArray($result)){
            $config[$r['config_key']] = $r['config_val'];
        }
        foreach($arr_seo as $v){
            $seo_v = 'seo_'.$v;
            if(isset($config[$seo_v])) $config[$v] = $this->seo($config[$seo_v]);
        }
        return $config;

    }
    function set($config_mark, $config = array())
    {
        if(!$config_mark || !$config) return false;
        $this->proxy->query("DELETE FROM $this->tb WHERE config_mark='$config_mark'");
        foreach($config as $k=>$v){
            if(is_array($v)) $v = implode(',', $v);
            $this->proxy->query("INSERT INTO $this->tb (config_mark,config_key,config_val) VALUES ('$config_mark','$k','$v')");
        }
        return true;
    }
    public function seo($title, $show = '')
    {
        $arr = array(
            'module_name'		=>	'模块名称',
            'page'				=>	'页码',
            'site_name'			=>	'网站名称',
            'site_title'		=>	'网站SEO标题',
            'site_keywords'		=>	'网站SEO关键词',
            'site_description'	=>	'网站SEO描述',
            'cat_name'			=>	'分类名称',
            'cat_title'			=>	'分类SEO标题',
            'cat_keywords'		=>	'分类SEO关键词',
            'cat_description'	=>	'分类SEO描述',
            'show_title'		=>	'内容标题',
            'show_introduce'	=>	'内容简介',
            'kw'				=>	'关键词',
            'area_name'			=>	'地区',
            'delimiter'			=>	'分隔符',
        );
        if(is_array($show)) {
            foreach($show as $v) {
                if(isset($arr[$v])) echo '<a href="javascript:_into(\''.$title.'\', \'{'.$arr[$v].'}\');" title="{'.$arr[$v].'}">{'.$arr[$v].'}</a>&nbsp;&nbsp;';
            }
        } else {
            foreach($arr as $k=>$v) {
                $title = str_replace($v, '$seo_'.$k, $title);
            }
            return $title;
        }
        return true;
    }
}
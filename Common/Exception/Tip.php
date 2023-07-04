<?php
/**
 * @package Common\Exception
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.11
 * @edit date 2022.03.27
 * @file Tip.php
 */
namespace Common\Exception;
class Tip
{
    private $msg;
    private $forward;
    private $time;
    private $core = array();
    private $ref;
    private $config;
    private $tpl;
    public function __construct(){
        global $tty,$CORE, $HL_REF,$CONFIG, $Tpl;
        $this->msg = HL_DEF_ERR_MSG;
        $this->forward = '';
        $this->time = 1;
        $this->core = $CORE;
        $this->ref = $HL_REF;
        $this->config = $CONFIG;
        if(!$Tpl){
            $this->tpl = new Tpl();
        }else{
            $this->tpl = &$Tpl;
        }

    }
    public function display($msg, $forward = 'back',$file = 'msg', $js_code = '', $time = 1){
        global $CORE;
        if($msg) $this->msg = $msg;
        include (IN_ADMIN) ? (HL_ADMIN_MODULE.'/core/'.$this->tty.'/tpl/notice.tpl.php') : $this->tpl->get($file, 'msg');
        exit;
    }
    public function display_factory($msg, $forward = 'back', $time = 1){
        if($msg) $this->msg = $msg;
        include(HL_ADMIN_MODULE.'/core/tpl/notice.tpl.php');
        exit;
    }
    public  function location($forward){
        if($forward) $this->forward = $forward;
        if(!defined('HL_ADMIN') && $this->core['reload_time']) sleep($this->core['reload_time']);
        exit(header('location:'.$this->forward));
    }

    public function back(){
        if($this->ref){
            exit(header('location:'.$this->ref));
        }else{
            $file = defined('IN_ADMIN') ? HL_PATH.$this->config['admin_url'] : HL_PATH;
            exit(header('location:'.$file));
        }
    }
    public function ex_msg($msg = '', $forward = '') {
        if(!$msg && !$forward) {
            $msg = get_cookies('exmsg');
            if($msg) {
                echo '<script type="text/javascript">exNotice(\''.$msg.'\', 5, exMsg);</script>';
                set_cookies('exmsg', '');
            }
        } else {
            set_cookies('exmsg', $msg);
            $forward = preg_replace("/(.*)([&?]rand=[0-9]*)(.*)/i", "\\1\\3", $forward);
            $forward = str_replace('.php&', '.php?', $forward);
            $forward = strpos($forward, '?') === false ? $forward.'?rand='.mt_rand(10, 99) : str_replace('?', '?rand='.mt_rand(10, 99).'&', $forward);
            base_header($forward);
        }
    }
    function dialog($content) {
        include HL_ADMIN_MODULE.'/core/'.$this->tty.'/tpl/dialog.tpl.php';
        exit;
    }
}
<?php
/*
 * @package HuaLang.site.
 * @copyright(c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.29
 * @id core.php
 * */
//define constant switch for safety
const GATE = true;
//define root directory
define('HL_ROOT', substr(str_replace("\\", '/', __DIR__), 0, -7));

//define framework directory as HL_CORE,HL_APP...
const HL_CORE = HL_ROOT.'/Common';
const HL_APP_DIR = HL_ROOT.'/App';
const HL_APP_CONTROLLER_DIR = HL_ROOT.'/App/Controller';
const HL_APP_Model_DIR = HL_ROOT.'/App/Model';
const HL_APP_Views_DIR = HL_ROOT.'/App/Views';
const HL_APP = '\\App';
const HL_APP_CONTROLLER = '\\App\\Controller';
const HL_APP_Model = '\\App\\Model';
const HL_APP_View = '\\App\\View';

//set HL_DEBUG
const HL_DEBUG = true;
HL_DEBUG ? ini_set('display_errors', 'On') : ini_set('display_errors', 'Off');

//import basic functions of the framework as chars and base respectively
require(HL_CORE.'/Lib/chars.func.php');
require(HL_CORE.'/Lib/base.func.php');

//set web site auto load
require(HL_CORE.'/Loader.php');
spl_autoload_register('\Common\Loader::autoload_class');

//auto load configuration file
$config = Common\Factory\Factory::getConfig();
$language = Common\Factory\Factory::getConfig('language/zh_cn/pc');

//auto load constant definition file
require(HL_CORE.'/Constant/define.php');

header("Content-Type:text/html;charset=HL_CHARSET");

//automatically load framework class
require(HL_CORE.'/Framework.php');
\Common\Framework::run();


//var_dump($language['common']);
//set time_zone


//set up program environment
$HL_QST = isset($_SERVER['QUERY_STRING']) ? addslashes($_SERVER['QUERY_STRING']) : '';


$HL_URL = Common\Env::getUrl();
$HL_REF = Common\Env::getRef();
$HL_ROBOT = Common\Env::getRobot();

//Disable abnormal IP
if(Common\Safety\BanIP::checkIP()) exit(Common\Safety\BanIP::getBan());

if(defined('HL_DEBUG')) $debug_start_time = debug_time();

//Perform security checks on POST,GET,COOKIE,SERVER variables
Common\Safety\Safety::check();
if(Common\Safety\Safety::checkPOST()) $_POST = Common\Safety\Safety::getPOST();
if(Common\Safety\Safety::checkGET()) $_GET = Common\Safety\Safety::getGET();
if(Common\Safety\Safety::checkCOOKIE()) $_COOKIE = Common\Safety\Safety::getCOOKIE();
if(Common\Safety\Safety::checkREQUEST_URI()) $_SERVER['REQUEST_URI'] = Common\Safety\Safety::getREQUEST_URI();

extract($_POST, EXTR_SKIP);
//var_dump($_POST);exit;
extract($_GET, EXTR_SKIP);
//set spm
if(isset($spm)) Common\Variable\Spm::init($spm);

Common\Auth\Auth::init();

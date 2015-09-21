<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: commons.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
function get_runtime($start,$end='') {
	static $_ps_time = array();
	if(!empty($end)) {
		if(!isset($_ps_time[$end])) {
			$mtime = explode(' ', microtime());
		}
		return number_format(($mtime[1] + $mtime[0] - $_ps_time[$start]), 6);
	}else{
		$mtime = explode(' ', microtime());
		$_ps_time[$start] = $mtime[1] + $mtime[0];
	}
}
get_runtime('start');
session_start();
$C = $settings = $sysmsg = array();
if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	define('LF',"\r\n");
}else{
	define('LF',"\n");
}
define('NOW_YEAR','2014');
define('PHPDISK_ROOT', substr(dirname(__FILE__), 0, -8));
define('PD_PLUGINS_DIR',PHPDISK_ROOT.'plugins/');
define('IN_PHPDISK',TRUE);
define('SERVER_NAME',$_SERVER['SERVER_NAME']);

if(function_exists('date_default_timezone_set')){
	@date_default_timezone_set('Asia/Shanghai');
}
$timestamp = time();
define('TS',$timestamp);
@set_magic_quotes_runtime(0);

$installed_file = PHPDISK_ROOT.'system/install.lock';
if(!file_exists($installed_file)){
	header("Location: ./install/index.php");
	exit;
}

$config_file = PHPDISK_ROOT.'system/configs.inc.php';
if(!file_exists($config_file)){
	header("Location: ./install/index.php");
	exit;
}else{
	require($config_file);
}
$tpf = $configs['tpf'];
// for debug;
$C['set']['debug'] = $configs['debug'];
define('DEBUG',$C['set']['debug'] ? true : false);
if(DEBUG){
	error_reporting(E_ALL ^ E_NOTICE);
	@ini_set('display_errors', 'On');
}else{
	error_reporting(0);
	@ini_set('display_errors', 'Off');
}

$charset = $configs['charset'];
$charset_arr = array('gbk' => 'gbk','utf-8' => 'utf8');
$db_charset = $charset_arr[strtolower($configs['charset'])];
header("Content-Type: text/html; charset=$charset");

require_once PHPDISK_ROOT.'includes/core/core.phpdisk.php';

phpdisk_core::init_core();
$db = phpdisk_core::init_db_connect();
$setting_file = PHPDISK_ROOT.'system/settings.inc.php';
file_exists($setting_file) ? require_once $setting_file : settings_cache();

//init base env
require_once PHPDISK_ROOT.'system/adminset.inc.php';

$file = PHPDISK_ROOT.'system/global/plugin_settings.inc.php';
file_exists($file) ? require_once $file : plugin_cache();
$file = PHPDISK_ROOT.'system/global/group_settings.inc.php';
file_exists($file) ? require_once $file : group_settings_cache();
$file = PHPDISK_ROOT.'system/global/stats.inc.php';
file_exists($file) ? require_once $file : stats_cache();
unset($file);
// debug
$settings[open_cache] = 1;//(int)$settings[open_cache];
//
require(PHPDISK_ROOT.'includes/class/cache_file.class.php');

$C['gz']['open'] = $settings['gzipcompress'];
phpdisk_core::gzcompress_open();
$arr = phpdisk_core::init_lang_tpl();
$user_tpl_dir = $arr['user_tpl_dir'];
$admin_tpl_dir = $arr['admin_tpl_dir'];
$auth[is_fms] = $arr['fms'];

$C['lang_type'] = $arr['lang_name'];
if($settings[open_switch_tpls]){
	$tpl_sw = select_tpl();
}
if($settings[open_switch_langs]){
	$langs_sw = select_lang();
	$plang = gpc('lang','C','');
	$C['lang_type'] = $plang ? (check_lang($plang) ? $plang : $C['lang_type']) : $C['lang_type'];
}

require PHPDISK_ROOT.'includes/lib/php-gettext/gettext.inc.php';

_setlocale(LC_MESSAGES, $C['lang_type']);
_bindtextdomain('phpdisk', 'languages');
_bind_textdomain_codeset('phpdisk', $charset);
_textdomain('phpdisk');

$ads_cache = PHPDISK_ROOT.'system/global/ads.cache.php';
if(file_exists($ads_cache)){
	require_once($ads_cache);
}else{
	ads_cache();
}
load_active_plugins();

if(!@get_magic_quotes_gpc()){
	$_GET = addslashes_array($_GET);
	$_POST = addslashes_array($_POST);
	$_COOKIE = addslashes_array($_COOKIE);
}

$str = strrchr($_SERVER['SCRIPT_NAME'],'/');
$curr_script = substr($str,1,strlen($str)-5);
if(in_array($curr_script,array('account','search','hotfile','public'))){
	include_once(PHPDISK_ROOT.'includes/dosafe.php');
}

list($pd_uid,$pd_gid,$pd_username,$pd_pwd,$pd_email) = gpc('phpdisk_zcore_info','C','') ? explode("\t", pd_encode(gpc('phpdisk_zcore_info','C',''), 'DECODE')) : array('', '', '','','');
$pd_uid = (int)$pd_uid;
if(!$pd_uid || !$pd_pwd){
	$pd_uid = 0;
}else{
	$userinfo = $db->fetch_one_array("select userid,u.gid,username,password,email,group_name from {$tpf}users u,{$tpf}groups g where username='$pd_username' and password='$pd_pwd' and u.gid=g.gid limit 1");
	if($userinfo){
		$pd_username = $userinfo['username'];
		$pd_email = $userinfo['email'];
		$pd_gid = $userinfo['gid'];
		$pd_group_name = $userinfo['group_name'];
	}else{
		$pd_uid = 0;
		$pd_pwd = '';
		pd_setcookie('phpdisk_zcore_info', '');
	}
}
unset($userinfo);
if($pd_uid){
	$myinfo = get_profile($pd_uid);
}
if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
	define('P_W','admincp');
	$uc_conf = PD_PLUGINS_DIR.'api/uc_configs.inc.php';
	file_exists($uc_conf) ? require_once $uc_conf : exit(__('not_uc_conf').$uc_conf);
	$uc_client = $settings['connect_uc_type']=='phpwind' ? PD_PLUGINS_DIR.'api/pw_client/uc_client.php' : PD_PLUGINS_DIR.'api/uc_client/client.php';
	file_exists($uc_client) ? require_once $uc_client : exit(__('not_uc_client').$uc_client);
}

$news_url = $auth['com_news_url'] ? $auth['com_news_url'] : 'http://www.google.com/m_news/m_idx.php';
$upgrade_url = $auth['com_upgrade_url'] ? $auth['com_upgrade_url'] : 'http://www.google.com/autoupdate/last_version_x2.php';

$onlineip = get_ip();

$pg = (int)gpc('pg','G',0);
!$pg &&	$pg = 1;
$perpage = $C['set']['perpage'] ? (int)$C['set']['perpage'] : 20;

$error = false;
$item = trim(gpc('item','GP','',1));
$app = trim(gpc('app','GP','',1));
$action = trim(gpc('action','GP','',1));
$task = trim(gpc('task','GP','',1));
$menu = trim(gpc('menu','GP','',1));
$p_formhash = trim(gpc('formhash','P',''));

$formhash = formhash();

$sess_id = random(32);
$income_type_arr = array('alipay'=>__('alipay'),'tenpay'=>__('tenpay'));

if(!defined('ADMINCP')){
	define('ADMINCP','admincp');
}
$day_arr = array(7=>__('one_week'),15=>__('half_month'),30=>__('one_month'),60=>__('two_month'),90=>__('three_month'),180=>__('half_year'),365=>__('one_year'));
$payment_arr = array('mywealth'=>__('mywealth'),'alipay'=>__('alipay'),'tenpay'=>__('tenpay'),'chinabank'=>__('chinabank'),'yeepay'=>__('yeepay'));
$ca_arr = array('download'=>__('ca_download'),'ref'=>__('ca_ref'),'view'=>'点击');
$my_sid = session_id();

?>
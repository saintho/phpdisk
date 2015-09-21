<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: commons.inc.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
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
$C = $L = $settings = $sysmsg = array();
if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	define('LF',"\r\n");
}else{
	define('LF',"\n");
}
define('NOW_YEAR','2012');
define('PHPDISK_ROOT', substr(dirname(__FILE__), 0, -8));
define('PD_PLUGINS_DIR',PHPDISK_ROOT.'plugins/');
define('IN_PHPDISK',TRUE);
define('SERVER_NAME',$_SERVER['SERVER_NAME']);

if(function_exists('date_default_timezone_set')){
	@date_default_timezone_set('Asia/Shanghai');
}
$C['timestamp'] = $timestamp = time();
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

$arr = array('global','plugin','cache','image','core');
for ($i=0;$i<count($arr);$i++){
	require(PHPDISK_ROOT.'includes/function/'.$arr[$i].'.func.php');
}
$arr = array('core','mysql');
for ($i=0;$i<count($arr);$i++){
	require(PHPDISK_ROOT.'includes/class/'.$arr[$i].'.class.php');
}

require PHPDISK_ROOT.'includes/phpdisk_version.inc.php';

$C['gz']['open'] = $settings['gzipcompress'];
phpdisk_core::gzcompress_open();
$db = phpdisk_core::init_db_connect();
$setting_file = PHPDISK_ROOT.'system/settings.inc.php';
file_exists($setting_file) ? require_once $setting_file : settings_cache();
$arr = phpdisk_core::init_lang_tpl();
$user_tpl_dir = 'templates/default/';
$admin_tpl_dir = $arr['admin_tpl_dir'];
$C['lang_type'] = $arr['lang_name'];

require PHPDISK_ROOT.'includes/lib/php-gettext/gettext.inc.php';

_setlocale(LC_MESSAGES, $C['lang_type']);
_bindtextdomain('phpdisk', 'languages');
_bind_textdomain_codeset('phpdisk', $charset);
_textdomain('phpdisk');

if(!@get_magic_quotes_gpc()){
	$_GET = addslashes_array($_GET);
	$_POST = addslashes_array($_POST);
	$_COOKIE = addslashes_array($_COOKIE);
}

$group_settings_file = PHPDISK_ROOT.'system/global/group_settings.inc.php';
file_exists($group_settings_file) ? require_once $group_settings_file : group_settings_cache();

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

$news_url = $auth['com_news_url'] ? $auth['com_news_url'] : 'http://www.phpdisk.com/m_news/m_idx.php';
$upgrade_url = $auth['com_upgrade_url'] ? $auth['com_upgrade_url'] : 'http://www.phpdisk.com/autoupdate/last_version_x2.php';

$onlineip = get_ip();

$pg = (int)gpc('pg','G',0);
!$pg &&	$pg = 1;
$perpage = $C['set']['perpage'] ? (int)$C['set']['perpage'] : 20;

$error = false;
$item = trim(gpc('item','GP',''));
$app = trim(gpc('app','GP',''));
$action = trim(gpc('action','GP',''));
$task = trim(gpc('task','GP',''));
$p_formhash = trim(gpc('formhash','P',''));

$formhash = formhash();

$sess_id = random(32);

?>
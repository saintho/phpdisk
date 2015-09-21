<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: core.class.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

class phpdisk_core{
	public static function init_core(){
		phpdisk_core::__init_env();
	}
	public static function init_db_connect(){
		global $C,$configs;
		if(empty($C['dbc'])){
			$C['dbc'] = new cls_mysql();
			$C['dbc']->connect($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['dbname'],$configs['pconnect']);
			unset($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['pconnect']);
		}
		return $C['dbc'];
	}
	public static function __init_env(){
		$env_arr = array('system/','system/global/','system/cache/','system/plugins/','system/templates/');
		for ($i=0;$i<count($env_arr);$i++){
			if(!is_dir(PHPDISK_ROOT.$env_arr[$i])){
				mkdir(PHPDISK_ROOT.$env_arr[$i],0777);
				write_file(PHPDISK_ROOT.$env_arr[$i].'index.htm','PHPDisk');
			}
		}
	}
	public static function gzcompress_open(){
		global $C;
		if ($C['gz']['open'] && function_exists('ob_gzhandler')) {
			ob_start('ob_gzhandler');
			$C['gz']['status'] = 'Enabled';
		} else {
			ob_start();
			$C['gz']['status'] = 'Disabled';
		}
	}
	public static function init_lang_tpl(){
		global $C,$settings,$auth;
		$dir = PHPDISK_ROOT.'system/global/';
		make_dir($dir);
		$file = $dir.'lang_settings.inc.php';
		file_exists($file) ? require_once $file : lang_cache();
		$file = $dir.'tpl_settings.inc.php';
		file_exists($file) ? require_once $file : tpl_cache();

		if(count($tpl_settings)){
			foreach($tpl_settings as $v){
				if($v[actived] && $v[tpl_type]=='user'){
					$user_tpl_dir = $v[tpl_name];
				}
				if($v[actived] && $v[tpl_type]=='admin'){
					$admin_tpl_dir = $v[tpl_name];
				}
			}
		}
		if(count($lang_settings)){
			foreach($lang_settings as $v){
				if($v[actived]){
					$lang_name = $v[lang_name];
				}
			}
		}
		if($settings[open_switch_tpls]){
			$ptpl = gpc('ptpl','C','');
			$user_tpl_dir = $C[tpl_name] = $ptpl ? (check_template($ptpl) ? $ptpl : $user_tpl_dir) : $user_tpl_dir;
			//$C[tpl_name] = $user_tpl_dir;
		}
		$arr = get_template_info($user_tpl_dir);
		$is_fms = ($arr['template_core']=='fms' && $auth[open_fms]) ? 1 : 0;

		$user_tpl_dir = $user_tpl_dir ? "templates/$user_tpl_dir/" : 'templates/default/';
		$admin_tpl_dir = $admin_tpl_dir ? "templates/$admin_tpl_dir/" : 'templates/admin/';
		$lang_name = $lang_name ? $lang_name : 'zh_cn';

		return array('user_tpl_dir'=>$user_tpl_dir,'admin_tpl_dir'=>$admin_tpl_dir,'lang_name'=>$lang_name,'fms'=>$is_fms);
	}
	public static function user_login($exit=1){
		global $pd_uid,$pd_pwd;
		if(!$pd_uid || !$pd_pwd){
			header("Location: ".urr("account","action=login&ref=".$_SERVER['REQUEST_URI']));
			if($exit){
				exit;
			}
		}
	}
	public static function admin_login(){
		global $C,$db,$tpf,$pd_uid,$pd_pwd,$pd_gid;
		$admin_not_login =0;
		$rs = $db->fetch_one_array("select * from {$tpf}adminsession where userid='$pd_uid' limit 1");
		if(!$_SESSION['pd_sid'] || $rs['hashcode'] != $_SESSION['pd_sid']){
			$admin_not_login =1;
		}
		unset($rs);
		if(!$pd_uid || !$pd_pwd || $pd_gid !=1 || $admin_not_login){
			header("Location: ".urr("account","action=adminlogin&ref=".$_SERVER['REQUEST_URI']));
			exit;
		}
	}

}

?>
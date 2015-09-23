<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: plugin.func.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}

function load_active_plugins(){
	global $db,$tpf;
	$q = $db->query("select plugin_name from {$tpf}plugins where actived=1");
	while($rs = $db->fetch_array($q)){
		$str .= $rs['plugin_name'].',';
	}
	$db->free($q);
	unset($rs);
	$arr = explode(',',substr($str,0,-1));

	$dirs = @scandir(PD_PLUGINS_DIR);
	for($i=0;$i<count($dirs);$i++){
		$dir[$i] = PD_PLUGINS_DIR.$dirs[$i].'/';
		if(is_dir($dir[$i]) && $dirs[$i] !='.' && $dirs[$i] !='..' && in_array($dirs[$i],$arr)){
			if(file_exists($dir[$i]."/install.lock")){
				include_once $dir[$i].'./functions.inc.php';
			}
		}
	}
}
function get_plugin_info($plugin){
	global $db,$tpf;
	$file = PD_PLUGINS_DIR."$plugin/plugin_info.php";
	if(file_exists($file)){
		$_data = read_file($file);
		preg_match("/Plugin Name:(.*)/i",$_data,$plugin_name);
		preg_match("/Plugin URL:(.*)/i",$_data,$plugin_url);
		preg_match("/Description:(.*)/i",$_data,$plugin_desc);
		preg_match("/Author:(.*)/i",$_data,$plugin_author);
		preg_match("/Author Site:(.*)/i",$_data,$plugin_site);
		preg_match("/Version:(.*)/i",$_data,$plugin_version);
		preg_match("/PHPDISK Core:(.*)/i",$_data,$phpdisk_core);
	}
	if(file_exists(PD_PLUGINS_DIR."$plugin/admin.inc.php")){
		$admin_url = urr(ADMINCP,"item=plugins&app=$plugin");
	}
	$actived = (int)@$db->result_first("select actived from {$tpf}plugins where plugin_name='$plugin' limit 1");
	$installed = file_exists(PD_PLUGINS_DIR."$plugin/install.lock") ? 1 : 0;
	$arr = array(
	'plugin_name' => trim($plugin_name[1]),
	'plugin_url' => trim($plugin_url[1]),
	'plugin_desc' => htmlspecialchars(trim($plugin_desc[1])),
	'plugin_author' => trim($plugin_author[1]),
	'plugin_site' => trim($plugin_site[1]),
	'plugin_version' => trim($plugin_version[1]),
	'phpdisk_core' => trim($phpdisk_core[1]),
	'admin_url' => trim($admin_url),
	'plugin_dir' => trim($plugin),
	'actived' => $actived,
	'installed' => $installed,
	);
	return $arr;
}
function display_plugin($plugin_name,$func,$param ='',$echo =1){
	global $db,$tpf;
	if(file_exists(PD_PLUGINS_DIR.$plugin_name.'/plugin_info.php')){
		$plugin_name = $db->escape(trim($plugin_name));
		$actived = @$db->result_first("select actived from {$tpf}plugins where plugin_name='$plugin_name'");
		if($actived){
			if($echo){
				if(function_exists($func)){
					call_user_func($func,$param);
				}else{
					echo $param;
				}
			}else{
				return function_exists($func) && $param;
			}
		}else{
			echo "";
		}
	}else{
		return false;
	}
}
function check_plugin_active_status($plugin){
	global $db,$tpf,$L;
	$actived = (int)@$db->result_first("select actived from {$tpf}plugins where plugin_name='$plugin'");
	if(!$actived){
		exit($L['plugin_not_active']);
	}
}
function check_plugin($plugin_name){
	$dir = PD_PLUGINS_DIR.$plugin_name.'/';
	if(file_exists($dir.'./plugin_info.php') && substr($plugin_name,0,1) !='.'){
		$rtn = 1;
	}else{
		$rtn = 0;
	}
	return $rtn;
}
function update_action_time($app){
	global $configs,$db,$tpf,$timestamp;
	$db->query_unbuffered("update `{$configs['dbname']}`.{$tpf}plugins set action_time='$timestamp' where plugin_name='$app' limit 1");
}
function get_name($plugin_name,$admin_url,$actived,$target='_self'){
	if($admin_url && $actived){
		$str = "<a href=\"{$admin_url}\" target=\"$target\">$plugin_name</a>";
	}else{
		$str = $plugin_name;
	}
	return $str;
}
function get_all_plugins_count($val='all'){
	global $db,$tpf;
	switch($val){
		case 'actived':
			$num = (int)@$db->result_first("select count(*) from {$tpf}plugins where actived=1");
			break;
		case 'inactived':
			$num = (int)@$db->result_first("select count(*) from {$tpf}plugins where actived=0");
			break;
		default:
			$num = (int)@$db->result_first("select count(*) from {$tpf}plugins");
	}
	return $num;
}
function syn_plugins(){
	global $db,$tpf;
	$dirs = scandir(PD_PLUGINS_DIR);
	sort($dirs);
	for($i=0;$i<count($dirs);$i++){
		if(check_plugin($dirs[$i])){
			$arr[] = $dirs[$i];
		}
	}
	if(count($arr)){
		$q = $db->query("select * from {$tpf}plugins where actived=1");
		while($rs = $db->fetch_array($q)){
			if(check_plugin($rs['plugin_name'])){
				$active_plugins .= $rs['plugin_name'].',';
				$active_time[$rs['plugin_name']] = $rs['action_time'];
				$plugin_in_shortcut[$rs['plugin_name']] = $rs['in_shortcut'];
			}
		}
		$db->free($q);
		unset($rs);
		if(trim(substr($active_plugins,0,-1))){
			$active_arr = explode(',',$active_plugins);
		}
		for($i=0;$i<count($arr);$i++){
			if(@in_array($arr[$i],$active_arr)){
				$sql_do .= "('".$db->escape($arr[$i])."','1','".$active_time[$arr[$i]]."','".$plugin_in_shortcut[$arr[$i]]."'),";
			}else{
				$sql_do .= "('".$db->escape($arr[$i])."','0','0','0'),";
			}
		}
		$sql_do = substr($sql_do,0,-1);
		$db->query_unbuffered("truncate table {$tpf}plugins;");
		$db->query_unbuffered("replace into {$tpf}plugins(plugin_name,actived,action_time,in_shortcut) values $sql_do ;");
		return true;
	}
}

?>
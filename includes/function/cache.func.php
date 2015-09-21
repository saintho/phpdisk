<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: cache.func.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}
function stats_cache($arr=0){
	global $db,$tpf;
	if(is_array($arr)){
		foreach($arr as $k => $v){
			$v = str_replace(array("'",'\\'),'',$v);
			$sqls .= "('$k','".$db->escape(trim($v))."'),";
		}
		$sqls = substr($sqls,0,-1);
		$db->query("replace into {$tpf}stats (vars,value) values $sqls;");
	}

	$q = $db->query("select * from {$tpf}stats order by vars ");
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'".$rs['vars']."' => '".$rs['value']."',".LF;
	}
	$db->free($q);
	unset($rs);

	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$stats = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;

	write_file(PHPDISK_ROOT."./system/global/stats.inc.php",$str);

}
function settings_cache($arr=0){
	global $db,$tpf,$configs,$settings;
	if(is_array($arr)){
		foreach($arr as $k => $v){
			$v = str_replace(array("'",'\\'),'',$v);
			$sqls .= "('$k','".$db->escape(trim($v))."'),";
		}
		$sqls = substr($sqls,0,-1);
		$db->query("replace into `{$configs['dbname']}`.{$tpf}settings (vars,value) values $sqls;");
	}
	$q = $db->query("select * from `{$configs['dbname']}`.{$tpf}settings order by vars ");
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'".$rs['vars']."' => '".$rs['value']."',".LF;
	}
	$db->free($q);
	unset($rs);

	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$settings = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;

	write_file(PHPDISK_ROOT."./system/settings.inc.php",$str);

}
function remote_server_url(){
	global $db,$tpf,$configs,$settings;
	if(display_plugin('multi_server','open_multi_server_plugin',$settings['open_multi_server'],0)){
		$rs = $db->fetch_one_array("select server_host,server_store_path,server_key from {$tpf}servers where server_id>1 order by is_default desc limit 1");
		if($rs){
			$remote_server_url = $rs['server_host'].'update_configs.php?code='.$rs[server_key];
		}
		unset($rs);
	}else{
		$remote_server_url = '';
	}
	return $remote_server_url;
}
function plugin_cache(){
	global $db,$tpf;
	$q = $db->query("select plugin_name,actived from {$tpf}plugins order by plugin_name");
	$str_c = '';
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'{$rs[plugin_name]}'=>array(".LF;
		$str_c .= "\t\t'plugin_name'=>'{$rs[plugin_name]}',".LF;
		$str_c .= "\t\t'actived'=>'{$rs[actived]}',".LF;
		$str_c .= "\t),".LF;
	}
	$db->free($q);
	unset($rs);

	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$plugin_settings = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;
	make_dir(PHPDISK_ROOT."./system/global");
	write_file(PHPDISK_ROOT."./system/global/plugin_settings.inc.php",$str);
}
function lang_cache(){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}langs order by lang_name");
	$str_c = '';
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'{$rs[lang_name]}'=>array(".LF;
		$str_c .= "\t\t'lang_name'=>'{$rs[lang_name]}',".LF;
		$str_c .= "\t\t'actived'=>'{$rs[actived]}',".LF;
		$str_c .= "\t),".LF;
	}
	$db->free($q);
	unset($rs);

	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$lang_settings = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;

	write_file(PHPDISK_ROOT."./system/global/lang_settings.inc.php",$str);
}
function tpl_cache(){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}templates order by tpl_name");
	$str_c = '';
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'{$rs[tpl_name]}'=>array(".LF;
		$str_c .= "\t\t'tpl_name'=>'{$rs[tpl_name]}',".LF;
		$str_c .= "\t\t'actived'=>'{$rs[actived]}',".LF;
		$str_c .= "\t\t'tpl_type'=>'{$rs[tpl_type]}',".LF;
		$str_c .= "\t),".LF;
	}
	$db->free($q);
	unset($rs);

	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$tpl_settings = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;

	write_file(PHPDISK_ROOT."./system/global/tpl_settings.inc.php",$str);
}
function group_settings_cache(){
	global $db,$tpf;

	$q = $db->query("select * from {$tpf}groups order by gid");
	while($rs = $db->fetch_array($q)){
		$str_c .= "\t'".$rs['gid']."' => array(".LF;
		$str_c .= "\t\t'max_messages' => '".$rs['max_messages']."',".LF;
		$str_c .= "\t\t'max_flow_down' => '".$rs['max_flow_down']."',".LF;
		$str_c .= "\t\t'max_flow_view' => '".$rs['max_flow_view']."',".LF;
		$str_c .= "\t\t'max_storage' => '".$rs['max_storage']."',".LF;
		$str_c .= "\t\t'max_filesize' => '".$rs['max_filesize']."',".LF;
		$str_c .= "\t\t'group_file_types' => '".$rs['group_file_types']."',".LF;
		$str_c .= "\t\t'max_folders' => '".$rs['max_folders']."',".LF;
		$str_c .= "\t\t'max_files' => '".$rs['max_files']."',".LF;
		$str_c .= "\t\t'can_share' => '".$rs['can_share']."',".LF;
		$str_c .= "\t\t'secs_loading' => '".$rs['secs_loading']."',".LF;
		$str_c .= "\t\t'server_ids' => '".$rs['server_ids']."',".LF;
		$str_c .= "\t),".LF.LF;

	}
	$db->free($q);
	unset($rs);

	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$group_settings = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;
	$str .= "?>".LF;

	write_file(PHPDISK_ROOT."./system/global/group_settings.inc.php",$str);
}
function update_seo($seo_type,$type_id,$title,$keywords,$description){
	global $db,$tpf;
	$ins = array(
	'seo_type'=>$seo_type,
	'type_id'=>$type_id,
	'title'=>seo_filter($title),
	'keywords'=>seo_filter($keywords),
	'description'=>seo_filter($description),
	);
	$id = @$db->result_first("select id from {$tpf}seo where seo_type='$seo_type' and type_id='$type_id'");
	if(!$id){
		$db->query_unbuffered("insert into {$tpf}seo set ".$db->sql_array($ins));
	}else{
		$db->query_unbuffered("update {$tpf}seo set ".$db->sql_array($ins)." where id='$id'");
	}
	seo_cache();
}
function seo_cache(){
	global $db,$tpf;
	$str_c = '';
	$q = $db->query("select * from {$tpf}seo order by id asc");
	while($rs = $db->fetch_array($q)){
		$str_c .= "\$seo_settings[{$rs[seo_type]}_{$rs[type_id]}] = array(".LF;
		$str_c .= "\t'title'=>'".addslashes($rs[title])."',".LF;
		$str_c .= "\t'keywords'=>'".addslashes($rs[keywords])."',".LF;
		$str_c .= "\t'description'=>'".addslashes($rs[description])."',".LF;
		$str_c .= ");".LF.LF;
	}
	$db->free($q);
	unset($rs);

	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= $str_c;
	$str .= "?>".LF;

	write_file(PHPDISK_ROOT."./system/global/seo_settings.inc.php",$str);
}

function ads_cache(){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}advertisements where is_hidden=0 order by advid asc");
	$ads = array();
	$str_c = '';
	while ($rs = $db->fetch_array($q)) {
		//$str_c .= "\t'".$rs['adv_position']."|".$rs[advid]."' => '".str_replace("'","\'",serialize($rs))."',".LF;
		$str_c .= "\$ads_cache_arr['".$rs['adv_position']."'][] = '".str_replace("'","\'",serialize($rs))."';".LF;
		$ads[] = $rs;
	}
	$db->free($q);
	unset($rs);
	
	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= $str_c;
	$str .= "?>".LF;
	$dir = PHPDISK_ROOT.'system/global/';
	make_dir($dir);
	write_file($dir.'ads.cache.php',$str);
}
?>
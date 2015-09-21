<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: admincp.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

phpdisk_core::admin_login();

define('IN_ADMINCP' ,true);

$menu = trim(gpc('menu','G',''));
$job = trim(gpc('job','G',''));
$menu = $menu ? $menu : '';
$item = $item ? $item : 'main';

if($job=='auth'){
	check_auth_domain('includes/core/core.post.php',1);
	exit;
}elseif($job=='auth_tpl'){
	$tpl_name = gpc('tpl_name','G','');
	if($tpl_name){
		check_auth_tpl('includes/core/core.post.php',$tpl_name);
	}
	exit;
}

if($menu =='plugin'){
	if($settings['open_plugins_last']){
		$q = $db->query("select * from {$tpf}plugins where actived=1 and action_time>0 order by action_time desc, plugin_name asc limit 10");
		while($rs = $db->fetch_array($q)){
			if(check_plugin($rs['plugin_name'])){
				$plugins_arr[] = get_plugin_info($rs['plugin_name']);
			}
		}
		$db->free($q);
		unset($rs);
	}
	if($settings['open_plugins_cp']){
		$q = $db->query("select * from {$tpf}plugins where actived=1 and in_shortcut=1 order by plugin_name asc");
		while($rs = $db->fetch_array($q)){
			if(check_plugin($rs['plugin_name'])){
				$s_plugins_arr[] = get_plugin_info($rs['plugin_name']);
			}
		}
		$db->free($q);
		unset($rs);
	}
}else{
	$q = $db->query("select * from {$tpf}cp_shortcut");
	$cs_menus = array();
	while($rs = $db->fetch_array($q)){
		$cs_menus[] = $rs;
	}
	$db->free($q);
	unset($rs);
}

require_once template_echo('adm_header',$admin_tpl_dir,'',1);
if($app && $item =='plugins'){
	$action_module = PHPDISK_ROOT."plugins/".$app."/admin.inc.php";
}else{
	$items = array('templates','database','main','settings','groups','users','files','cache','lang','plugins','email','advertisement','link','announce','navigation','seo','comment','report','verycode','union','sitemap','plans','nodes','domain','public','vip','tag','credit');
	if(in_array($item,$items)){
		$action_module = PHPDISK_ROOT.'admin/'.$item.'.inc.php';
	}else{
		echo "Error operation, system halt!";
		exit;
	}
}
admin_log();
require_once template_echo('admincp',$admin_tpl_dir,'',1);

$pageinfo = page_end_time();
require_once template_echo('adm_footer',$admin_tpl_dir,'',1);

include PHPDISK_ROOT."./includes/footer.inc.php";

function sitemap_tag($str){
	$str = rawurlencode($str);
	$url = base64_encode($_SERVER['QUERY_STRING']);
	$rtn = '&nbsp;<a href="'.urr(ADMINCP,"item=sitemap&action=add_shortcut&title=$str&url=$url").'" title="'.__('add_sitemap_tips').'">[+]</a>';
	echo $rtn;
}
function admin_log(){
	global $onlineip,$pd_username,$timestamp;
	$str = "<? exit; ?>$onlineip\t$pd_username\t".date('Y-m-d H:i:s').LF;
	$str .= "USER_AGENT:".$_SERVER['HTTP_USER_AGENT'].LF;
	$str .= "URI:".$_SERVER['REQUEST_URI'].LF;
	$str .= "POST:".LF;
	$str .= var_export($_POST,true).LF;
	$str .= "GET:".LF;
	$str .= var_export($_GET,true).LF;
	$str .= '|------------------------->>>'.LF;

	$dir = PHPDISK_ROOT.'system/admin_log/';
	make_dir($dir);
	$f = date('Ymd').'.php';
	if(file_exists($dir.$f)){
		write_file($dir.$f,$str,'ab');
	}else{
		write_file($dir.$f,$str);
	}
	foreach (glob($dir."*.php") as $filename) {
		if($timestamp-@filemtime($filename)> 86400*30){
			@unlink($filename);
		}
	}
}
?>



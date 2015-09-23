<?php




/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: index.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$in_front = true;

if($action=='set_default_tpl'){
	pd_setcookie('ptpl','default');
	settings_cache(array('open_switch_tpls'=>1));
	$db->query_unbuffered("update {$tpf}templates set actived=0 where tpl_type='user';");
	$db->query_unbuffered("update {$tpf}templates set actived=1 where tpl_name='default'");
	header('Location: '.$settings[phpdisk_url]);
	exit;
}
$title = $settings[site_title];
$seo = get_seo('index',0);
if($seo[title]){
	eval("\$title = \"$seo[title]\";");
}
eval("\$keywords = \"$seo[keywords]\";");
eval("\$description = \"$seo[description]\";");

include PHPDISK_ROOT."./includes/header.inc.php";

if(!$auth[is_fms]){
	$show_multi = false;
	if(in_array($curr_script,array('index'))){
		$ts = (int)gpc('ts','G',0);
		if($action=='multi'){
			$show_multi = true;
		}
	}
	$upload_remote = false;
	if($settings['open_multi_server']){
		$rs = $db->fetch_one_array("select server_host,server_store_path,server_key from {$tpf}servers where server_id>1 order by is_default desc limit 1");
		if($rs){
			$upload_remote = true;
			$upload_url = $rs['server_host'].'mydisk.php?item=upload&code='.pd_encode($rs['server_key']);
			if(in_array($curr_script,array('index'))){
				$upload_url2 = '&url='.base64_encode($settings[phpdisk_url].$script.'?action=multi&ts='.$timestamp);
			}
		}
		unset($rs);
	}
}

if($settings[open_switch_tpls]){
	$tpl = gpc('tpl','G','');
	$ref = gpc('ref','G','');
	$ref = $ref ? base64_decode($ref) : './';
	if($tpl){
		$num = @$db->result_first("select count(*) from {$tpf}templates where tpl_name='$tpl'");
		if($num){
			pd_setcookie('ptpl',$tpl);
			header('Location: '.$ref);
			exit;
		}
	}
}
if($settings[open_switch_langs]){
	$lang = gpc('lang','G','');
	$ref = gpc('ref','G','');
	$ref = $ref ? base64_decode($ref) : './';
	if($lang){
		$num = @$db->result_first("select count(*) from {$tpf}langs where lang_name='$lang'");
		if($num){
			pd_setcookie('lang',$lang);
			header('Location: '.$ref);
			exit;
		}
	}
}

$upload_remote = false;
if(display_plugin('multi_server','open_multi_server_plugin',$settings['open_multi_server'],0)){
	$rs = $db->fetch_one_array("select server_host,server_store_path,server_key from {$tpf}servers where server_id>1 order by is_default desc limit 1");
	if($rs){
		$upload_remote = true;
		$remote_url = $rs['server_host'].'?code='.pd_encode($rs['server_key']);
	}
	unset($rs);
}

$C[last_file] = get_last_file(15);
$C[hot_file] = get_hot_file(15);

if($auth[is_fms]){
	$C[links_arr] = get_friend_link();
	$C[last_users] = get_last_user_list(5);
	$C[last_one] = index_last();
	$C[ann_list] = get_announces();
	$C[index_tags] = get_last_tag();
	$C[commend_file] = get_commend_file(15);
}

require_once template_echo('phpdisk',$user_tpl_dir);
$f = PHPDISK_ROOT."./system/global/stats.inc.php";
if(!file_exists($f) || $timestamp-@filemtime($f)>3600){
	stats_cache();
}
sitemap::build();
include PHPDISK_ROOT."./includes/footer.inc.php";

function get_last_user_list($num=10){
	global $db,$tpf;
	$q = $db->query("select username,reg_time from {$tpf}users order by userid desc limit $num");
	$last_users = array();
	while ($rs = $db->fetch_array($q)) {
		$rs[a_space] = urr("space","username=".rawurlencode($rs[username]));
		$rs[reg_time] = date('Y-m-d',$rs[reg_time]);
		$last_users[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $last_users;
}
function get_friend_link(){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}links where is_hidden=0 order by logo desc,show_order asc,linkid desc");
	$arr = array();
	while($rs = $db->fetch_array($q)){
		$rs['has_logo'] = $rs['logo'] ? 1 : 0;
		$arr[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $arr;
}
function index_last(){
	global $db,$tpf;
	$username = @$db->result_first("select username from {$tpf}users order by userid desc limit 1");
	$arr['username'] = $username;
	$arr['a_last_user'] = urr("space","username=".rawurlencode($username));
	return $arr;
}
?>
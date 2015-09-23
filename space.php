<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: space.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$in_front = true;

$username = trim(gpc('username','G',''));
$folder_id = (int)gpc('folder_id','G',0);

$tmp_user = '';
$arr = explode('/',$settings['phpdisk_url']);
if($_SERVER['HTTP_HOST']<>$arr[2]){
	if($username){
		$tmp_user = @$db->result_first("select username from {$tpf}users where domain='$username'");
	}
	if(!$tmp_user){
		header("HTTP/1.1 404 Not Found");
		exit;
	}
}

$space_name = $tmp_user ? $tmp_user : $username;

$rs = $db->fetch_one_array("select space_name,userid,space_pwd from {$tpf}users where username='$space_name'");
$space_title = $rs['space_name'] ? $rs['space_name'] : $space_name.__('file');
$userid = $rs['userid'];
$space_pwd = $rs['space_pwd'];
$title = $space_title.' - '.$settings['site_title'];
$c_space_pwd = gpc('c_space_pwd','C','');
if(!$userid){
	header("HTTP/1.0 404 Not Found");
	exit;
}
if($pd_uid==$userid || !$space_pwd || ($space_pwd && ($space_pwd==$c_space_pwd))){
	$need_pwd = false;
}else{
	$need_pwd = true;
}

if($auth[pd_a]){
	$seo = get_seo('space',$userid);
	$seo_a = get_seo('space',0);
	if($seo_a[title]){
		eval("\$title = \"$seo[title] $seo_a[title]\";");
	}
	eval("\$keywords = \"$seo[keywords] $seo_a[keywords]\";");
	eval("\$description = \"$seo[description] $seo_a[description]\";");
}
include PHPDISK_ROOT."./includes/header.inc.php";
$my_announce = get_profile($userid,'my_announce') ? get_profile($userid,'my_announce') : '...此用户暂无公告...';
if($need_pwd){
	$arr = explode('space.php',$_SERVER['SCRIPT_NAME']);
	$ajax_url = 'http://'.$_SERVER['HTTP_HOST'].$arr[0];
	require_once template_echo('pd_space_pwd',$user_tpl_dir);
	include PHPDISK_ROOT."./includes/footer.inc.php";
	exit;
}

$nav_path = '<a href="'.urr("space","username=".rawurlencode($username)).'">'.__('home').'</a>&raquo; '.nav_path($folder_id,$userid);

if($auth[is_fms]){
	if($pg<=1){
		$q = $db->query("select * from {$tpf}folders where parent_id='$folder_id' and userid='$userid'");
		$sub_folders = array();
		while ($rs = $db->fetch_array($q)) {
			$rs[a_href] = urr("space","username=".rawurlencode($username)."&folder_id={$rs[folder_id]}");
			$rs[folder_size] = get_size($rs[folder_size]);
			$rs[in_time] = date('Y-m-d',$rs[in_time]);
			$sub_folders[] = $rs;
		}
		$db->free($q);
		unset($rs);
	}
}else{
	// root my folders
	$arr = my_folder_root($userid);
	$tmp = $arr[file_count] ? __('all_file')."{$arr[file_count]} , ".__('folder_size').get_size($arr[folder_size]) : '';
	$folder_list = "tr.add(0,-1,'".__('home')."','".urr("space","username=".rawurlencode($username))."','{$tmp}');".LF;
	// my other folders
	$arr = my_folder_menu($userid);
	foreach($arr as $v){
		$v['folder_name'] = addslashes(filter_word($v['folder_name']));
		$folder_list .= "tr.add({$v['folder_id']},{$v['parent_id']},'".cutstr($v['folder_name'],15,'')."','".urr("space","username={$username}&folder_id={$v['folder_id']}")."','{$v['folder_name']}');".LF;
	}
}

$sql_tmp = " and in_share=1 ";
if($folder_id){
	$sql_do = "{$tpf}files where userid='$userid' and is_del=0 and folder_id='$folder_id' $sql_tmp";
}else{
	$sql_do = "{$tpf}files where userid='$userid' and is_del=0 and folder_id='0' $sql_tmp";
}

$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
$total_num = $rs['total_num'];
$start_num = ($pg-1) * $perpage;

$q = $db->query("select * from {$sql_do} order by show_order asc, file_id desc limit $start_num,$perpage");
$files_array = array();
while($rs = $db->fetch_array($q)){
	$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
	$rs['file_thumb'] = get_file_thumb($rs);
	$rs['file_name_all'] = filter_word($rs['file_name'].$tmp_ext);
	$rs['file_name'] = cutstr(filter_word($rs['file_name'].$tmp_ext),80);
	$rs['file_new'] = ($timestamp-$rs['file_time']<86400) ? '<img src="images/new.png" align="absmiddle" border="0"/>' : '';
	$rs['file_size'] = get_size($rs['file_size']);
	$rs[file_description] = clear_html(filter_word($rs['file_description']),80);
	$rs['file_time'] = date("Y-m-d",$rs['file_time']);
	$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
	$files_array[] = $rs;
}
$db->free($q);
unset($rs);

$page_nav = multi($total_num, $perpage, $pg, "space.php?username=".rawurlencode($username)."&folder_id=$folder_id");


require_once template_echo('pd_space',$user_tpl_dir);

include PHPDISK_ROOT."./includes/footer.inc.php";
?>

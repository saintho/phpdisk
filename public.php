<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: public.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

!$auth[is_fms] && exit(msg::umsg('Not_FMS',__('zcore_no_power')));

$in_front = true;

$cate_id = (int)gpc('cate_id','G',0);
if($cate_id){
	$cate_name = $db->result_first("select cate_name from {$tpf}categories where cate_id='$cate_id'");
}

$nav_title = $cate_name ? $cate_name.'-' : '';
$nav_title = $nav_title.__('share_file');
$title = $nav_title.' - '.$settings['site_title'];
$file_keywords = $nav_title.',';

$C[cate_hot_file] = get_cate_file($cate_id,'file_downs');

if($auth[pd_a]){
	$seo = get_seo('public',$cate_id);
	if($seo[title]){
		eval("\$title = \"$seo[title]\";");
	}
	eval("\$keywords = \"$seo[keywords]\";");
	eval("\$description = \"$seo[description]\";");
}
include PHPDISK_ROOT."./includes/header.inc.php";

if($cate_id){

	$C[cate_list] = get_cate_list($cate_id);

	$sql_do = " {$tpf}files fl,{$tpf}users u where fl.userid=u.userid and cate_id='$cate_id' and is_checked=1";
	$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
	$total_num = $rs['total_num'];
	$start_num = ($pg-1) * $perpage;

	$q = $db->query("select fl.*,u.username from {$sql_do} order by file_id desc limit $start_num,$perpage");
	$files_array = array();
	while ($rs = $db->fetch_array($q)) {
		$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
		$rs['file_thumb'] = get_file_thumb($rs);		
		$rs['file_name_all'] = filter_word($rs['file_name'].$tmp_ext);
		$rs['file_name'] = filter_word($rs['file_name'].$tmp_ext);
		$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,80);
		$rs['file_size'] = get_size($rs['file_size']);
		$rs[file_description] = clear_html(filter_word($rs['file_description']),80);
		$rs['file_time'] = date("Y-m-d",$rs['file_time']);
		$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
		$rs[a_space] = urr("space","username=".rawurlencode($rs[username]));
		$files_array[] = $rs;
	}
	$db->free($q);
	unset($rs);

	$page_nav = multi($total_num, $perpage, $pg, "public.php?cate_id=".$cate_id);
}else{
	$q = $db->query("select * from {$tpf}categories where share_index=1 order by show_order asc,cate_id asc");
	$cate_list = array();
	while ($rs = $db->fetch_array($q)) {
		$cate_list[] = $rs;
	}
	$db->free($q);
	unset($rs);
}

require_once template_echo('pd_public',$user_tpl_dir);

include PHPDISK_ROOT."./includes/footer.inc.php";
?>
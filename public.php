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

$nav_title = $cate_name ? $cate_name.'' : '';
$nav_title = $nav_title;
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
	//面包屑
	$cur_cate = $cate_obj->getNodeById($cate_id);
	$breadcrumb = array();
	get_cate_breakcrumb($cur_cate, $breadcrumb);
	//分类数据
	$C[cate_list] = get_all_relate_cate_from_cateid($cate_id);
	//课程数据
	$course_array = get_course_from_cate($cate_id,'',$perpage);
	$course_data = $course_array['data'];
	//分页
	$page_nav = multi($course_array['total_num'], $perpage, $pg, "public.php?cate_id=".$cate_id);
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

<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: hotfile.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

!$auth[is_fms] && exit(msg::umsg('Not_FMS',__('zcore_no_power')));

$in_front = true;

$cate_id = (int)gpc('cate_id','G',0);
$o_type = trim(gpc('o_type','G',''));
$o_type = $o_type ? str_replace(array("'","'"),'',$o_type) : 'd_all';

if(!in_array($o_type,array('d_all','d_day','d_3day','d_now_week','d_week','d_month'))){
	header('Location: '.$settings[phpdisk_url].urr("hotfile",""));
	exit;
}

$o_type_tit = array(
'd_all'=>__('d_all_tit'),
'd_day'=>date('Y-m-d',strtotime('-1 day')).__('d_day_tit'),
'd_3day'=>__('d_3day_tit'),
'd_now_week'=>__('d_now_week_tit'),
'd_week'=>__('d_week_tit'),
'd_month'=>__('d_month_tit'),
);

$nav_title = $o_type_tit[$o_type];
$title = $nav_title.' - '.$settings['site_title'];
if($auth[pd_a]){
	$seo = get_seo('hotfile',$cate_id);
	if($seo[title]){
		eval("\$title = \"$seo[title]\";");
	}
	eval("\$keywords = \"$seo[keywords]\";");
	eval("\$description = \"$seo[description]\";");
}
include PHPDISK_ROOT."./includes/header.inc.php";

$C[cate_list] = get_cate_list();
$cate_sql = $cate_id ? " and cate_id='$cate_id'" : '';
if($o_type=='d_all'){
	$sql_do = " {$tpf}files fl,{$tpf}users u where fl.userid=u.userid and fl.is_del=0";
}else{
	switch ($o_type){
		case 'd_day':
			$d_val = date('Ymd',strtotime('-1 day'));
			break;
		case 'd_3day':
			$d = array();
			$d[] = date('Ymd',strtotime('-2 day'));
			$d[] = date('Ymd',strtotime('-1 day'));
			$d[] = date('Ymd');
			$d_str = implode(',',$d);
		case 'd_now_week':
			$d_val = date('YW');
			break;
		case 'd_week':
			$d_val = date('YW',strtotime('-1 week'));
			break;
		case 'd_month':
			$d_val = date('Ym');
			break;
	}
	if($o_type=='d_3day'){
		$sql_do = " {$tpf}files fl,".get_table_day_down()." dd,{$tpf}users u where fl.file_id=dd.file_id and fl.userid=u.userid $cate_sql and dd.d_day in ($d_str) and fl.is_del=0";
	}elseif($o_type=='d_now_week'){
		$sql_do = " {$tpf}files fl,".get_table_day_down()." dd,{$tpf}users u where fl.file_id=dd.file_id and fl.userid=u.userid $cate_sql and dd.d_week='$d_val' and fl.is_del=0";
	}else{
		$sql_do = " {$tpf}files fl,".get_table_day_down()." dd,{$tpf}users u where fl.file_id=dd.file_id and fl.userid=u.userid $cate_sql and dd.{$o_type}='$d_val' and fl.is_del=0";
	}
}

$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
$total_num = $rs['total_num'];
$start_num = ($pg-1) * $perpage;

if($o_type=='d_all'){
	$q = $db->query("select fl.*,u.username from {$sql_do} group by file_id order by fl.file_downs desc,file_id desc limit $start_num,$perpage");
}else{
	$q = $db->query("select fl.*,u.username from {$sql_do} group by file_id order by fl.file_downs desc,fl.file_id desc limit $start_num,$perpage");
}
$files_array = array();
while ($rs = $db->fetch_array($q)) {
	$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
	$rs['file_thumb'] = get_file_thumb($rs);
	$rs['file_name_all'] = filter_word($rs['file_name'].$tmp_ext);
	$rs['file_name'] = cutstr(filter_word($rs['file_name'].$tmp_ext),80);
	$rs['file_size'] = get_size($rs['file_size']);
	$rs[file_description] = clear_html(filter_word($rs['file_description']),80);
	$rs['file_time'] = date("Y-m-d",$rs['file_time']);
	$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
	$rs[a_space] = urr("space","username=".rawurlencode($rs[username]));
	$files_array[] = $rs;
}
$db->free($q);
unset($rs);

$page_nav = multi($total_num, $perpage, $pg, "hotfile.php?o_type=$o_type&cate_id=".$cate_id);

require_once template_echo('pd_hotfile',$user_tpl_dir);

include PHPDISK_ROOT."./includes/footer.inc.php";
?>
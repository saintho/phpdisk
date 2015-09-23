<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: download.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$in_front = true;

$file_id = (int)gpc('file_id','GP',0);

$num = @$db->result_first("select count(*) from {$tpf}files where file_id='$file_id' and is_del=0");
if(!$num){
	header("Location: ./");
	exit;
}
$file = curr_file($file_id);

$title = $file['file_name'].' - '.$settings['site_title'];

$mycp = ($file['username_a']==$pd_username) ? 1 : 0;

$myinfo = get_profile($file[userid]);

$nodes = get_nodes($file[server_oid]);

if($auth[is_fms]){
	$C[you_like_file] = super_cache::get('get_rand_file|10');
}

if(get_profile($file[userid],'plan_id')){
	$adv_top = stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'download_code_top')));
	$adv_inner = stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'download_code_left')));
	$adv_bottom = stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'download_code_bottom')));
}else{
	$adv_top = show_adv_data('adv_download_top',0);
	$adv_inner = show_adv_data('adv_download_inner',0);
	$adv_bottom = show_adv_data('adv_download_bottom',0);
}
if($auth[pd_a]){
	$seo = get_seo('download',$file_id);
	$seo_a = get_seo('download',0);
	if($seo_a[title]){
		eval("\$title = \"$seo[title] $seo_a[title]\";");
	}
	eval("\$keywords = \"$seo[keywords] $seo_a[keywords]\";");
	eval("\$description = \"$seo[description] $seo_a[description]\";");
}
include PHPDISK_ROOT."./includes/header.inc.php";

if(!$file[is_checked]){
	$msg = __('file_checking');
	require_once template_echo('information',$user_tpl_dir);
	include PHPDISK_ROOT."./includes/footer.inc.php";
	exit;
}

require_once template_echo('pd_download',$user_tpl_dir);

include PHPDISK_ROOT."./includes/footer.inc.php";

function curr_file($file_id){
	global $db,$tpf,$settings;
	$file = $db->fetch_one_array("select * from {$tpf}files where file_id='$file_id' and is_del=0");
	if(!$file){
		$file['is_del'] = 1;
		$file['file_name'] = __('visited_tips');
	}else{
		$file[dl] = create_down_url($file);
		$file['is_del'] = 0;
		$file_key = trim($file['file_key']);
		$tmp_ext = $file['file_extension'] ? '.'.$file['file_extension'] : "";
		$file_extension = $file['file_extension'];
		$file_ext = get_real_ext($file_extension);

		$file_description = $file['file_description'];
		$file['file_description'] = nl2br($file['file_description']);
		$file['a_space'] = urr("space","username=".rawurlencode($file['username']));
		$file['file_name'] = filter_word($file['file_name'].$tmp_ext);
		$file['file_size'] = get_size($file['file_size']);

		$file['file_url'] = $settings['phpdisk_url'].urr("viewfile","file_id={$file['file_id']}");


		return $file;
	}
}

?>
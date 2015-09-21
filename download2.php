<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: download2.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$in_front = true;

$file_id = (int)gpc('file_id','GP',0);

$file = curr_file($file_id);

if(!$file['is_del']){
	$title = $file['file_name_min'].' - '.$settings['site_title'];
}else{
	$title = __('file_is_delete').' - '.$settings['site_title'];
}

if($auth[pd_a]){
	$seo = get_seo('viewfile',$file_id);
	$seo_a = get_seo('viewfile',0);
	if($seo_a[title]){
		eval("\$title = \"$seo[title] $seo_a[title]\";");
	}
	eval("\$keywords = \"$seo[keywords] $seo_a[keywords]\";");
	eval("\$description = \"$seo[description] $seo_a[description]\";");
}

$logo = $user_tpl_dir.'images/logo.png';
$logo_url = $settings[phpdisk_url];

include PHPDISK_ROOT."./includes/header.inc.php";

$report_url = urr("mydisk","item=files&action=post_report&file_id=$file_id");
$comment_url = urr("mydisk","item=files&action=post_comment&file_id=$file_id");

require_once template_echo('pd_download2',$user_tpl_dir);

include PHPDISK_ROOT."./includes/footer.inc.php";

function curr_file($file_id){
	global $db,$tpf,$settings,$code;
	$file = $db->fetch_one_array("select * from {$tpf}files where file_id='$file_id'");
	if(!$file){
		$file['is_del'] = 1;
	}else{
		$file['dl'] = create_down_url($file);
		$in_extract = ($code==md5($file['file_key'])) ? 1 : 0;
		$file['username'] = $file['p_name'] = @$db->result_first("select username from {$tpf}users where userid='{$file['userid']}' limit 1");
		$rs = $db->fetch_one_array("select folder_id,folder_name from {$tpf}folders where userid='{$file['userid']}' and folder_id='{$file['folder_id']}'");
		$file['file_category'] = $rs['folder_name'] ? '<a href="'.urr("space","username=".rawurlencode($file['username'])."&folder_id=".$rs['folder_id']).'" target="_blank">'.$rs['folder_name'].'</a>' : '- '.__('uncategory').' -';
		$file_key = trim($file['file_key']);
		$tmp_ext = $file['file_extension'] ? '.'.$file['file_extension'] : "";
		$file_extension = $file['file_extension'];
		$file_ext = get_real_ext($file_extension);

		$file['file_description'] = str_replace('<br>',LF,$file[file_description]);
		$file['a_space'] = urr("space","username=".rawurlencode($file['username']));
		$file['file_name_min'] = filter_word($file['file_name'].$tmp_ext);
		$file['file_name'] = filter_word($file['file_name'].$tmp_ext);
		$file['file_size'] = get_size($file['file_size']);
		$file['p_time'] = $file['file_time'];
		$file['file_time'] = $file['time_hidden'] ? __('hidden') : date("Y-m-d",$file['file_time']);
		$file['credit_down'] = $file['file_credit'] ? (int)$file['file_credit'] : (int)$settings['credit_down'];
		$file['username'] = $file[user_hidden] ? __('hidden') : ($file['username'] ? '<a href="'.$file['a_space'].'">'.$file['username'].'</a>' : __('hidden'));

		$file['file_downs'] = $file['stat_hidden'] ? __('hidden') : get_discount($file[userid],$file['file_downs']);
		$file['file_views'] = $file['stat_hidden'] ? __('hidden') : get_discount($file[userid],$file['file_views']);
		$file['file_url'] = $settings['phpdisk_url'].urr("viewfile","file_id={$file['file_id']}");

		if(get_plans(get_profile($file[userid],'plan_id'),'open_second_page')==3){
			$file['a_downfile'] = urr("download","file_id={$file_id}&key=".random(32));
			$file['a_downfile2'] = urr("download","file_id={$file_id}&key=".random(32));
		}
	}
	return $file;
}


?>
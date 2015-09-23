<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: header.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}
$folder_id = (int)gpc('folder_id','G',0);
$a_index_share = urr("space","username=".rawurlencode($pd_username));
$a_upload_file = urr("mydisk","item=upload&folder_id=$folder_id&uid=$pd_uid");
$a_income = urr("income","");
$a_search = urr("search","");
$a_profile = urr("mydisk","item=profile");
//$upload_url = urr("mydisk","item=upload");
$a_profile_guest = urr("mydisk","item=profile&action=guest");
$can_edit = $myinfo[can_edit];

// nav
$tit_arr = array(
'default'=>__('myinfo'),
'chg_logo'=>__('space_setting'),
'multi_upload'=>__('multi_upload'),
'income_plans'=>__('income_plans'),
'income_set'=>__('income_set'),
'income'=>__('to_income'),
'income_log'=>__('income_log'),
'credit_log'=>__('credit_log'),
'invite'=>__('invite_user'),
'mod_stat'=>__('stat_code'),
'forum_upload'=>__('forum_upload'),
'mod_pwd'=>__('mod_pwd'),
'dl_users'=>__('downline_user'),
'dl_users2'=>__('dl_users2'),
'myannounce'=>__('myannounce'),
'files'=>'文件管理',
);

if($item=='profile'){
	$action = $action ? $action : 'default';
	$title = $tit_arr[$action].' - '.$settings['site_title'];
}
if($curr_script!=ADMINCP){
	$C[navi_top_link] = get_navigation_link('top');
}
if($auth[is_fms]){
	$C['sub_nav'] = get_sub_nav();
	if(in_array($curr_script,array('hotfile','tag','viewfile'))){
		$C[yesterday_down_file] = super_cache::get('get_day_down_file|'.date('Ymd',strtotime('-1 day')),'file',0,86400);
		$C[last_week_down_file] = super_cache::get('get_day_down_file|'.date('YW',strtotime('-1 week')).'|d_week','file',0,4*86400);
		$C[now_week_down_file] = super_cache::get('get_day_down_file|'.date('YW').'|d_week','file',0,3*86400);
	}
}
require_once template_echo('pd_header',$user_tpl_dir);

?>
<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: viewfile.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$in_front = true;

$file_id = (int)gpc('file_id','GP',0);
$code = trim(gpc('code','G',''));

/*$file['is_del'] = 0;
$file = $db->fetch_one_array("select is_del,file_id,file_time from {$tpf}files where file_id='$file_id'");
if(!$file['is_del']){*/
$file = curr_file($file_id);

if($settings['open_report']){
	$rs = $db->fetch_one_array("select count(*) as total from {$tpf}reports where (userid>0 and userid='$pd_uid') and file_id='$file_id'");
	$has_report = $rs['total'] ? 1 : 0;
	$a_report_file = urr("viewfile","action=report&file_id=$file_id&file_key=$file_key");
	if(!$pd_uid){
		$login_txt = __('please_login');
		$disabled = 'disabled';
	}
}
if(!$file['is_del']){
	$title = $file['file_name_min'].' - '.$settings['site_title'];
}else{
	$title = __('file_is_delete').' - '.$settings['site_title'];
}

$arr = file2tag($file_id);
$file_tags = '';
if(count($arr)){
	foreach($arr as $v){
		$file_tags .= $v['tag_name'].',';
	}
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
$loading_secs = get_loadiong_secs();

$myinfo = get_profile($file[userid]);
//$curr_tpl = $myinfo[curr_tpl] ? $myinfo[curr_tpl] : 'default';
//$user_tpl_dir = 'templates/'.$curr_tpl.'/';
//$username = $file['p_name'] ? $file['p_name'] : $pd_username;
//$tmp_username = $username;//convert_str('utf-8','gbk',$username);
$logo = $myinfo[logo] ? $settings['file_path'].'/'.$myinfo[logo] : $user_tpl_dir.'images/logo.png';
$logo_url = $myinfo[logo_url] ? $myinfo[logo_url] : urr("space","username=".rawurlencode($pd_username));

include PHPDISK_ROOT."./includes/header.inc.php";

if($auth[is_fms]){
	$C[cate_last_file] = get_cate_file((int)@$db->result_first("select cate_id from {$tpf}files where file_id='$file_id'"));
	$C[user_other_file] = get_user_other_file($file_id,$file[userid],5);
	$C[you_like_file] = super_cache::get('get_rand_file|5');

	if($settings['open_comment']){
		function file_last_comment($file_id){
			global $db,$tpf;
			$q = $db->query("select c.*,u.username from {$tpf}comments c,{$tpf}users u where file_id='$file_id' and is_checked=1 and c.userid=u.userid order by cmt_id desc limit 5");
			$cmts = array();
			while($rs = $db->fetch_array($q)){
				$rs['content'] = filter_word(str_replace("\r\n","<br>",$rs['content']));
				$rs['in_time'] = custom_time("Y-m-d H:i:s",$rs['in_time']);
				$rs['a_space'] = urr("space","username=".rawurlencode($rs['username']));
				$cmts[] = $rs;
			}
			$db->free($q);
			unset($rs);
			return $cmts;
		}
		$cmts = file_last_comment($file_id);
		$a_comment = urr("comment","file_id=$file_id");
	}

}else{
	$C[you_like_file] = super_cache::get('get_rand_file|5');
	$C[user_other_file] = get_user_other_file($file_id,$file[userid]);
}
$report_url = urr("mydisk","item=files&action=post_report&file_id=$file_id");
$comment_url = urr("mydisk","item=files&action=post_comment&file_id=$file_id");

require_once template_echo('pd_viewfile',$user_tpl_dir);
if(!$file['is_del']){
	add_credit_log($file_id,0,'ref',$file[userid],$_SERVER['HTTP_REFERER']);
	views_stat($file_id);
}

include PHPDISK_ROOT."./includes/footer.inc.php";

function views_stat($file_id){
	global $db,$tpf,$file,$settings,$auth;
	$view_stat = gpc('view_stat','C','');
	if(!$view_stat){
		pd_setcookie('view_stat',1,3600*3);
		$db->query_unbuffered("update {$tpf}files set file_views=file_views+1 where file_id='$file_id'");
		if($auth[view_credit] && $settings[how_view_credit_views] && $settings[how_view_credit_credit]){
			$add_credit = @round((int)$settings[how_view_credit_credit]/(int)$settings[how_view_credit_views],4);
			add_credit_log($file_id,$add_credit,'view',$file[userid]);
			$db->query_unbuffered("update {$tpf}users set credit=credit+$add_credit where userid='{$file[userid]}'");
		}
	}
}
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
		$file['tags'] = get_file_tags($file_id);
		$file['file_url'] = $settings['phpdisk_url'].urr("viewfile","file_id={$file['file_id']}");
		if($settings['open_file_url']){
			$file['file_view_url'] = $settings['phpdisk_url'].urr("viewfile","file_id={$file['file_id']}");
			$file['file_html_url'] = '<a href='.$settings['phpdisk_url'].urr("viewfile","file_id={$file['file_id']}").' target=_blank>'.$file['file_name'].'</a>';
			$file['file_ubb_url'] = '[url='.$settings['phpdisk_url'].urr("viewfile","file_id={$file['file_id']}").']'.$file['file_name'].'[/url]';
		}

		$all_count = $file['good_count']+$file['bad_count'];
		$file['good_rate'] = $file['good_count'] ? round($file['good_count']/$all_count,3)*100 : 0;
		$file['bad_rate'] = $file['bad_count'] ? round($file['bad_count']/$all_count,3)*100 : 0;

		if(get_plans(get_profile($file[userid],'plan_id'),'open_second_page')==2){
			$file['a_downfile'] = urr("download","file_id={$file_id}&key=".random(32));
			$file['a_downfile2'] = urr("download","file_id={$file_id}&key=".random(32));
		}elseif(get_plans(get_profile($file[userid],'plan_id'),'open_second_page')==3){
			$file['a_downfile'] = urr("download2","file_id={$file_id}&key=".random(32));
			$file['a_downfile2'] = urr("download2","file_id={$file_id}&key=".random(32));
		}else{
			$file['a_downfile'] = urr("download","file_id={$file_id}&key=".random(32));
			$file['a_downfile2'] = urr("download","file_id={$file_id}&key=".random(32));
		}

		$file['url'] = $file['a_downfile'];

		//$file['a_viewfile'] = urr("downfile","action=view&file_id={$file['file_id']}&file_key={$file['file_key']}");
		$file['file_view_url'] = $settings['phpdisk_url'].urr("viewfile","file_id={$file['file_id']}&file_key={$file['file_key']}");
		$file['file_html_url'] = '<a href='.$settings['phpdisk_url'].urr("viewfile","file_id={$file['file_id']}&file_key={$file['file_key']}").' target=_blank>'.$file['file_name'].'</a>';
		$file['file_ubb_url'] = '[url='.$settings['phpdisk_url'].urr("viewfile","file_id={$file['file_id']}&file_key={$file['file_key']}").']'.$file['file_name'].'[/url]';
	}
	return $file;
}

function file2tag($file_id){
	global $db,$tpf;
	$q = $db->query("select tag_name from {$tpf}file2tag where file_id='$file_id'");
	$arr = array();
	while($rs = $db->fetch_array($q)){
		$arr[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $arr;
}
function get_file_tags($file_id){
	global $db,$tpf;
	$str = '';
	$q = $db->query("select * from {$tpf}file2tag where file_id='$file_id'");
	while($rs = $db->fetch_array($q)){
		$str .= '<a href="'.urr("tag","tag=".urlencode($rs[tag_name])).'" target="_blank">'.$rs[tag_name].'</a> ';
	}
	$db->free($q);
	unset($rs);
	return $str;
}
function get_loadiong_secs(){
	global $settings,$timestamp,$pd_uid;
	$vip_id = get_profile($pd_uid,'vip_id');
	$loading_secs = (int)$settings['global_sec_loading'];
	if($vip_id){
		$vip_end_time = get_profile($pd_uid,'vip_end_time');
		if($vip_end_time>$timestamp){
			$loading_secs = (int)get_vip($vip_id,'down_second');
		}
	}
	return $loading_secs;
}
function get_cmt_num(){
	global $db,$tpf,$file_id;
	$rs = $db->result_first("select count(*) as cmt from {$tpf}comments where file_id='$file_id'");
	return $rs['cmt'];
}
?>
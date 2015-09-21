<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: comment.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$in_front = true;

$file_id = (int)gpc('file_id','GP',0);

if(!$file_id){
	aheader("Location: ./");
}
$rs = $db->fetch_one_array("select file_name,file_extension from {$tpf}files where file_id='$file_id' limit 1");
if($rs){
	$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
	$file_name = $rs['file_name'].$tmp_ext;
}
unset($rs);
$a_viewfile = urr("viewfile","file_id=$file_id&file_key=$file_key");
$title = __('comment').': '.$file_name.' - '.$settings['site_title'];

$perpage = 20;
$rs = $db->fetch_one_array("select count(*) as total_num from {$tpf}comments where file_id='$file_id' and is_checked=1");
$total_num = $rs['total_num'];
$start_num = ($pg-1) * $perpage;

function show_comment($file_id){
	global $db,$tpf,$pg,$start_num,$perpage;
	$q = $db->query("select c.*,u.username from {$tpf}comments c,{$tpf}users u where file_id='$file_id' and is_checked=1 and c.userid=u.userid order by cmt_id asc limit $start_num,$perpage");
	$cmts = array();
	while($rs = $db->fetch_array($q)){
		$rs['content'] = str_replace("\r\n","<br>",$rs['content']);
		$rs['in_time'] = custom_time("Y-m-d H:i:s",$rs['in_time']);
		$rs['a_space'] = urr("space","username=".rawurlencode($rs['username']));
		$cmts[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $cmts;
}
$cmts = show_comment($file_id);
$page_nav = multi($total_num, $perpage, $pg, urr("comment","file_id=$file_id"));

include PHPDISK_ROOT."./includes/header.inc.php";

switch($action){
	case 'cmt':
		form_auth(gpc('formhash','P',''),formhash());

		$content = trim(gpc('content','P',''));
		$file_id = (int)gpc('file_id','P',0);

		if(checklength($content,2,600)){
			$error = true;
			$sysmsg[] = __('cmt_content_error');
		}
		if(!$error){
			$ins = array(
			'userid' => $pd_uid,
			'file_id' => $file_id,
			'content' => replace_js($content),
			'in_time' => $timestamp,
			'ip' => $onlineip,
			'is_checked' => $settings['check_comment'] ? 0 : 1,
			);
			$db->query("insert into {$tpf}comments set ".$db->sql_array($ins).";");
			$sysmsg[] = __('cmt_success');
			redirect(urr("comment","file_id=$file_id"),$sysmsg);
			exit;
		}else{
			redirect('back',$sysmsg);
			exit;
		}
		break;
}
require_once template_echo('pd_comment',$user_tpl_dir);

include PHPDISK_ROOT."./includes/footer.inc.php";


?>
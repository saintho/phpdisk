<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: tag.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";
!$auth[is_fms] && exit(msg::umsg('Not_FMS',__('zcore_no_power')));
$in_front = true;

$tag = trim(gpc('tag','G',''));
if($tag){
	$title = __('tag').': '.$tag.' - '.$settings['site_title'];
	$tag_title = __('tag').': '.$tag;
}else{
	$title = __('tag_view').' - '.$settings['site_title'];
	$tag_title = __('tag_view');
}
include PHPDISK_ROOT."./includes/header.inc.php";

if(!$tag){
	$hot_tags = get_hot_tag(50);
	$last_tags = get_last_tag(50);
}else{
	function get_file_ids($tag){
		global $db,$tpf;
		$q = $db->query("select file_id from {$tpf}file2tag where tag_name='{$tag}'");
		while($rs = $db->fetch_array($q)){
			$file_ids .= $rs['file_id'].',';
		}
		$db->free($q);
		unset($rs);
		return $file_ids;
	}
	$file_ids = get_file_ids($tag);
	$file_ids = (substr($file_ids,-1) ==',') ? substr($file_ids,0,-1) : $file_ids;
	if(!$file_ids){
		header("Location: ".urr("tag",""));
		exit;
	}

	$sql_do = "{$tpf}files where file_id in ($file_ids)";

	$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
	$total_num = $rs['total_num'];
	$start_num = ($pg-1) * $perpage;

	$q = $db->query("select file_id,file_key,file_name,file_extension,file_size,file_time,server_oid,file_store_path,file_real_name,is_image from {$sql_do} order by file_id desc limit $start_num,$perpage");
	$files_array = array();
	while($rs = $db->fetch_array($q)){
		$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
		$rs['file_thumb'] = get_file_thumb($rs);
		$rs['file_name_all'] = filter_word($rs['file_name'].$tmp_ext);
		$rs['file_name'] = cutstr(filter_word($rs['file_name'].$tmp_ext),35);
		$rs['file_size'] = get_size($rs['file_size']);
		$rs['file_time'] = custom_time("Y-m-d",$rs['file_time']);
		$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
		$files_array[] = $rs;
	}
	$db->free($q);
	unset($rs);

	$page_nav = multi($total_num, $perpage, $pg, urr("tag","tag=".rawurlencode($tag)));
}


require_once template_echo('pd_tag',$user_tpl_dir);

include PHPDISK_ROOT."./includes/footer.inc.php";


?>
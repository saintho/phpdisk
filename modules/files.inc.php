<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: files.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

$file_id = (int)gpc('file_id','GP',0);
$userid = 0;
if($pd_gid==1){
	$userid = @$db->result_first("select userid from {$tpf}files where file_id='$file_id' limit 1");
}
$userid = $userid ? (int)$userid : $pd_uid;

switch ($action){

	case 'modify_file':
		if($task =='modify_file'){
			form_auth(gpc('formhash','P',''),formhash());
			$folder_name = trim(gpc('folder_name','P',''));
			$folder_id = (int)gpc('folder_id','P',0);
			$file_name = trim(gpc('file_name','P',''));
			$file_description = gpc('file_description','P','',0);
			$in_share = (int)gpc('in_share','P',0);
			$stat_hidden = (int)gpc('stat_hidden','P',0);
			$time_hidden = (int)gpc('time_hidden','P',0);
			if($auth[open_user_hidden]){
				$user_hidden = (int)gpc('user_hidden','P',0);
			}else{
				$user_hidden = 0;
			}
			if($auth[is_fms]){
				$tags = trim(gpc('file_tag','P',''));
				if($tags){
					$tags = str_replace('，',',',$tags);
					$tags = str_replace(',,',',',$tags);
					$tags = (substr($tags,-1) ==',') ? substr($tags,0,-1) : $tags;

					$tag_arr = explode(',',$tags);
					if(count($tag_arr) >5){
						$error = true;
						$sysmsg[] = __('too_many_tags');
					}
				}
			}

			if($file_description && checklength($file_description,1,6000)){
				$error = true;
				$sysmsg[] = __('file_description_error');
			}else{
				$file_description = preg_replace("/<(\/?i?frame.*?)>/si","",$file_description);
				$file_description = preg_replace("/<(\/?script.*?)>/si","",$file_description);
			}
			if(!$error){
				$ins = array(
				'file_name' => $file_name,
				'folder_id' => $folder_id,
				'in_share' => $in_share,
				'is_checked' => $settings[check_public_file] ? 0 : 1,
				'stat_hidden' => $stat_hidden,
				'time_hidden' => $time_hidden,
				'user_hidden' => $user_hidden,
				'file_description'=>$file_description,
				);
				$db->query_unbuffered("update {$tpf}files set ".$db->sql_array($ins)." where userid='$pd_uid' and file_id='$file_id'");
				if($auth[is_fms]){
					make_tags($tags,$tag_arr,$file_id);
				}
				tb_redirect('reload',__('modify_file_success'),0);

			}else{
				tb_redirect('back',$sysmsg);
			}

		}else{
			$file = $db->fetch_one_array("select * from {$tpf}files where file_id='$file_id' and userid='$pd_uid'");
			$file['file_time'] = date('Y-m-d H:i:s',$file['file_time']);
			$file['file_size'] = get_size($file['file_size']);
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
	case 'op_file':
		if($task =='del_file'){
			form_auth(gpc('formhash','P',''),formhash());
			$file_ids = gpc('file_ids','P',array());

			$ids_arr = get_ids_arr($file_ids,__('please_select_operation_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set is_del=1 where file_id in ($file_str) and userid='$userid'");
				$sysmsg[] = __('delete_file_success');
				redirect('back',$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task=='move_file'){
			form_auth(gpc('formhash','P',''),formhash());
			$file_ids = gpc('file_ids','P',array());
			$dest_fid = (int)gpc('dest_fid','P',0);

			$ids_arr = get_ids_arr($file_ids,__('please_select_operation_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set folder_id='$dest_fid' where file_id in ($file_str) and userid='$userid'");
				$sysmsg[] = __('file_to_category_success');
				redirect('back',$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task=='push_file'){
			form_auth(gpc('formhash','P',''),formhash());
			$file_ids = gpc('file_ids','P',array());
			$cate_id = (int)gpc('cate_id','P',0);

			$ids_arr = get_ids_arr($file_ids,__('please_select_operation_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}
			$is_checked = $settings[check_public_file] ? 0 : 1;
			if(!$error){
				$ins = array(
				'is_checked'=>$is_checked,
				'cate_id'=>$cate_id,
				);
				$db->query_unbuffered("update {$tpf}files set ".$db->sql_array($ins)." where file_id in ($file_str) and userid='$userid'");
				$sysmsg[] = __('push_file_success');
				redirect('back',$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}elseif($task =='update_order'){
			form_auth(gpc('formhash','P',''),formhash());
			$show_order = gpc('show_order','P',array());
			$file_ids2 = gpc('file_ids2','P',array());
			for($i=0;$i<count($show_order);$i++){
				if($file_ids2[$i]){
					$db->query_unbuffered("update {$tpf}files set show_order='{$show_order[$i]}' where file_id='{$file_ids2[$i]}'");
				}
			}
			$sysmsg[] = __('order_file_success');
			redirect('back',$sysmsg);

		}elseif($task=='outlink'){
			form_auth(gpc('formhash','P',''),formhash());
			$file_ids = gpc('file_ids','P',array());
			$order = gpc('order','G','');
			$order_txt = $order=='asc' ? 'desc' : 'asc';

			$ids_arr = get_ids_arr($file_ids,__('please_select_operation_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}

			if($file_str){
				$q = $db->query("select file_id,file_name,file_key,file_extension,is_image,file_store_path,file_real_name,server_oid from {$tpf}files where file_id in ($file_str) order by file_id $order");
				$upl_array = array();
				while($rs = $db->fetch_array($q)){
					$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
					$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
					$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,35);
					$rs['file_link'] = $settings['phpdisk_url'].urr("viewfile","file_id=".$rs['file_id']);

					$upl_array[] = $rs;
				}
				$db->free($q);
				unset($rs);
			}
			$action = 'outlink';
			require_once template_echo('profile',$user_tpl_dir);
		}
		break;
	case 'post_report':
		$file_id = (int)gpc('file_id','GP',0);
		if($task=='post_report'){
			form_auth(gpc('formhash','P',''),formhash());

			$content = trim(gpc('content','P',''));
			$ref = trim(gpc('ref','P',''));

			if(checklength($content,2,250)){
				$error = true;
				$sysmsg[] = __('report_content_error');
			}

			if(!$error){
				$ins = array(
				'userid' => $pd_uid,
				'file_id' => $file_id,
				'content' => replace_js($content),
				'in_time' => $timestamp,
				'ip' => $onlineip,
				'is_new' => 1,
				);
				$db->query("insert into {$tpf}reports set ".$db->sql_array($ins).";");
				$db->query_unbuffered("update {$tpf}files set report_status=1 where file_id='$file_id'");
				$sysmsg[] = __('report_success');
				tb_redirect($ref,$sysmsg);
			}else{
				tb_redirect('back',$sysmsg);
			}
		}else{
			$msg = '';
			$rs = $db->fetch_one_array("select count(*) as total from {$tpf}reports where file_id='".$file_id."' and userid='$pd_uid'");
			if($rs['total']){
				$msg = __('report_already_exists');
			}
			unset($rs);
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
	case 'post_comment':
		$file_id = (int)gpc('file_id','GP',0);
		if($task=='post_comment'){
			form_auth(gpc('formhash','P',''),formhash());

			$content = trim(gpc('content','P',''));
			$ref = trim(gpc('ref','P',''));

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
				tb_redirect($ref,$sysmsg);
			}else{
				tb_redirect('back',$sysmsg);
			}
		}else{
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
}

?>
<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: folders.inc.php 123 2014-03-04 12:40:37Z along $
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

	case 'add_folder':
		if($task=='add_folder'){
			form_auth(gpc('formhash','P',''),formhash());
			$folder_name = trim(gpc('folder_name','P',''));
			$pid = (int)gpc('pid','P','');

			if(checklength($folder_name,1,150)){
				$error = true;
				$sysmsg[] = __('add_folder_error');
			}elseif(strpos($folder_name,"'")!==false){
				$error = true;
				$sysmsg[] = "不能含有单引号等特殊字符";
			}
			$num = @$db->result_first("select count(*) from {$tpf}folders where userid='$pd_uid' and folder_name='$folder_name' and parent_id='$pid'");
			if($num){
				$error = true;
				$sysmsg[] = __('folder_exists');
			}
			if(!$error){
				$ins = array(
				'folder_name' => $folder_name,
				'userid' => $pd_uid,
				'parent_id' => $pid,
				'in_time'=>$timestamp,
				);
				$db->query_unbuffered("insert into {$tpf}folders set ".$db->sql_array($ins)."");
				$sysmsg[] = __('add_folder_success');
				tb_redirect('reload',$sysmsg);
			}else{
				tb_redirect('back',$sysmsg);
			}
		}else{

			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
	case 'folder_delete':
		$folder_id = (int)gpc('folder_id','GP',0);
		if($task=='folder_delete'){
			form_auth(gpc('formhash','P',''),formhash());
			$ref = gpc('ref','P','');
			
			$db->query_unbuffered("update {$tpf}files set is_del=1,folder_id=0 where folder_id='$folder_id' and userid='$pd_uid'");
$db->query_unbuffered("update {$tpf}folders set parent_id=0 where parent_id='$folder_id' and userid='$pd_uid'");
			$db->query_unbuffered("delete from {$tpf}folders where folder_id='$folder_id' and userid='$pd_uid'");
			
			$sysmsg[] = __('delete_folder_success');
			redirect($ref,$sysmsg);
		}else{
			$ref = $_SERVER['HTTP_REFERER'];
			$folder_name = @$db->result_first("select folder_name from {$tpf}folders where folder_id='$folder_id' and userid='$pd_uid'");
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
	case 'modify_folder':
		$folder_id = (int)gpc('folder_id','GP',0);
		if($task =='modify_folder'){
			form_auth(gpc('formhash','P',''),formhash());
			$folder_name = trim(gpc('folder_name','P',''));
			$pid = (int)gpc('pid','P',0);

			if(checklength($folder_name,1,150)){
				$error = true;
				$sysmsg[] = __('folder_name_error');
			}elseif(strpos($folder_name,"'")!==false){
				$error = true;
				$sysmsg[] = "不能含有单引号等特殊字符";
			}
			if($folder_id==$pid){
				$error = true;
				$sysmsg[] = __('folder_id_pid_not_same');
			}
			$num = @$db->result_first("select count(*) from {$tpf}folders where folder_name='$folder_name' and folder_id<>'$folder_id' and userid='$pd_uid'");
			if($num){
				$error = true;
				$sysmsg[] = __('folder_exists');
			}

			if(!$error){
				$ins = array(
				'folder_name' => $folder_name,
				'parent_id' => $pid,
				);
				$db->query_unbuffered("update {$tpf}folders set ".$db->sql_array($ins)." where folder_id='$folder_id' and userid='$pd_uid'");

				tb_redirect('reload',__('modify_folder_success'),0);
			}else{
				tb_redirect('back',$sysmsg);
			}
		}else{

			$fd = $db->fetch_one_array("select folder_name,parent_id from {$tpf}folders where folder_id='$folder_id' limit 1");
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
}

?>
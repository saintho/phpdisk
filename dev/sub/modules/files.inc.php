<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: files.inc.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

switch ($action){
	case 'replace_file':
		$file_id = (int)gpc('file_id','GP',0);
		$folder_id = (int)gpc('folder_id','GP',0);

		if($task =='replace_file'){

			form_auth(gpc('formhash','P',''),formhash());
			$file = $_FILES['filedata'];

			if(!is_utf8()){
				$file['name'] = convert_str('utf-8','gbk',$file['name']);
			}
			$file['name'] = filter_name($file['name']);
			$file_extension = $db->escape(get_extension($file['name']));
			$esp = strlen($file_extension)+1;
			if($file_extension){
				$file_name = $db->escape(substr($file['name'],0,strlen($file['name'])-$esp));
			}else{
				$file_name = $db->escape($file['name']);
			}
			$file_real_path = PHPDISK_ROOT.$settings['file_path'].'/';
			$file_store_path = date('Y/m/d/');
			//$file_store_path_store = is_utf8() ? convert_str('utf-8','gbk',$file_store_path) : $file_store_path;
			make_dir($file_real_path.$file_store_path);

			$file_real_name = md5(uniqid(mt_rand(),true).microtime().$pd_uid);
			$file_ext = get_real_ext($file_extension);
			$dest_file = $file_real_path.$file_store_path.$file_real_name.$file_ext;

			$file_mime = strtolower($db->escape($file['type']));
			if(@in_array($file_extension,array('jpg','jpeg','png','gif','bmp'))){
				$img_arr = @getimagesize($file['tmp_name']);
				if($img_arr[2]){
					$is_image = 1;
					@make_thumb($file['tmp_name'], $file_real_path.$file_store_path.$file_real_name_store.'_thumb.'.$file_extension,$settings['thumb_width'],$settings['thumb_height']);
				}else{
					$is_image = 0;
				}
			}else{
				$is_image = 0;
			}
			$rs = $db->fetch_one_array("select file_name,file_extension,file_store_path,file_real_name from {$tpf}files where file_id='$file_id' and userid='$pd_uid' limit 1");
			if($rs){
				$file_ext = $rs[file_extension] ? '.'.$rs[file_extension] : '';
				@unlink(PHPDISK_ROOT.$settings[file_path].'/'.$rs[file_store_path].'/'.$rs[file_real_name].$file_ext);
				@unlink(PHPDISK_ROOT.$settings[file_path].'/'.$rs[file_store_path].'/'.$rs[file_real_name].'_thumb'.$file_ext);
			}
			unset($rs);
			$server_oid = @$db->result_first("select server_oid from {$tpf}servers where server_id>1 order by is_default desc limit 1");

			if(!$error && upload_file($file['tmp_name'],$dest_file)){
				$ins = array(
				'file_name' => $file_name,
				'file_key' => $file_key,
				'file_extension' => $file_extension,
				'is_image' => $is_image,
				'file_mime' => $file_mime,
				'file_store_path' => $file_store_path,
				'file_real_name' => $file_real_name,
				'file_size' => $file['size'],
				'file_time' => $timestamp,
				'server_oid' => (int)$server_oid,
				'is_checked' => 1,
				'in_share' => 1,
				'userid' => $pd_uid,
				'ip' => $onlineip,
				'folder_id' => $folder_id,
				);
				$db->query_unbuffered("update {$tpf}files set ".$db->sql_array($ins)." where file_id='$file_id' and userid='$pd_uid' limit 1");

				$sysmsg[] = '替换文件上传成功';
				tb_redirect($settings[phpdisk_url].urr("space","username=".rawurlencode($pd_username)),$sysmsg);
			}else{
				tb_redirect('back',$sysmsg);
			}
			@unlink($file['tmp_name']);
		}else{
			$folder_id = @$db->result_first("select folder_id from {$tpf}files where file_id='$file_id' limit 1");
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
}

?>
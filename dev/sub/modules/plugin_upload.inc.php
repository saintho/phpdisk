<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: plugin_upload.inc.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}
$is_locked = @$db->result_first("select is_locked from {$tpf}users where userid='$pd_uid' limit 1");
if($is_locked){
	exit("[PHPDISK] User locked");
}
$server_oid = get_server_oid();

@set_time_limit(0);

$group_set = $db->fetch_one_array("select * from {$tpf}groups where gid='$pd_gid'");
$upload_max = get_byte_value(ini_get('upload_max_filesize'));
$post_max = get_byte_value(ini_get('post_max_size'));
$settings_max = $settings['max_file_size'] ? get_byte_value($settings['max_file_size']) : 0;
$max_php_file_size = min($upload_max, $post_max);
$max_file_size_byte = ($settings_max && $settings_max <= $max_php_file_size) ? $settings_max : $max_php_file_size;
if($group_set['max_filesize']){
	$group_set_max_file_size = get_byte_value($group_set['max_filesize']);
	$max_file_size_byte = ($group_set_max_file_size >=$max_file_size_byte) ? $max_file_size_byte : $group_set_max_file_size;
}
$max_user_file_size = get_size($max_file_size_byte,'B',0);

$uid = (int)gpc('uid','G',0);
$folder_id = (int)gpc('folder_id','G',0);
$plugin_type = trim(gpc('plugin_type','G',''));
$hash = trim(gpc('hash','G',''));

$md5_sign = md5($uid.$folder_id.$plugin_type.$settings[phpdisk_url]);

if($md5_sign<>$hash){
	exit('[PHPDisk] Error Params!');
}
$action = $action ? $action : 'doupload';

switch($action){

	default:
		$upload_url = urr("plugin_upload","uid=$uid&folder_id=$folder_id&plugin_type=$plugin_type&hash=$hash");

		if($task == 'doupload'){
			$file = $_FILES['upload_file'];
			$sign = gpc('sign','P','');

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

			/*$file_name = str_replace(' ','_',$file_name);
			$username = $db->result_first("select username from {$tpf}users where userid='$uid'");

			$tmp_username = is_utf8() ? convert_str('utf-8','gbk',$username) : $username;*/
			$file_real_path = PHPDISK_ROOT.$settings['file_path'].'/';
			$file_store_path = date('Y/m/d/');
			//$file_store_path_store = is_utf8() ? convert_str('utf-8','gbk',$file_store_path) : $file_store_path;
			make_dir($file_real_path.$file_store_path);

			/*$num = $db->result_first("select count(*) from {$tpf}files where file_name='$file_name' and file_extension='$file_extension' and file_size='{$file[size]}' and userid='$uid' and folder_id='$folder_id'");
			$file_real_name = $num ? $file_name.'_'.random(2) : $file_name;
			$file_real_name_store = is_utf8() ? convert_str('utf-8','gbk',$file_real_name) : $file_real_name;*/
			$file_real_name = md5(uniqid(mt_rand(),true).microtime().$pd_uid);
			$file_ext = get_real_ext($file_extension);
			$dest_file = $file_real_path.$file_store_path.$file_real_name.$file_ext;

			if(!chk_deny_extension($file_extension) && upload_file($file['tmp_name'],$dest_file)){

				$report_status =0;
				$report_arr = explode(',',$settings['report_word']);
				if(count($report_arr)){
					foreach($report_arr as $value){
						if (strpos($file['name'],$value) !== false){
							$report_status = 2;
						}
					}
				}
				$file_key = random(8);

				$file_mime = strtolower($db->escape($file['type']));
				$img_arr = getimagesize($dest_file);
				if($img_arr[2] && @in_array($file_extension,array('jpg','jpeg','png','gif','bmp'))){
					$is_image = 1;
					make_thumb($dest_file, $file_real_path.$file_store_path.$file_real_name.'_thumb.'.$file_extension,$settings['thumb_width'],$settings['thumb_height']);
				}else{
					$is_image = 0;
				}

				$db->ping();
				$ins = array(
				'file_name' => $file_name,
				'file_key' => $file_key,
				'file_extension' => $file_extension,
				'is_image' => $is_image,
				'file_mime' => $file_mime,
				'file_description' => $file_description ? $file_description : '',
				'file_store_path' => $file_store_path,
				'file_real_name' => $file_real_name,
				'file_md5' => $file_md5 ? $file_md5 : '',
				'server_oid' => (int)$server_oid,
				'file_size' => $file['size'],
				'file_time' => $timestamp,
				'is_checked' => 1,
				'in_share' => 1,//$in_share,
				'report_status' => $report_status,
				'userid' => $uid,
				'ip' => $onlineip,
				'stat_hidden' => 1,
				'folder_id'=>$folder_id,
				);
				$db->query_unbuffered("insert into {$tpf}files set ".$db->sql_array($ins).";");
				$file_id = $db->insert_id();
				//$db->query_unbuffered("update {$tpf}folders set folder_size=folder_size+{$file['size']} where userid='$pd_uid' and folder_id='$folder_id'");
				$ins = array(
				'hash' => $sign,
				'file_id'=>$file_id,
				'in_time'=>$timestamp,
				);
				//write_file(PHPDISK_ROOT.'system/a.txt',$sign.LF,'ab');
				$db->query_unbuffered("insert into {$tpf}plugin_upload set ".$db->sql_array($ins).";");

				@unlink($file['tmp_name']);
			}else{
				$access_str = '<?php exit(); ?>';
				$error_log = PHPDISK_ROOT.'system/upload_log.php';
				if(file_exists($error_log)){
					$content = read_file($error_log);
				}
				$str = ' ';
				if(strpos($content,$access_str) ===false){
					$str = $access_str.LF.$str;
				}
				write_file($error_log,$str,'a+');
			}


		}else{
			// delete > 7 day's plugin_upload files.
			$db->query_unbuffered("delete from {$tpf}plugin_upload where $timestamp-in_time>86400");
			// fix flash upload user_agent
			$sign = md5($_SERVER['HTTP_USER_AGENT'].$onlineip);
			
			$rs = $db->fetch_one_array("select user_file_types from {$tpf}users where userid='$pd_uid'");
			if($group_set['group_file_types']){
				$arr = explode(',',trim($group_set['group_file_types']));
				for($i=0;$i<count($arr);$i++){
					$user_file_types .= '*.'.$arr[$i].';';
				}
			}else{
				if($rs['user_file_types']){
					$arr = explode(',',trim($rs['user_file_types']));
					for($i=0;$i<count($arr);$i++){
						$user_file_types .= '*.'.$arr[$i].';';
					}
				}else{
					$user_file_types = '*.*';
				}
			}

			$rs = $db->fetch_one_array("select folder_name,folder_node,parent_id from {$tpf}folders where folder_id='$folder_id' and userid='$pd_uid'");
			if($rs){
				$folder_name = $rs['folder_name'];
				$folder_node = $rs['folder_node'];
				$rs2 = $db->fetch_one_array("select folder_id,folder_name,folder_node from {$tpf}folders where folder_id='{$rs['parent_id']}' and userid='$pd_uid'");
				$parent_folder = $rs2['folder_name'];

				if($folder_node ==4){
					$rs3 = $db->fetch_one_array("select folder_id,folder_name,folder_node,parent_id from {$tpf}folders where folder_id=(select parent_id from {$tpf}folders where folder_id='{$rs['parent_id']}' and userid='$pd_uid') and userid='$pd_uid'");
					$parent_folder2 = $rs3['folder_name'];
					$parent_href2 = urr("mydisk","item=files&action=index&folder_node=2&folder_id={$rs3['folder_id']}");

					$rs4 = $db->fetch_one_array("select folder_id,folder_name,folder_node from {$tpf}folders where folder_id='{$rs3['parent_id']}' and userid='$pd_uid'");
					$disk_name = $rs4['folder_name'];
					$disk_href = urr("mydisk","item=files&action=index&folder_node=1&folder_id={$rs3['parent_id']}");
					$parent_href = urr("mydisk","item=files&action=index&folder_node=3&folder_id={$rs['parent_id']}");

				}elseif($folder_node ==3){
					$rs3 = $db->fetch_one_array("select folder_id,folder_name,folder_node from {$tpf}folders where folder_id=(select parent_id from {$tpf}folders where folder_id='{$rs['parent_id']}' and userid='$pd_uid') and userid='$pd_uid'");
					$disk_name = $rs3['folder_name'];
					$disk_href = urr("mydisk","item=files&action=index&folder_node=1&folder_id={$rs3['folder_id']}");
					$parent_href = urr("mydisk","item=files&action=index&folder_node=2&folder_id={$rs['parent_id']}");

				}else{
					$rs2 = $db->fetch_one_array("select folder_id,folder_name,folder_node from {$tpf}folders where folder_id='{$rs['parent_id']}' and userid='$pd_uid'");
					$parent_href = urr("mydisk","item=files&action=index&folder_node={$rs2['folder_node']}&folder_id={$rs2['folder_id']}");

				}
				unset($rs2,$rs3,$rs4);
			}

			require_once template_echo('plugin_upload',$user_tpl_dir);
		}
}



?>
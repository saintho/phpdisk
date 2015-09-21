<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: upload.inc.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

$server_oid = get_server_oid();

$is_locked = @$db->result_first("select is_locked from {$tpf}users where userid='$pd_uid'");
if($is_locked){
	exit("[PHPDISK] User locked");
}

@set_time_limit(0);

$max_user_file_size = get_user_file_size($pd_gid);

$param = gpc('param','G','');

if(in_array($task,array('doupload','guest_upload'))){
	$len = $settings[encrypt_key] ? strlen($settings[encrypt_key]) : 9;
	parse_str(base64_decode(substr($param,-(strlen($param)-$len))));
}else{
	$file_id = (int)gpc('file_id','GP',0);
	$folder_id = (int)gpc('folder_id','G',0);
	$folder_node = (int)gpc('folder_node','G',0);
	$uid = (int)gpc('uid','G',0);
}
$action = $action ? $action : 'doupload';

switch($action){

	default:
		$rand = random($settings[encrypt_key]?strlen($settings[encrypt_key]):9);
		$upload_url = urr("mydisk","item=upload&param=$rand".base64_encode("ts=$timestamp&folder_id=$folder_id&uid=$pd_uid"));
		
		if($task =='guest_upload'){
			//write_file(PHPDISK_ROOT.'system/1.txt',var_export($_GET,true),'ab');
			//write_file(PHPDISK_ROOT.'system/3.txt',$uid.'|'.$sess_id,'ab');
			$file = $_FILES['upload_file'];
			/*$sess_id = $db->escape(trim(gpc('sess_id','P','')));
			$uid = (int)gpc('uid','P',0);
			$folder_id = (int)gpc('folder_id','P',0);*/
			if(!$uid){
				$tmp_uid = (int)@$db->result_first("select userid from {$tpf}users order by userid desc limit 1");
				if($tmp_uid){
					$tmp_name = 'guest'.($tmp_uid+1);
					$num = @$db->result_first("select count(*) from {$tpf}users where username='".$db->escape($tmp_name)."'");
					$tmp_name = $num ? $tmp_name.random(2) : $tmp_name;
					$ins = array(
					'username' => $db->escape($tmp_name),
					'password' => md5($tmp_name),
					'email' => $tmp_name.'@guest.na',
					'reset_code' => $sess_id,
					'gid' => 4,
					'reg_time' => $timestamp,
					'reg_ip' => $onlineip,
					'space_name' => $tmp_name.' 的文件',
					'can_edit'=>1,
					);
					$db->query_unbuffered("insert into {$tpf}users set ".$db->sql_array($ins)."");
					$uid = $db->insert_id();
				}else{
					$uid = 2;
				}
			}

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

			/*$num = $db->result_first("select count(*) from {$tpf}files where file_name='$file_name' and file_extension='$file_extension' and userid='$uid'");
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
				'file_size' => $file['size'],
				'file_time' => $timestamp,
				'server_oid' => (int)$server_oid,
				'is_checked' => 1,
				'in_share' => 1,
				'report_status' => $report_status,
				'userid' => $uid,
				'ip' => $onlineip,
				'folder_id' => (int)$folder_id,
				);
				//write_file(PHPDISK_ROOT.'system/2.txt',var_export($ins,true),'ab');
				$db->query_unbuffered("insert into {$tpf}files set ".$db->sql_array($ins).";");
				$file_id = $db->insert_id();
				$db->query_unbuffered("update {$tpf}folders set folder_size=folder_size+{$file['size']} where userid='$uid' and folder_id='$folder_id'");

				@unlink($file['tmp_name']);
			}else{
				$access_str = '<?php exit(); ?>';
				$error_log = PHPDISK_ROOT.'system/guest_upload_log.php';
				if(file_exists($error_log)){
					$content = read_file($error_log);
				}
				$str = ' ';
				if(strpos($content,$access_str) ===false){
					$str = $access_str.LF.$str;
				}
				write_file($error_log,$str,'a+');
			}
		}elseif($task == 'doupload'){
			//write_file(PHPDISK_ROOT.'system/a.txt',var_export($_GET,true),'ab');
			//exit;
			$file = $_FILES['upload_file'];
			$up_folder_id = (int)gpc('up_folder_id','P',0);
			$up_cate_id = (int)gpc('up_cate_id','P',0);

			if(!is_utf8()){
				$file['name'] = convert_str('utf-8','gbk',$file['name']);
			}

			//$file['name'] = filter_name($file['name']);
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

			/*$num = $db->result_first("select count(*) from {$tpf}files where file_name='$file_name' and file_extension='$file_extension' and userid='$uid'");
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
				'is_checked' => $settings['check_public_file'] ? 0 : 1,
				'in_share' => 1,//$in_share,
				'report_status' => $report_status,
				'userid' => $uid,
				'cate_id'=>(int)$up_cate_id,
				'folder_id' => (int)$up_folder_id,
				'ip' => $onlineip,
				);
				//write_file(PHPDISK_ROOT.'system/b.txt',var_export($ins,true),'ab');
				$db->query_unbuffered("insert into {$tpf}files set ".$db->sql_array($ins).";");
				$file_id = $db->insert_id();
				$db->query_unbuffered("update {$tpf}folders set folder_size=folder_size+{$file['size']} where userid='$pd_uid' and folder_id='$folder_id'");

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
			$upload_cate = (int)$settings[upload_cate];

			$rs = $db->fetch_one_array("select gid,user_file_types from {$tpf}users where userid='$pd_uid'");
			$group_set = $group_settings[$rs[gid]];
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

			$uid = $pd_uid ? $pd_uid : $uid;

			require_once template_echo($item,$user_tpl_dir);
		}
}



?>
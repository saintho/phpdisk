<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: client_sub.php 28 2014-01-29 03:12:01Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
include "../../includes/commons.inc.php";
@set_time_limit(0);
$agent = $_SERVER['HTTP_USER_AGENT'];
if($agent!='phpdisk-client'){
	exit('<a href="http://faq.phpdisk.com/search?w=p403&err=code" target="_blank">[PHPDisk Access Deny] Invalid Entry!</a>');
}
$u_info = trim(gpc('u_info','P',''));

parse_str(pd_encode(base64_decode($u_info),'DECODE'));
// checked username and pwd...
/*$username = trim(gpc('username','GP',''));
$password = trim(gpc('password','GP',''));*/

$username = is_utf8() ? $username : convert_str('utf-8','gbk',$username);
$password = is_utf8() ? $password : convert_str('utf-8','gbk',$password);

$userinfo = $db->fetch_one_array("select userid from {$tpf}users where username='$username' and password='$password'");
if(!$userinfo){
	$str = '网盘登录出错：用户名或密码不正确，请重新输入';
	$str = is_utf8() ? convert_str('utf-8','gbk',$str) : $str;
	echo $str;
}else{
	$uid = (int)$userinfo[userid];
}

switch ($action){
	case 'upload_file':
		//write_file(PHPDISK_ROOT.'system/2.txt',var_export($_POST,true));
		//write_file(PHPDISK_ROOT.'system/3.txt',var_export($_FILES,true));
		$file = $_FILES['file1'];
		$file_name = trim(gpc('file_name','P',''));
		$file_do_name = trim(gpc('file_do_name','P',''));
		$file_local_path = trim(gpc('file_local_path','P',''));
		$file_size = (int)gpc('file_size','P',0);
		$file_parts = (int)gpc('file_parts','P',0);
		$tmp_dir = PHPDISK_ROOT.'system/cache/';
		make_dir($tmp_dir);
		$file_local_path = is_utf8() ? convert_str('gbk','utf-8',$file_local_path) : $file_local_path;
		$file_do_name = is_utf8() ? convert_str('gbk','utf-8',$file_do_name) : $file_do_name;
		$file_name = is_utf8() ? convert_str('gbk','utf-8',$file_name) : $file_name;
		if(upload_file($file['tmp_name'],$tmp_dir.$file[name])){
			//insert db
			$file_store_path = date('Y/m/d/');
			$file_extension = get_extension($file_do_name);
			$esp = strlen($file_extension)+1;
			$file_real_name = $file_extension ? substr($file_do_name,0,strlen($file_do_name)-$esp) : $file_do_name;
			$file_name = $file_extension ? substr($file_name,0,strlen($file_name)-$esp) : $file_name;

			$rs = @$db->fetch_one_array("select id from {$tpf}uploadx_files where userid='$uid' and file_store_path='$file_store_path' and file_real_name='$file_real_name' and file_name='$file_name'");
			if(!$rs){
				$ins = array(
				'id'=>random(8),
				'userid'=>$uid,
				'file_name'=>$file_name,
				'file_extension'=>$file_extension,
				'file_size'=>$file_size,
				'file_parts'=>$file_parts,
				'file_local_path'=>$db->escape(str_replace('\\\\','\\',$file_local_path)),
				'file_store_path'=>$file_store_path,
				'file_real_name'=>$file_real_name,
				'file_time'=>$timestamp,
				'folder_id'=>(int)$folder_id,// ? $folder_id : '-1',
				'ip'=>$onlineip,
				);
				//write_file(PHPDISK_ROOT.'system/a.txt',var_export($ins,true),'ab');
				$db->query_unbuffered("insert into {$tpf}uploadx_files set ".$db->sql_array($ins)."");
			}else{
				$ins = array(
				'file_parts'=>$file_parts,
				'file_store_path'=>$file_store_path,
				'file_time'=>$timestamp,
				'ip'=>$onlineip,
				);
				$db->query_unbuffered("update {$tpf}uploadx_files set ".$db->sql_array($ins)." where id='{$rs[id]}'");
			}
			//
			$file_do_name = is_utf8() ? convert_str('utf-8','gbk',$file_do_name) : $file_do_name;
			$tmp_file = $tmp_dir.$file_do_name.'.phpdisk';
			if($file_parts==1){
				write_file($tmp_file,read_file($tmp_dir.$file[name]));
			}else{
				if(file_exists($tmp_file)){
					write_file($tmp_file,read_file($tmp_dir.$file[name]),'ab');
				}else{
					write_file($tmp_file,read_file($tmp_dir.$file[name]));
				}
			}
			@unlink($tmp_dir.$file[name]);
		}else{
			$str = '文件 '.$file_name.' 上传失败，服务器权限不足';
			$str = is_utf8() ? convert_str('utf-8','gbk',$str) : $str;
			echo $str;
		}
		@unlink($file['tmp_name']);
		break;

	case 'upload_ok':
		//write_file(PHPDISK_ROOT.'system/1.txt',var_export($_POST,true));
		$file_name = trim(gpc('file_name','P',''));
		$file_do_name = trim(gpc('file_do_name','P',''));
		$file_size = (int)gpc('file_size','P',0);
		$file_name = is_utf8() ? convert_str('gbk','utf-8',$file_name) : $file_name;
		$file_do_name = is_utf8() ? convert_str('gbk','utf-8',$file_do_name) : $file_do_name;
		$file_extension = get_extension($file_do_name);
		$esp = strlen($file_extension)+1;
		$file_real_name = $file_extension ? substr($file_do_name,0,strlen($file_do_name)-$esp) : $file_do_name;
		$file_name = $file_extension ? substr($file_name,0,strlen($file_name)-$esp) : $file_name;

		$rs = $db->fetch_one_array("select * from {$tpf}uploadx_files where userid='$uid' and file_real_name='$file_real_name' and file_name='$file_name' limit 1");
		if($rs){
			$tmp_ext = $rs[file_extension] ? '.'.$rs[file_extension] : '';
			$dir1 = PHPDISK_ROOT.'system/cache/';
			$dir2 = PHPDISK_ROOT.$settings[file_path].'/'.$rs[file_store_path];
			make_dir($dir2);
			$file = $dir1.$rs[file_real_name].$tmp_ext.'.phpdisk';
			$file_real_name = md5(uniqid(mt_rand(),true).microtime().$uid);
			$file_dest = $dir2.$file_real_name.get_real_ext($rs[file_extension]);
			//write_file(PHPDISK_ROOT.'system/s2.txt',$file.'|'.$file_dest.',');
			//if(@filesize($file)==(int)$rs[file_size]){
			if(file_exists($file) && @rename($file,$file_dest)){
				$file_real_path = PHPDISK_ROOT.'/'.$settings['file_path'].'/';
				$img_arr = getimagesize($file_dest);
				if($img_arr[2] && @in_array($file_extension,array('jpg','jpeg','png','gif','bmp'))){
					$is_image = 1;
					make_thumb($file_dest, $file_real_path.$rs[file_store_path].$file_real_name.'_thumb.'.$file_extension,$settings['thumb_width'],$settings['thumb_height']);
				}else{
					$is_image = 0;
				}
				if($configs[server_key]){
					$server_oid = (int)@$db->result_first("select server_oid from {$tpf}servers where server_key='".$db->escape($configs[server_key])."'");
				}else{
					$server_oid = 0;
				}
				$ins = array(
				'file_name' => $rs[file_name],
				'file_key' => random(8),
				'file_extension' => $rs[file_extension],
				'is_image' => $is_image,
				'file_mime' => 'application/octet-stream',
				'file_description' => '',
				'file_store_path' => $rs[file_store_path],
				'file_real_name' => $file_real_name,
				'file_md5' => '',
				'server_oid' => (int)$server_oid,
				'file_size' => $rs[file_size],
				'file_time' => $timestamp,
				'is_checked' => 1,
				'in_share' => 0,
				'userid' => $uid,
				'folder_id'=>$rs[folder_id],
				'ip' => $onlineip,
				);
				$db->query_unbuffered("insert into {$tpf}files set ".$db->sql_array($ins));
				//$db->query_unbuffered("update {$tpf}uploadx_files set file_state=1 where id='{$rs[id]}'");
				$db->query_unbuffered("delete from {$tpf}uploadx_files where id='{$rs[id]}'");
				$str = '文件 '.$rs[file_name].$tmp_ext.' 上传成功';
			}else{
				$str = '文件 '.$rs[file_name].$tmp_ext.' 上传失败，目录权限不足';
			}
		}else{
			$str = '未知上传错误';
		}
		$str = is_utf8() ? convert_str('utf-8','gbk',$str) : $str;
		echo $str;
		exit;
		break;

	default:
		exit('<a href="http://faq.phpdisk.com/search?w=p404&err=code" target="_blank">[PHPDisk Access Deny] Connect Error!</a>');
}
?>
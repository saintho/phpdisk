<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: client_main.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
include '../../includes/commons.inc.php';

if($action && $action<>'download'){
	$agent = $_SERVER['HTTP_USER_AGENT'];
	if($agent!='phpdisk-client'){
		exit('<a href="http://faq.google.com/search?w=p403&err=code" target="_blank">[PHPDisk Access Deny] Invalid Entry!</a>');
	}
}
// checked username and pwd...
$username = trim(gpc('username','GP',''));
$password = trim(gpc('password','GP',''));

$username = is_utf8() ? convert_str('gbk','utf-8',$username) : $username;
$password = is_utf8() ? convert_str('gbk','utf-8',$password) : $password;

$rs = $db->fetch_one_array("select * from {$tpf}users where username='$username' and password='$password'");
if(!$rs){
	$str = '网盘登录出错：用户名或密码不正确，请重新输入';
	if(is_utf8()){
		echo convert_str('utf-8','gbk',$str);
	}else{
		echo $str;
	}
	exit;
}else{
	if($rs[is_locked]){
		$str = '网盘登录出错：用户名被锁定';
		if(is_utf8()){
			echo convert_str('utf-8','gbk',$str);
		}else{
			echo $str;
		}
		exit;
	}elseif(!$settings[open_phpdisk_client]){
		$str = '网盘登录出错：网盘客户端使用暂时关闭';
		if(is_utf8()){
			echo convert_str('utf-8','gbk',$str);
		}else{
			echo $str;
		}
		exit;
	}else{
		$uid = (int)$rs[userid];
		$gid = (int)$rs[gid];
	}
}
switch ($action){
	case 'login':
		$str = is_utf8() ? convert_str('utf-8','gbk',$username) : $username;
		echo $str.LF;
		echo $password.LF;
		echo $gid.LF;
    echo '25868FE80D0976653E640DD2B7D81708'.LF;
		exit;
		break;
	case 'mydisk':
		$folder_id = (int)gpc('folder_id','P',0);
		$goback = (int)gpc('goback','P',0);
		//$folder_id = !$folder_id ? -1 : $folder_id;
		if($goback){
			$folder_id = (int)@$db->result_first("select parent_id from {$tpf}folders where userid='$uid' and folder_id='$folder_id'");
		}
		echo get_curr_path($folder_id).LF;
		echo $folder_id.LF;
		$q = $db->query("select * from {$tpf}folders where userid='$uid' and parent_id='$folder_id' order by folder_order asc, folder_id asc");
		while ($rs = $db->fetch_array($q)) {
			if($rs[folder_name]){
				$str = $rs[folder_name].'|-|-|1|'.$rs[folder_id].'|'.date('Y-m-d',$rs[in_time]).'|-|-';
				$str = is_utf8() ? convert_str('utf-8','gbk',$str) : $str;
				echo $str ? $str.LF : '';
			}
		}
		$db->free($q);
		unset($rs);

		$q = $db->query("select * from {$tpf}files where userid='$uid' and folder_id='$folder_id' and is_del=0 order by file_id desc");
		while ($rs = $db->fetch_array($q)) {
			$tmp_ext = $rs[file_extension] ? '.'.$rs[file_extension] : '';
			$tmp_ext2 = $rs[file_extension] ? $rs[file_extension] : ' ';
			$str = $rs[file_name].$tmp_ext.'|'.$rs[file_size].'|'.$tmp_ext2.'|0|'.$rs[file_id].'|'.date('Y-m-d',$rs[file_time]).'|'.$rs[file_views].'|'.$rs[file_downs];
			$str = is_utf8() ? convert_str('utf-8','gbk',$str) : $str;
			echo $str ? $str.LF : '';
		}
		$db->free($q);
		unset($rs);
		exit;
		break;
	case 'download':
		$file_id = (int)gpc('file_id','GP',0);
		$rs = $db->fetch_one_array("select * from {$tpf}files where file_id='$file_id' and userid='$uid'");
		$tmp_ext = $rs[file_extension] ? '.'.$rs[file_extension] : '';
		if($rs[server_oid]){
			$host = @$db->result_first("select server_host from {$tpf}servers where server_oid='{$rs[server_oid]}'");
		}else{
			$host = $settings[phpdisk_url];
		}
		//$filter_arr = explode(',',$settings['filter_extension']);
		//$tmp_ext = in_array($rs[file_extension],$filter_arr) ? '.txt'.$tmp_ext : $tmp_ext;
		header("Location: ".$host.$settings[file_path].'/'.$rs[file_store_path].$rs[file_real_name].get_real_ext($rs[file_extension]));
		//echo "select * from {$tpf}files where file_id='$file_id' and userid='$uid'";
		exit;
		break;

	case 'search':
		$word = convert_str('gbk','utf-8',trim(gpc('word','P','')));
		if($word){
			$q = $db->query("select * from {$tpf}files where userid='$uid' and is_del=0 and (file_name like '%$word%' or file_extension like '%$word%') order by file_id desc");
			$num = $db->num_rows($q);
			if($num){
				echo 't'.LF;
				while ($rs = $db->fetch_array($q)) {
					$tmp_ext = $rs[file_extension] ? '.'.$rs[file_extension] : '';
					$tmp_ext2 = $rs[file_extension] ? $rs[file_extension] : ' ';
					$str = $rs[file_name].$tmp_ext.'|'.$rs[file_size].'|'.$tmp_ext2.'|0|'.$rs[file_id].'|'.date('Y-m-d',$rs[file_time]).'|'.$rs[file_views].'|'.$rs[file_downs];
					$str = is_utf8() ? convert_str('utf-8','gbk',$str) : $str;
					echo $str ? $str.LF : '';
				}
				$db->free($q);
				unset($rs);
			}else{
				echo 'f'.LF;
				$str = '此关键字找不到相应文件记录';
				echo is_utf8() ? convert_str('utf-8','gbk',$str) : $str;
			}
		}else{
			echo 'f'.LF;
			$str = '关键字不能为空';
			echo is_utf8() ? convert_str('utf-8','gbk',$str) : $str;
		}
		exit;
		break;
	case 'loadset':
		if($settings['open_multi_server']){
			$server_host = @$db->result_first("select server_host from {$tpf}servers where server_id>1 order by is_default desc limit 1");
		}
		$server_host = $server_host ? trim($server_host) : $settings[phpdisk_url];
		echo 'true'.LF;
		echo $server_host.LF;
		echo '0'.LF;
		echo base64_encode(pd_encode('username='.$username.'&password='.$password)).LF;
		echo $settings[client_api_key];
		exit;
		break;
	case 'resume':
		$q = $db->query("select * from {$tpf}uploadx_files where userid='$uid' order by file_time asc");
		$num = $db->num_rows($q);
		if($num){
			echo 't'.LF;
			while ($rs = $db->fetch_array($q)) {
				$tmp_ext = $rs[file_extension] ? '.'.$rs[file_extension] : '';
				$tmp_ext2 = is_utf8() ? convert_str('utf-8','gbk',$tmp_ext) : $tmp_ext;
				if(@filesize(PHPDISK_ROOT.'system/cache/'.$rs[file_real_name].$tmp_ext2.'.phpdisk')==($rs[file_parts]*128*1024)){
					$file_parts = $rs[file_parts];
				}else{
					$file_parts = 0;
				}
				$rs['file_local_path'] = str_replace('\\\\','\\',$rs['file_local_path']);
				$str = $rs[file_name].$tmp_ext.'|'.$rs[file_size].'|'.$rs['file_local_path'].'|'.$file_parts;
				$str = is_utf8() ? convert_str('utf-8','gbk',$str) : $str;
				echo $str ? $str.LF : '';
			}
			$db->free($q);
			unset($rs);
		}else{
			echo 'f'.LF;
			$str = '暂无待续传文件任务';
			echo is_utf8() ? convert_str('utf-8','gbk',$str) : $str;
		}
		exit;
		break;
	default:
		exit('No Action!');
}

function get_curr_path($folder_id){
	global $db,$tpf;
	$str = '';
	if($folder_id){
		$rs = $db->fetch_one_array("select parent_id,folder_id,folder_name from {$tpf}folders where folder_id='$folder_id'");
		if($rs['parent_id']!=-1){
			$str .= get_curr_path($rs['parent_id']);
		}
		$rs['folder_name'] = is_utf8() ? convert_str('utf-8','gbk',$rs['folder_name']) : $rs['folder_name'];
		$str .= $rs['folder_name'] ? $rs['folder_name'].'/' : '';
		unset($rs);
	}
	return $str ? $str : '';
}
?> 
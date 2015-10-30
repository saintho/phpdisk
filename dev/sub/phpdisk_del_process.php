<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: phpdisk_del_process.php 24 2012-09-05 02:52:59Z along $
#
#	Copyright (C) 2008-2012 PHPDisk Team. All Rights Reserved.
#
*/
include "includes/commons.inc.php";

@set_time_limit(0);
@ignore_user_abort(true);

$server_arr = array('up'=>'上传服务器','down'=>'下载服务器','local'=>'本地服务器');
$str = $_SERVER['QUERY_STRING'];

if($str){

	parse_str(pd_encode($str,'DECODE'));
	$pp = iconv('utf-8','gbk',$pp);
	$arr = explode('.',$pp);
	$src_file = $arr[0].get_real_ext($arr[1]);
	$thumb_file = $arr[0].'_thumb.'.$arr[1];
	$out_txt = "删除结果：【{$server_arr[$server]}】【{$_SERVER['HTTP_HOST']}】，删除文件【{$file_name}】，文件ID:[{$file_id}]";

	$file_extension = get_extension($file_name);
	$esp = strlen($file_extension)+1;
	if($file_extension){
		$file_name = substr($file_name,0,strlen($file_name)-$esp);
	}

	$rs = $db->fetch_one_array("select file_real_name,file_extension,file_store_path from {$tpf}files where file_id='$file_id' limit 1");
	if($rs){
		$num = @$db->result_first("select count(*) from {$tpf}files where file_real_name='{$rs[file_real_name]}' and file_extension='{$rs[file_extension]}' and file_name='{$file_name}' and file_store_path='{$rs[file_store_path]}'");
	}
	if($safe){
		if($num==1){
			if(@unlink(PHPDISK_ROOT.$src_file)){
				@unlink(PHPDISK_ROOT.$thumb_file);
				echo 'document.writeln("'.$out_txt.' <span class=\"txtblue\">成功</span><br>");'.LF;
			}else{
				echo 'document.writeln("'.$out_txt.' <span class=\"txtred\">失败[文件不存在或权限不足]</span><br>");'.LF;
				//echo 'alert("'.$out_txt.' \r\n安全删除失败，请使用单个文件删除此文件后再使用批量删除功能1。");'.LF;
				$log = '<? exit; ?> '.$out_txt.LF.'路径:'.PHPDISK_ROOT.$pp.' 时间:'.date('Y-m-d H:i:s').LF;
				write_file(PHPDISK_ROOT.'system/delfile_log.php',$log,'ab');
			}
		}else{
			echo 'document.writeln("'.$out_txt.' <span class=\"txtred\">失败[存在引用]</span><br>");'.LF;
			//echo 'alert("'.$out_txt.' \r\n安全删除失败，此文件还存在其他的用户转存的文件引用，请使用非安全删除进行操作。");'.LF;
			$log = '<? exit; ?> '.$out_txt.LF.'路径:'.PHPDISK_ROOT.$pp.' 时间:'.date('Y-m-d H:i:s').LF;
			write_file(PHPDISK_ROOT.'system/delfile_log.php',$log,'ab');
		}
	}else{
		if($num==1){
			@unlink(PHPDISK_ROOT.$src_file);
			@unlink(PHPDISK_ROOT.$thumb_file);
		}
		echo 'document.writeln("'.$out_txt.' <span class=\"txtblue\">成功</span><br>");'.LF;
	}
	if($server=='up'){
		$db->query_unbuffered("delete from {$tpf}files where file_id='$file_id'");
		echo 'document.writeln("数据库记录文件ID:['.$file_id.']删除 <span class=\"txtblue\">成功</span><br>");'.LF;
	}
}else{
	exit('<br> <p style="font-size:14px" align="center">Program is running, but error params!</p>');
}

?>

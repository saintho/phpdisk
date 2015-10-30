<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: mydisk.php 25 2011-03-04 07:36:51Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$uid = (int)gpc('uid','G',0);
$folder_id = (int)gpc('folder_id','G',0);
$plugin_type = trim(gpc('plugin_type','G',''));
$hash = trim(gpc('hash','G',''));

$md5_sign = md5($uid.$folder_id.$plugin_type.$settings[phpdisk_url]);

if($md5_sign<>$hash){
	//exit('[PHPDisk] Error Params [main]!');
}

$sign = md5($_SERVER['HTTP_USER_AGENT'].$onlineip);

write_file(PHPDISK_ROOT.'system/b.txt',$sign.LF,'ab');

$q = $db->query("select file_id from {$tpf}plugin_upload where hash='$sign'");
$file_ids = '';
while ($rs = $db->fetch_array($q)) {
	$file_ids .= $rs[file_id].',';
}
$db->free($q);
unset($rs);

$file_ids = $file_ids ? substr($file_ids,0,-1) : '';
if($file_ids){
	$q = $db->query("select file_id,file_name,file_extension,file_time,file_size from {$tpf}files where file_id in ($file_ids) order by file_id desc limit 10");
	$str = '';
	while ($rs = $db->fetch_array($q)) {
		$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
		$rs['file_name_all'] = cutstr($rs['file_name'].$tmp_ext,35);
		$rs['a_downfile'] = $settings[phpdisk_url].urr("viewfile","file_id=".$rs['file_id']);
		$rs['file_time'] = date('Y-m-d',$rs['file_time']);
		$rs['file_size'] = get_size($rs['file_size']);

		$rs[ctn_2] = str_replace(array('"',"'"),'_',$rs['file_name_all']).'\\\r\\\n下载地址： [url='.$rs['a_downfile'].']'.$rs['a_downfile'].'[/url]\\\r\\\n\\\r\\\n';
		$rs[ctn] = str_replace(array('"',"'"),'_',$rs['file_name_all']).'<br>下载地址： [url='.$rs['a_downfile'].']'.$rs['a_downfile'].'[/url]<br><br>';
		$str .= '<div class="fl_list">'.LF;
		//$str .= '<div class="f1"><span style="float:right" class="txtgray">'.$rs[file_size].'</span>&nbsp;<a href="javascript:;" title="'.$rs['file_name'].'" onclick="addCodeToEditor(\\\''.$rs['ctn'].'\\\',\\\''.$rs['ctn_2'].'\\\',\\\''.$plugin_type.'\\\');">'.$rs['file_name_all'].'</a></div>'.LF;
		$str .= '<div class="f1"><span style="float:right" class="txtgray">'.$rs[file_size].'</span>&nbsp;<a href="javascript:;" title="'.$rs['file_name'].'" onclick="addCodeToEditor(\\\''.$rs['ctn'].'\\\',\\\''.$rs['ctn_2'].'\\\',\\\''.$plugin_type.'\\\');">'.$rs['file_name_all'].'</a></div>'.LF;
		//$str .= '<div class="f1"><span style="float:right" class="txtgray">'.$rs[file_size].'</span>&nbsp;<a href="###" title="'.$rs['file_name'].'" id="f_'.$rs[file_id].'" onclick="top.test(\''.$rs['a_downfile'].'\');">'.file_icon($rs['file_extension']).$rs['file_name_all'].'</a></div>'.LF;
		$str .= '<div class="f2"><span class="txtgray">'.$rs['file_time'].'</span></div>'.LF;
		$str .= '</div>'.LF;
		$str .= '<div class="clear"></div>'.LF;
	}
	$db->free($q);
	unset($rs);
	//echo 'alert(\''.$str.'\')';
	$str = $str ? str_replace(LF,'',$str) : '';

	echo 'var callback= \''.$str.'\';';
}else{
	echo 'var callback= \'<div class="clear">No file list.'.$file_ids.'</div>\';';
}
?>



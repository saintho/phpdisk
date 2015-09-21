<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: index.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$in_front = true;

$code = trim(gpc('code','G',''));
$action = gpc('action','G','');

/*if(!$code){
exit('[PHPDisk] Access Deny!');
}else{
if(pd_encode($code,'DECODE') != $configs['server_key']){
exit('[PHPDisk] Access Deny!');
}
}
*/
$str = $_SERVER['QUERY_STRING'];
if(!$str){
  exit('[PHPDisk] Access Denied');
}
$title = $settings['site_title'];
//include PHPDISK_ROOT."./includes/header.inc.php";
if($action=='upload'){
	include PHPDISK_ROOT."./includes/header.inc.php";
	require_once template_echo('upload',$user_tpl_dir);
	include PHPDISK_ROOT."./includes/footer.inc.php";
}else{
	if($settings['close_guest_upload'] && !$pd_uid){
		die(__('close_guest_upload_tips'));
	}else{
		$max_user_file_size = str_replace(' ','',get_user_file_size($pd_gid));
		$rand = random($settings[encrypt_key]?strlen($settings[encrypt_key]):9);
		$guest_upload_url = urr("mydisk","item=upload&param=$rand".base64_encode("ts=$timestamp&uid=$pd_uid&folder_id=$folder_id&sess_id=$sess_id"));
		require_once template_echo('guest_upload',$user_tpl_dir);
	}
}

//include PHPDISK_ROOT."./includes/footer.inc.php";
if($q){
	$db->free($q);
}
$db->close();
unset($C,$L,$tpf,$configs,$rs);
ob_end_flush();

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: functions.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}

function open_uc_plugin($val){
	echo (int)$val;
}
function uc_share_folder($folder_id,$folder_name,$message=''){
	global $pd_uid,$pd_gid,$pd_username,$settings;
	$feed = array();
	$feed['icon'] = 'folder';
	$feed['title_template'] = "{$pd_username} ".__('share_folder')." {$folder_name}";
	$feed['title_data'] = array (
		'username' => '<a href="'.$settings['phpdisk_url'].urr("space","username=".rawurlencode($pd_username)).'">'.$pd_username.'</a>',
		'folder_name' => '<a href="'.$settings['phpdisk_url'].urr("space","username=".rawurlencode($pd_username)).'">'.$folder_name.'</a>',
	);
	$feed['body_template'] = '';
	$feed['body_data'] = array();
	$feed['body_general'] = '';
	
	uc_feed_add($feed['icon'], $pd_uid, $pd_username, $feed['title_template'], $feed['title_data'], $feed['body_template'], $feed['body_data'], $feed['body_general'] , '', array());
	
}

function uc_upload_public($file_id,$file_key,$file_name,$message=''){
	global $pd_uid,$pd_gid,$pd_username,$settings;
	$feed = array();
	$feed['icon'] = 'folder';
	$feed['title_template'] = "{$pd_username} ".__('upload_public')." {$file_name}";
	$feed['title_data'] = array (
		'username' => '<a href="'.$settings['phpdisk_url'].urr("space","username=".rawurlencode($pd_username)).'">'.$pd_username.'</a>',
		'file_name' => '<a href="'.$settings['phpdisk_url'].urr("viewfile","file_id={$file_id}&file_key={$file_key}").'">'.$file_name.'</a>',
		);
	$feed['body_template'] = '';
	$feed['body_data'] = array();
	$feed['body_general'] = '';
	
	uc_feed_add($feed['icon'], $pd_uid, $pd_username, $feed['title_template'], $feed['title_data'], $feed['body_template'], $feed['body_data'], $feed['body_general'] , '', array());
}

?>
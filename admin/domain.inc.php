<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: domain.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,0,$pd_uid);
switch($action){

	default:
		if($task =='update'){
			auth_task_domain();
		}else{
			$settings['save_domain'] = $settings['save_domain'] ? base64_decode($settings['save_domain']) : '';
			$setting = $settings;
			$settings[suffix_domain] = $settings[suffix_domain] ? substr($settings[suffix_domain],1,strlen($settings[suffix_domain])-1) : 'google.com';
			
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}
?>
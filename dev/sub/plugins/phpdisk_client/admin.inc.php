<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: admin.inc.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
phpdisk_core::admin_login();

switch($action){

	default:
		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'open_phpdisk_client' => 0,
			'client_api_key' => '',
			);
			$settings = gpc('setting','P',$setting);
			
			if(!$settings[client_api_key]){
				$error = true;
				$sysmsg[] = '客户端通信密钥不能为空';
			}
			if(!$error){
				settings_cache($settings);
				$sysmsg[] = __('phpdisk_client_update_success');
				redirect(urr(ADMINCP,"item=plugins&menu=plugin&app=$app"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			require_once template_echo('admin','',$app);
		}
}
update_action_time($app);

?>
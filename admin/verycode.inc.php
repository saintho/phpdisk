<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: verycode.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,13,$pd_uid);
switch($action){

	default:
		if($task =='down_code'){
			form_auth(gpc('formhash','P',''),formhash());
			$setting = array(
			'down_auth_code' => 0,
			'yuc_ads_id' => '',
			'file_downs' => 0,
			);
			$settings = gpc('setting','P',$setting);
			
			settings_cache($settings);
			$sysmsg[] = __('verycode_update_success');
			redirect($_SERVER['HTTP_REFERER'],$sysmsg);

		}elseif($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());
			$setting = array(
			'register_verycode' => 0,
			'login_verycode' => 0,
			'forget_verycode' => 0,
			'verycode_type' => 0,
			);
			$settings = gpc('setting','P',$setting);

			$settings['register_verycode'] = (int)$settings['register_verycode'];
			$settings['login_verycode'] = (int)$settings['login_verycode'];
			$settings['forget_verycode'] = (int)$settings['forget_verycode'];

			settings_cache($settings);

			$sysmsg[] = __('verycode_update_success');

			redirect($_SERVER['HTTP_REFERER'],$sysmsg);
		}else{
			$settings['verycode_type'] = $settings['verycode_type'] ? (int)$settings['verycode_type'] : 1;
			$settings[yuc_ads_id] = $settings[yuc_ads_id] ? $settings[yuc_ads_id] : 'phpdisk_dl_yuc';
			$settings[yxm_private_key] = $settings[yxm_private_key] ? $settings[yxm_private_key] : '5219e11cf5cef8c6fd6a622fe19c4301';
			$settings[yxm_public_key] = $settings[yxm_public_key] ? $settings[yxm_public_key] : '82393b3baca49c60e4f0ea9f7f4f5960';
			$setting = $settings;
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}
?>
<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: union.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,32,$pd_uid);
switch($action){
	
	default:
		
		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());
			$setting = array(
				'open_thunder' => 0,
				'thunder_pid' => '',
				'open_flashget' => 0,
				'flashget_uid' => '',
			);	
			$online_demo = $settings['online_demo'];
			$settings = gpc('setting','P',$setting);
				
			if($online_demo){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				
				settings_cache($settings);
				
				$sysmsg[] = __('union_update_success');
				redirect(urr(ADMINCP,"item=$item"),$sysmsg);
				
			}else{
				redirect('back',$sysmsg);
			}
		
		}else{
			$setting['thunder_pid'] = $settings['thunder_pid'];
			$setting['open_thunder'] = $settings['open_thunder'] ? 1 : 0;
			$setting['flashget_uid'] = $settings['flashget_uid'];
			$setting['open_flashget'] = $settings['open_flashget'] ? 1 : 0;
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}
?>
<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: email.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}

switch($action){
	case 'setting':
admin_no_power($task,11,$pd_uid);
		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$email_pwd_src = trim($settings['email_pwd']);
			$setting = array(
			'open_email' => 0,
			'email_address' => '',
			'email_user' => '',
			'email_pwd' => '',
			'email_smtp' => '',
			'email_port' => '',
			'email_ssl' => 0,
			);
			$online_demo = $settings['online_demo'];
			$settings = gpc('setting','P',$setting);

			if($online_demo){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!checkemail($settings['email_address'])){
				$error = true;
				$sysmsg[] = __('email_address_error');
			}
			if(checklength($settings['email_user'],2,30)){
				$error = true;
				$sysmsg[] = __('email_user_error');
			}
			if(strpos($settings['email_pwd'],'*') ===false){
				if(checklength($settings['email_pwd'],2,20)){
					$error = true;
					$sysmsg[] = __('email_pwd_error');
				}
			}else{
				$settings['email_pwd'] = $email_pwd_src;
			}
			if(checklength($settings['email_smtp'],6,50)){
				$error = true;
				$sysmsg[] = __('email_smtp_error');
			}
			if(!$settings['email_port']){
				$error = true;
				$sysmsg[] = __('email_port_error');
			}else{
				$settings['email_port'] = (int)$settings['email_port'];
			}
			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('email_update_success');
				redirect(urr(ADMINCP,"item=email&menu=$menu&action=$action"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$setting = $settings;
			$setting['email_pwd'] = encode_pwd($setting['email_pwd']);
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'mail_test':
	admin_no_power($task,12,$pd_uid);
		if($task =='mail_test'){
			form_auth(gpc('formhash','P',''),formhash());

			$receive_address = trim(gpc('receive_address','P',''));
			$mail_subject = trim(gpc('mail_subject','P',''));
			$mail_content = trim(gpc('mail_content','P',''));

			if(!checkemail($receive_address)){
				$error = true;
				$sysmsg[] = __('email_address_error');
			}
			if(checklength($mail_subject,2,80)){
				$error = true;
				$sysmsg[] = __('email_subject_error');
			}
			if(checklength($mail_content,2,250)){
				$error = true;
				$sysmsg[] = __('email_content_error');
			}
			if(!$error){
				$to = $receive_address;
				$subject = $mail_subject;
				$body = $mail_content;
				$from = $sender = $username = $settings['email_address'];
				$fromname = $settings['email_user'];
				$host = $settings['email_smtp'];
				$port = (int)$settings['email_port'];
				$ssl = (int)$settings['email_ssl'];
				$password = $settings['email_pwd'];

				send_email($to,$subject,$body,$from,$fromname,$stmp = true, $sender,$host,$port,$ssl,$username,$password);
				$sysmsg[] = __('send_email_success');
				redirect(urr(ADMINCP,"item=email&menu=$menu&action=$action"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}

		}else{
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	default:
		redirect(urr(ADMINCP,"item=email&menu=$menu&action=setting"),'',0);
}
?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: admin.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
phpdisk_core::admin_login();

switch($action){
	case 'order':
		$perpage = 20;
		$sql_do = "{$tpf}vip_orders o,{$tpf}users u where u.userid=o.userid";
		$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;

		$q = $db->query("select o.*,u.username from {$sql_do} order by order_id desc limit $start_num,$perpage");
		$logs = array();
		while($rs = $db->fetch_array($q)){
			$rs['a_edit'] = urr(ADMINCP,"item=plugins&menu=$menu&app=$app&action=edit&order_id={$rs['order_id']}");
			$rs['total_fee'] = $rs['total_fee'] ? '￥'.$rs['total_fee'] : '-';
			$rs['pay_status'] = get_pay_status($rs['pay_status']);
			$rs['in_time'] = date("Y-m-d H:i:s",$rs['in_time']);
			$rs[pay_method] = $payment_arr[$rs[pay_method]];
			$rs['a_space'] = urr(ADMINCP,"item=users&action=user_edit&uid={$rs['userid']}");
			$logs[] = $rs;
		}
		$db->free($q);
		unset($rs);
		$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=plugins&menu=$menu&app=$app&action=$action"));

		require_once template_echo('admin','',$app);
		break;
	case 'edit':
		$order_id = (int)gpc('order_id','GP',0);
		if($task =='edit'){
			form_auth(gpc('formhash','P',''),formhash());
			$pay_status = gpc('pay_status','P','');
			
			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			
			if(!$error){
				$db->query_unbuffered("update {$tpf}vip_orders set pay_status='$pay_status' where order_id='$order_id' limit 1");
				$sysmsg[] = __('update_pay_status_success');
				redirect(urr(ADMINCP,"item=plugins&menu=$menu&app=$app&action=order"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$rs = $db->fetch_one_array("select o.*,u.username from {$tpf}vip_orders o,{$tpf}users u where o.userid=u.userid and order_id='$order_id'");
			if($rs){
				$rs['total_fee'] = $rs['total_fee'] ? '￥'.$rs['total_fee'] : '-';
				$rs['in_time'] = date("Y-m-d H:i:s",$rs['in_time']);
				$rs['a_space'] = urr(ADMINCP,"item=users&action=user_edit&uid={$rs['userid']}");
			}
			require_once template_echo('admin','',$app);
		}
		break;
	default:

		if($task =='alipay'){
			form_auth(gpc('formhash','P',''),formhash());

			$ali_security_code_src = trim($settings['ali_security_code']);
			$setting = array(
			'open_alipay' => 0,
			'ali_partner' => '',
			'ali_security_code' => '',
			'ali_seller_email' => '',
			);
			$online_demo = $settings['online_demo'];
			$settings = gpc('setting','P',$setting);

			if($online_demo){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$settings['ali_partner']){
				$error = true;
				$sysmsg[] = __('ali_partner_error');
			}
			if(strpos($settings['ali_security_code'],'*') ===false){
				if(!$settings['ali_security_code']){
					$error = true;
					$sysmsg[] = __('ali_security_code_error');
				}
			}else{
				$settings['ali_security_code'] = $ali_security_code_src;
			}
			if(!trim($settings['ali_seller_email'])){
				$error = true;
				$sysmsg[] = __('ali_seller_email_error');
			}
			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('payment_update_success');
				redirect(urr(ADMINCP,"item=plugins&menu=$menu&app=$app"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='tenpay'){
			form_auth(gpc('formhash','P',''),formhash());

			$ten_key_src = trim($settings['ten_key']);
			$setting = array(
			'open_tenpay' => 0,
			'ten_mch' => '',
			'ten_key' => '',
			);
			$online_demo = $settings['online_demo'];
			$settings = gpc('setting','P',$setting);

			if($online_demo){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$settings['ten_mch']){
				$error = true;
				$sysmsg[] = __('ten_mch_error');
			}
			if(strpos($settings['ten_key'],'*') ===false){
				if(!$settings['ten_key']){
					$error = true;
					$sysmsg[] = __('ten_key_error');
				}
			}else{
				$settings['ten_key'] = $ten_key_src;
			}
			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('payment_update_success');
				redirect(urr(ADMINCP,"item=plugins&menu=$menu&app=$app"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='chinabank'){
			form_auth(gpc('formhash','P',''),formhash());

			$chinabank_key_src = trim($settings['chinabank_key']);
			$setting = array(
			'open_chinabank' => 0,
			'chinabank_mch' => '',
			'chinabank_key' => '',
			);
			$online_demo = $settings['online_demo'];
			$settings = gpc('setting','P',$setting);

			if($online_demo){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$settings['chinabank_mch']){
				$error = true;
				$sysmsg[] = __('chinabank_mch_error');
			}
			if(strpos($settings['chinabank_key'],'*') ===false){
				if(!$settings['chinabank_key']){
					$error = true;
					$sysmsg[] = __('chinabank_key_error');
				}
			}else{
				$settings['chinabank_key'] = $chinabank_key_src;
			}
			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('payment_update_success');
				redirect(urr(ADMINCP,"item=plugins&menu=$menu&app=$app"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='yeepay'){
			form_auth(gpc('formhash','P',''),formhash());

			$yeepay_key_src = trim($settings['yeepay_key']);
			$setting = array(
			'open_yeepay' => 0,
			'yeepay_mch' => '',
			'yeepay_key' => '',
			);
			$online_demo = $settings['online_demo'];
			$settings = gpc('setting','P',$setting);

			if($online_demo){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$settings['yeepay_mch']){
				$error = true;
				$sysmsg[] = __('yeepay_mch_error');
			}
			if(strpos($settings['yeepay_key'],'*') ===false){
				if(!$settings['yeepay_key']){
					$error = true;
					$sysmsg[] = __('yeepay_key_error');
				}
			}else{
				$settings['yeepay_key'] = $yeepay_key_src;
			}
			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('payment_update_success');
				redirect(urr(ADMINCP,"item=plugins&menu=$menu&app=$app"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'open_payment' => 0,
			);
			$settings = gpc('setting','P',$setting);

			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('payment_update_success');
				redirect(urr(ADMINCP,"item=plugins&menu=$menu&app=$app"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$setting = $settings;
			$settings['ali_security_code'] = encode_pwd($settings['ali_security_code']);
			$settings['ten_key'] = encode_pwd($settings['ten_key']);
			$settings['chinabank_key'] = encode_pwd($settings['chinabank_key']);
			$settings['yeepay_key'] = encode_pwd($settings['yeepay_key']);
			require_once template_echo('admin','',$app);
		}
}
update_action_time($app);
?>
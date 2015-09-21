<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: vip.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

if(!$auth[buy_vip_a] && !$auth[buy_vip_p]){
	exit(msg::umsg('Not_FMS',__('zcore_no_power')));
}
if(!$settings[open_vip]){
	exit(msg::umsg('Not_VIP_MODE',__('zcore_no_power')));
}
$in_front = true;

$title = __('buy_vip').' - '.$settings['site_title'];
include PHPDISK_ROOT."./includes/header.inc.php";
/*
$vip_id = get_profile($pd_uid,'vip_id');
if($vip_id){
	$vip_end_time = get_profile($pd_uid,'vip_end_time');
	if($vip_end_time>$timestamp){
		$vip_end_time_txt = date('Y-m-d',get_profile($pd_uid,'vip_end_time'));
	}else{
		$vip_end_time_txt = date('Y-m-d',get_profile($pd_uid,'vip_end_time')).', <span class="txtred">('.__('vip_end_time_expire').')</span>';
	}
	$my_vip = __('my_vip_is').get_vip($vip_id,'subject').' , '.$vip_end_time_txt;
}else{
	$my_vip = __('my_vip_is').__('no_vip_yet');
}
*/
switch($action){
	case 'buy_vip':
		$money = (float)gpc('money','P',0);
		$vip_id = (int)gpc('vip_id','P',0);

		/*if(!$can_buy_vip){
		die(__('you_are_vip'));
		}*/
		$num = @$db->result_first("select count(*) from {$tpf}vips where vip_id='$vip_id' and price='$money' limit 1");
		if(!$num){
			$error = true;
			$sysmsg[] = '参数验证未通过，请返回重试';
			$log = '<? exit; ?>POST:'.var_export($_POST).LF;
			$log .= '<? exit; ?>GET:'.var_export($_GET).LF;
			$log .= '<? exit; ?>SERVER:'.var_export($_SERVER).LF;
			$log .= '------------------------------'.LF;
			write_file(PHPDISK_ROOT.'system/buy_vip.log.php',$log,'ab+');
		}
		if(!$task || !$money || !$vip_id){
			die(__('money_or_payment_method_not_select'));
		}else{
			if(!$money){
				$error = false;
				$sysmsg[] = __('money_invalid');
			}
			$money = $money ? $money : 1;
		}

		if($task == 'mywealth'){
			form_auth(gpc('formhash','P',''),formhash());

			if(get_profile($pd_uid,'wealth')<$money){
				$error = true;
				$sysmsg[] = __('mywealth_too_small');
			}
			if(!$error){
				$my_order = 'm'.get_order_number();
				$num = @$db->result_first("select count(*) from {$tpf}vip_orders where order_number='$my_order' and pay_method='$task' and userid='$pd_uid'");
				if(!$num){
					$ins = array(
					'pay_method' => $task,
					'userid' => $pd_uid,
					'vip_id' => $vip_id,
					'order_number' => $my_order,
					'total_fee' => $money,
					'pay_status' => 'pendding',
					'in_time' => $timestamp,
					'ip' => $onlineip,
					);
					$db->query_unbuffered("insert into {$tpf}vip_orders set ".$db->sql_array($ins).";");
				}
				$db->query_unbuffered("update {$tpf}users set wealth=wealth-$money where userid='$pd_uid'");
				$md5_sign = md5($my_order.$money.$pd_uid.$task);
				echo '<div align="center">'.__('buy_vip_doing').'</div>';
				echo '<script>document.location="'.urr("payment","action=$task&order_number=$my_order&sign=$md5_sign").'";</script>';
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task == 'alipay'){
			form_auth(gpc('formhash','P',''),formhash());

			if(!$error){
				require_once PD_PLUGINS_DIR."payment/alipay/alipay_config.php";
				require_once PD_PLUGINS_DIR."payment/alipay/class/alipay_service.php";

				$out_trade_no = date('YmdHis');

				$parameter = array(
				"service"			=> "create_direct_pay_by_user",	//接口名称，不需要修改
				"payment_type"		=> "1",               			//交易类型，不需要修改

				//获取配置文件(alipay_config.php)中的值
				"partner"			=> $partner,
				"seller_email"		=> $seller_email,
				"return_url"		=> $return_url,
				"notify_url"		=> $notify_url,
				"_input_charset"	=> $_input_charset,
				"show_url"			=> $show_url,

				//从订单数据中动态获取到的必填参数
				"out_trade_no"		=> $out_trade_no,
				"subject" => $settings['site_title'].' '.__('ali_subject_pay'),
				"body" => __('ali_body_pay').' '.$money.' RMB',
				"total_fee"			=> $money,

				//扩展功能参数——网银提前
				"paymethod"			=> 'directPay',
				"defaultbank"		=> $defaultbank,

				//扩展功能参数——防钓鱼
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,

				//扩展功能参数——自定义参数
				"buyer_email"		=> $buyer_email,
				"extra_common_param"=> $extra_common_param,

				//扩展功能参数——分润
				"royalty_type"		=> $royalty_type,
				"royalty_parameters"=> $royalty_parameters
				);
				//
				$num = @$db->result_first("select count(*) from {$tpf}vip_orders where order_number='$out_trade_no' and pay_method='$task' and userid='$pd_uid'");
				if(!$num){
					$ins = array(
					'pay_method' => $task,
					'userid' => $pd_uid,
					'vip_id' => $vip_id,
					'order_number' => $out_trade_no,
					'total_fee' => $money,
					'pay_status' => 'pendding',
					'in_time' => $timestamp,
					'ip' => $onlineip,
					);
					$db->query_unbuffered("insert into {$tpf}vip_orders set ".$db->sql_array($ins).";");
				}
				$alipay = new alipay_service($parameter,$key,$sign_type);
				$sHtmlText = $alipay->build_form();
				echo $sHtmlText;

			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='tenpay'){
			form_auth(gpc('formhash','P',''),formhash());

			if(!$error){

				include_once PD_PLUGINS_DIR."payment/tenpay/PayRequestHandler.class.php";

				$bargainor_id = $settings['ten_mch'];
				$key = $settings['ten_key'];
				$return_url = $settings['phpdisk_url']."payment.php?action=tenpay";
				$strDate = date("Ymd");
				$strTime = date("His");
				$randNum = rand(1000, 9999);
				$strReq = $strTime . $randNum;
				$sp_billno = $strReq;
				$transaction_id = $bargainor_id . $strDate . $strReq;
				$total_fee = $money*100;
				$desc = __('ali_body_pay').'&nbsp;'.$money.'&nbsp;RMB';

				$num = @$db->result_first("select count(*) from {$tpf}vip_orders where order_number='$transaction_id' and pay_method='$task' and userid='$pd_uid'");
				if(!$num){
					$ins = array(
					'pay_method' => $task,
					'userid' => $pd_uid,
					'vip_id' => $vip_id,
					'order_number' => $transaction_id,
					'total_fee' => $money,
					'pay_status' => 'pendding',
					'in_time' => $timestamp,
					'ip' => $onlineip,
					);
					$db->query("insert into {$tpf}vip_orders set ".$db->sql_array($ins).";");
				}
				$reqHandler = new PayRequestHandler();
				$reqHandler->init();
				$reqHandler->setKey($key);

				$reqHandler->setParameter("bargainor_id", $bargainor_id);
				$reqHandler->setParameter("sp_billno", $sp_billno);
				$reqHandler->setParameter("transaction_id", $transaction_id);
				$reqHandler->setParameter("total_fee", $total_fee);
				$reqHandler->setParameter("return_url", $return_url);
				$reqHandler->setParameter("desc", iconv('utf-8','gbk',$desc));

				$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);
				$reqUrl = $reqHandler->getRequestURL();
				header("Location: $reqUrl");
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='chinabank'){
			form_auth(gpc('formhash','P',''),formhash());

			if(!$error){
				$go_url = "plugins/payment/chinabank/Send.php?v_amount=$money&vip_id=$vip_id";
				echo "<script>window.location =\"$go_url\";</script>";
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='yeepay'){
			form_auth(gpc('formhash','P',''),formhash());

			if(!$error){
				$go_url = "plugins/payment/yeepay/req.php?p3_Amt=$money&vip_id=$vip_id";
				echo "<script>window.location =\"$go_url\";</script>";
			}else{
				redirect('back',$sysmsg);
			}
		}
		break;

	default:
		$q = $db->query("select * from {$tpf}vips where is_hidden=0 order by show_order asc,vip_id asc");
		$vips = array();
		while ($rs = $db->fetch_array($q)) {
			$rs['status_text'] = $rs['is_hidden'] ? '<span class="txtred">'.__('hidden').'</span>' : '<span class="txtblue">'.__('display').'</span>';
			$rs[img] = $rs[img] ? '<img src="{$rs[img]}" border="0" />' : '&nbsp;';
			$rs[pop_ads] = $rs[pop_ads] ? __('yes') : __('no');
			$rs[search_down] = $rs[search_down] ? __('only_search_public') : __('search_and_down');
			$vips[] = $rs;
		}
		$db->free($q);
		unset($rs);

		require_once template_echo('pd_vip',$user_tpl_dir);
}

include PHPDISK_ROOT."./includes/footer.inc.php";

?>
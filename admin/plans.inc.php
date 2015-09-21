<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: plans.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,8,$pd_uid);
switch($action){
	case 'add':
		if($task =='add'){
			form_auth(gpc('formhash','P',''),formhash());
			$subject = trim(gpc('subject','P',''));
			$content = trim(gpc('content','P',''));
			$memo = trim(gpc('memo','P',''));
			$space_code = trim(gpc('space_code','P',''));
			$viewfile_code = trim(gpc('viewfile_code','P',''));
			$download_code = trim(gpc('download_code','P',''));
			$download_code_top = trim(gpc('download_code_top','P',''));
			$download_code_left = trim(gpc('download_code_left','P',''));
			$download_code_bottom = trim(gpc('download_code_bottom','P',''));
			$income_rate_credit = trim(gpc('income_rate_credit','P',''));
			$income_rate_money = trim(gpc('income_rate_money','P',''));
			$is_hidden = (int)gpc('is_hidden','P',0);
			$discount = (float)gpc('discount','P','');
			$discount = $auth[plan_discount] ? $discount : 0;
			if($auth[open_second_page]){
				$open_second_page = (int)gpc('open_second_page','P',0);
			}else{
				$open_second_page = 1;
			}
			if($auth[open_plan_active]){
				$down_active_num_max = (int)gpc('down_active_num_max','P',0);
				$down_active_num_min = (int)gpc('down_active_num_min','P',0);
			}else{
				$down_active_num_max = 0;
				$down_active_num_min = 0;
			}
			$ip_interval = (int)gpc('ip_interval','P',0);

			if(checklength($subject,2,150)){
				$error = true;
				$sysmsg[] = __('plans_subject_error');
			}else{
				$num = @$db->result_first("select count(*) from {$tpf}plans where subject='$subject'");
				if($num){
					$error = true;
					$sysmsg[] = __('plans_subject_exists');
				}
			}
			if(checklength($content,2,1000)){
				$error = true;
				$sysmsg[] = __('plans_content_error');
			}
			if(!$income_rate_credit || !$income_rate_money){
				$error = true;
				$sysmsg[] = __('plans_income_rate_error');
			}else{
				$income_rate = $income_rate_credit.','.$income_rate_money;
			}
			if(!is_numeric($ip_interval)){
				$error = true;
				$sysmsg[] = __('plans_ip_interval_error');
			}
			if($auth[open_plan_active] && $settings[open_plan_active]){
				if(!$down_active_num_max || !$down_active_num_min){
					$error = true;
					$sysmsg[] = __('down_active_num_error');
				}elseif($down_active_num_max<=$down_active_num_min){
					$error = true;
					$sysmsg[] = __('down_active_num_min_max');
				}
			}
			if(!$error){
				$ins = array(
				'subject'=>$subject,
				'content'=>$content,
				'space_code'=>$space_code ? base64_encode($space_code) : '',
				'viewfile_code'=>$viewfile_code ? base64_encode($viewfile_code) : '',
				'download_code'=>$download_code ? base64_encode($download_code) : '',
				'download_code_top'=>$download_code_top ? base64_encode($download_code_top) : '',
				'download_code_left'=>$download_code_left ? base64_encode($download_code_left) : '',
				'download_code_bottom'=>$download_code_bottom ? base64_encode($download_code_bottom) : '',
				'memo'=>$memo,
				'income_rate'=>$income_rate,
				'down_active_num_max'=>$down_active_num_max,
				'down_active_num_min'=>$down_active_num_min,
				'is_hidden'=>$is_hidden,
				'discount'=>$discount,
				'open_second_page'=>$open_second_page,
				'ip_interval'=>$ip_interval,
				);
				$db->query_unbuffered("insert into {$tpf}plans set ".$db->sql_array($ins)."");
				$sysmsg[] = __('add_plans_success');
				redirect(urr(ADMINCP,"item=plans&menu=user&action=list"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$pa = array();
			$pa[is_hidden] = 0;
			$pa[open_second_page] = 1;
			$pa[ip_interval] = 24;
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'edit':
		$plan_id = (int)gpc('plan_id','GP',0);
		if($task=='edit'){
			form_auth(gpc('formhash','P',''),formhash());
			$subject = trim(gpc('subject','P',''));
			$content = trim(gpc('content','P',''));
			$memo = trim(gpc('memo','P',''));
			$space_code = trim(gpc('space_code','P',''));
			$viewfile_code = trim(gpc('viewfile_code','P',''));
			$download_code = trim(gpc('download_code','P',''));
			$download_code_top = trim(gpc('download_code_top','P',''));
			$download_code_left = trim(gpc('download_code_left','P',''));
			$download_code_bottom = trim(gpc('download_code_bottom','P',''));
			$income_rate_credit = trim(gpc('income_rate_credit','P',''));
			$income_rate_money = trim(gpc('income_rate_money','P',''));
			$is_hidden = (int)gpc('is_hidden','P',0);
			$discount = (float)gpc('discount','P','');
			$discount = $auth[plan_discount] ? $discount : 0;
			if($auth[open_second_page]){
				$open_second_page = (int)gpc('open_second_page','P',0);
			}else{
				$open_second_page = 1;
			}
			if($auth[open_plan_active]){
				$down_active_num_max = (int)gpc('down_active_num_max','P',0);
				$down_active_num_min = (int)gpc('down_active_num_min','P',0);
			}else{
				$down_active_num_max = 0;
				$down_active_num_min = 0;
			}
			$ip_interval = (int)gpc('ip_interval','P',0);

			if(checklength($subject,2,150)){
				$error = true;
				$sysmsg[] = __('plans_subject_error');
			}else{
				$num = @$db->result_first("select count(*) from {$tpf}plans where subject='$subject' and plan_id<>'$plan_id'");
				if($num){
					$error = true;
					$sysmsg[] = __('plans_subject_exists');
				}
			}
			if(checklength($content,2,1000)){
				$error = true;
				$sysmsg[] = __('plans_content_error');
			}
			if(!$income_rate_credit || !$income_rate_money){
				$error = true;
				$sysmsg[] = __('plans_income_rate_error');
			}else{
				$income_rate = $income_rate_credit.','.$income_rate_money;
			}
			if(!is_numeric($ip_interval)){
				$error = true;
				$sysmsg[] = __('plans_ip_interval_error');
			}
			if($auth[open_plan_active] && $settings[open_plan_active]){
				if(!$down_active_num_max || !$down_active_num_min){
					$error = true;
					$sysmsg[] = __('down_active_num_error');
				}elseif($down_active_num_max<=$down_active_num_min){
					$error = true;
					$sysmsg[] = __('down_active_num_min_max');
				}
			}
			if(!$error){
				$ins = array(
				'subject'=>$subject,
				'content'=>$content,
				'space_code'=>$space_code ? base64_encode($space_code) : '',
				'viewfile_code'=>$viewfile_code ? base64_encode($viewfile_code) : '',
				'download_code'=>$download_code ? base64_encode($download_code) : '',
				'download_code_top'=>$download_code_top ? base64_encode($download_code_top) : '',
				'download_code_left'=>$download_code_left ? base64_encode($download_code_left) : '',
				'download_code_bottom'=>$download_code_bottom ? base64_encode($download_code_bottom) : '',
				'memo'=>$memo,
				'income_rate'=>$income_rate,
				'down_active_num_max'=>$down_active_num_max,
				'down_active_num_min'=>$down_active_num_min,
				'is_hidden'=>$is_hidden,
				'discount'=>$discount,
				'open_second_page'=>$open_second_page,
				'ip_interval'=>$ip_interval,
				);
				$db->query_unbuffered("update {$tpf}plans set ".$db->sql_array($ins)." where plan_id='$plan_id'");
				$db->query_unbuffered("update {$tpf}users set credit_rate='".get_plans($plan_id,'income_rate')."' where plan_id='$plan_id'");
				$sysmsg[] = __('edit_plans_success');
				redirect(urr(ADMINCP,"item=plans&menu=user&action=list"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$pa = $db->fetch_one_array("select * from {$tpf}plans where plan_id='$plan_id'");
			$pa[space_code] = $pa[space_code] ? stripslashes(base64_decode($pa[space_code])) : '';
			$pa[viewfile_code] = $pa[viewfile_code] ? stripslashes(base64_decode($pa[viewfile_code])) : '';
			$pa[download_code] = $pa[download_code] ? stripslashes(base64_decode($pa[download_code])) : '';
			$pa[download_code_top] = $pa[download_code_top] ? stripslashes(base64_decode($pa[download_code_top])) : '';
			$pa[download_code_left] = $pa[download_code_left] ? stripslashes(base64_decode($pa[download_code_left])) : '';
			$pa[download_code_bottom] = $pa[download_code_bottom] ? stripslashes(base64_decode($pa[download_code_bottom])) : '';
			if($pa[income_rate]){
				$arr = explode(',',$pa[income_rate]);
				if(count($arr)){
					$pa[income_rate_credit] = $arr[0];
					$pa[income_rate_money] = $arr[1];
				}
			}
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'truncate':
		$plan_id = (int)gpc('plan_id','G',0);
		if($plan_id){
			$q = $db->query("select userid from {$tpf}users where plan_id='$plan_id' order by userid asc limit 3");
			$num = $db->num_rows($q);
			if($num){
				while ($rs = $db->fetch_array($q)) {
					conv_credit($rs[userid]);
					$db->query_unbuffered("update {$tpf}users set plan_id=0,credit_rate='' where userid='{$rs[userid]}'");
				}
				$db->free($q);
				unset($rs);
				$sysmsg[] = __('plans_truncate_running');
				redirect(urr(ADMINCP,"item=$item&menu=user&action=$action&plan_id=$plan_id"),$sysmsg);
			}else{
				$sysmsg[] = __('plans_truncate_success');
				redirect(urr(ADMINCP,"item=$item&menu=user&action=list"),$sysmsg);
			}
		}else{
			$sysmsg[] = __('plans_truncate_fail');
			redirect('back',$sysmsg);
		}
		break;
	case 'del':
		$plan_id = (int)gpc('plan_id','G',0);
		if(get_plan_users($plan_id)){
			$sysmsg[] = __('plans_has_user');
			redirect('back',$sysmsg);
		}else{
			if($plan_id){
				$db->query_unbuffered("delete from {$tpf}plans where plan_id='$plan_id'");
			}
			$sysmsg[] = __('plans_del_success');
			redirect('back',$sysmsg);
		}
		break;
	case 'change_status':
		$plan_id = (int)gpc('plan_id','G',0);
		
		$is_hidden = (int)@$db->result_first("select is_hidden from {$tpf}plans where plan_id='$plan_id'");
		$is_hidden = $is_hidden ? 0 : 1;
		$db->query_unbuffered("update {$tpf}plans set is_hidden=$is_hidden where plan_id='$plan_id'");
		$sysmsg[] = __('plans_change_status_success');
		redirect('back',$sysmsg);

		break;
	case 'set_plan':
		$plan_id = (int)gpc('plan_id','G',0);
		if($plan_id && $auth[plan_set_default]){
			$db->query_unbuffered("update {$tpf}plans set is_default=0");
			$db->query_unbuffered("update {$tpf}plans set is_default=1 where plan_id='$plan_id' limit 1");
			$sysmsg[] = __('set_plan_default_success');
			redirect('back',$sysmsg);
		}
		break;
	case 'cancel_default':
		if($auth[plan_set_default]){
			$db->query_unbuffered("update {$tpf}plans set is_default=0");
			$sysmsg[] = __('set_plan_cancel_default_success');
			redirect('back',$sysmsg);
		}
		break;
	default:
		if($task=='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$show_order = gpc('show_order','P',array());
			$plan_ids = gpc('plan_ids','P',array());
			if($auth[open_plan_active]){
				$setting = array(
				'open_plan_active' => 0,
				'down_active_interval' => '',
				);
				$settings = gpc('setting','P',$setting);
				settings_cache($settings);
			}

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				for($i =0;$i<count($plan_ids);$i++){
					$db->query_unbuffered("update {$tpf}plans set show_order='".(int)$show_order[$i]."' where plan_id='".(int)$plan_ids[$i]."'");
				}
				redirect(urr(ADMINCP,"item=$item&menu=user&action=list"),'',0);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$q = $db->query("select * from {$tpf}plans order by show_order asc,plan_id asc");
			$plans = array();
			while ($rs = $db->fetch_array($q)) {
				$rs[user_count] = get_plan_users($rs[plan_id]);
				$rs[is_default] = $rs[is_default] ? '<span class="txtgreen">'.__('set_default').'</span>' : '';
				$rs['status_text'] = $rs['is_hidden'] ? '<span class="txtred">'.__('hidden').'</span>' : '<span class="txtblue">'.__('display').'</span>';
				$rs['a_change_status'] = urr(ADMINCP,"item=$item&menu=user&action=change_status&plan_id={$rs['plan_id']}");
				$rs['a_edit_plan'] = urr(ADMINCP,"item=$item&menu=user&action=edit&plan_id={$rs['plan_id']}");
				$rs['a_truncate_plan'] = urr(ADMINCP,"item=$item&menu=user&action=truncate&plan_id={$rs['plan_id']}");
				$rs['a_del_plan'] = urr(ADMINCP,"item=$item&menu=user&action=del&plan_id={$rs['plan_id']}");
				$rs[a_set_plan] = urr(ADMINCP,"item=$item&menu=user&action=set_plan&plan_id={$rs['plan_id']}");
				$plans[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$settings[down_active_interval] = $settings[down_active_interval] ? $settings[down_active_interval] : 'day';
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}
function get_plan_users($plan_id){
	global $db,$tpf;
	return @$db->result_first("select count(*) from {$tpf}users where plan_id='$plan_id'");
}
?>
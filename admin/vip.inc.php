<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: vip.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}

!($auth[buy_vip_p] || $auth[buy_vip_a]) && exit(msg::umsg('Not_vip',__('zcore_no_power')));
admin_no_power($task,0,$pd_uid);
switch($action){
	case 'add':
		if($task =='add'){
			form_auth(gpc('formhash','P',''),formhash());
			$subject = trim(gpc('subject','P',''));
			$content = trim(gpc('content','P',''));
			$img = trim(gpc('img','P',''));
			$price = trim(gpc('price','P',''));
			$days = gpc('days','P','');
			$pop_ads = (int)gpc('pop_ads','P',0);
			$down_second = (int)gpc('down_second','P',0);
			$downline_num = (int)gpc('downline_num','P',0);
			$search_down = (int)gpc('search_down','P',0);
			$img_link = (int)gpc('img_link','P',0);
			$music_link = (int)gpc('music_link','P',0);
			$video_link = (int)gpc('video_link','P',0);
			$zero_store_time = (int)gpc('zero_store_time','P',0);
			$is_hidden = (int)gpc('is_hidden','P',0);

			if(checklength($subject,2,150)){
				$error = true;
				$sysmsg[] = __('vip_subject_error');
			}else{
				$num = @$db->result_first("select count(*) from {$tpf}vips where subject='$subject'");
				if($num){
					$error = true;
					$sysmsg[] = __('vip_subject_exists');
				}
			}
			if(checklength($content,2,255)){
				$error = true;
				$sysmsg[] = __('vip_content_error');
			}

			if(!$error){
				$ins = array(
				'subject'=>$subject,
				'content'=>$content,
				'img'=>$img,
				'price'=>(float)$price,
				'days'=>$days,
				'pop_ads'=>$pop_ads,
				'down_second'=>$down_second,
				'downline_num'=>$downline_num,
				'search_down'=>$search_down,
				'img_link'=>$img_link,
				'music_link'=>$music_link,
				'video_link'=>$video_link,
				'zero_store_time'=>$zero_store_time,
				'is_hidden'=>$is_hidden,
				);
				$db->query_unbuffered("insert into {$tpf}vips set ".$db->sql_array($ins)."");
				$sysmsg[] = __('add_vip_success');
				redirect(urr(ADMINCP,"item=vip&menu=user&action=list"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'edit':
		$vip_id = (int)gpc('vip_id','GP',0);
		if($task=='edit'){
			form_auth(gpc('formhash','P',''),formhash());
			$subject = trim(gpc('subject','P',''));
			$content = trim(gpc('content','P',''));
			$img = trim(gpc('img','P',''));
			$price = trim(gpc('price','P',''));
			$days = gpc('days','P','');
			$pop_ads = (int)gpc('pop_ads','P',0);
			$down_second = (int)gpc('down_second','P',0);
			$downline_num = (int)gpc('downline_num','P',0);
			$search_down = (int)gpc('search_down','P',0);
			$img_link = (int)gpc('img_link','P',0);
			$music_link = (int)gpc('music_link','P',0);
			$video_link = (int)gpc('video_link','P',0);
			$zero_store_time = (int)gpc('zero_store_time','P',0);
			$is_hidden = (int)gpc('is_hidden','P',0);

			if(checklength($subject,2,150)){
				$error = true;
				$sysmsg[] = __('vip_subject_error');
			}else{
				$num = @$db->result_first("select count(*) from {$tpf}vips where subject='$subject' and vip_id<>'$vip_id'");
				if($num){
					$error = true;
					$sysmsg[] = __('vip_subject_exists');
				}
			}
			if(checklength($content,2,255)){
				$error = true;
				$sysmsg[] = __('vip_content_error');
			}			
			if(!$error){
				$ins = array(
				'subject'=>$subject,
				'content'=>$content,
				'img'=>$img,
				'price'=>(float)$price,
				'days'=>$days,
				'pop_ads'=>$pop_ads,
				'down_second'=>$down_second,
				'downline_num'=>$downline_num,
				'search_down'=>$search_down,
				'img_link'=>$img_link,
				'music_link'=>$music_link,
				'video_link'=>$video_link,
				'zero_store_time'=>$zero_store_time,
				'is_hidden'=>$is_hidden,
				);
				$db->query_unbuffered("update {$tpf}vips set ".$db->sql_array($ins)." where vip_id='$vip_id'");
				$sysmsg[] = __('edit_vip_success');
				redirect(urr(ADMINCP,"item=vip&menu=user&action=list"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$pa = $db->fetch_one_array("select * from {$tpf}vips where vip_id='$vip_id'");			
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'del':
		$vip_id = (int)gpc('vip_id','G',0);
		if(get_active_users($vip_id)){
			$sysmsg[] = __('vip_has_user_del');
			redirect('back',$sysmsg);
		}else{
			if($vip_id){
				$db->query_unbuffered("delete from {$tpf}vips where vip_id='$vip_id'");
			}
			$sysmsg[] = __('vip_del_success');
			redirect('back',$sysmsg);
		}
		break;
	case 'change_status':
		$vip_id = (int)gpc('vip_id','G',0);
			$is_hidden = (int)@$db->result_first("select is_hidden from {$tpf}vips where vip_id='$vip_id'");
			$is_hidden = $is_hidden ? 0 : 1;
			$db->query_unbuffered("update {$tpf}vips set is_hidden=$is_hidden where vip_id='$vip_id'");
			$sysmsg[] = __('vip_change_status_success');
			redirect('back',$sysmsg);
		break;
	default:
		if($task=='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$show_order = gpc('show_order','P',array());
			$vip_ids = gpc('vip_ids','P',array());
			$setting = array(
			'open_vip' => 0,
			);
			$settings = gpc('setting','P',$setting);
			settings_cache($settings);

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				for($i =0;$i<count($vip_ids);$i++){
					$db->query_unbuffered("update {$tpf}vips set show_order='".(int)$show_order[$i]."' where vip_id='".(int)$vip_ids[$i]."'");
				}
				redirect(urr(ADMINCP,"item=$item&menu=user&action=list"),'',0);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$q = $db->query("select * from {$tpf}vips order by show_order asc,vip_id asc");
			$vips = array();
			while ($rs = $db->fetch_array($q)) {
				$rs['status_text'] = $rs['is_hidden'] ? '<span class="txtred">'.__('hidden').'</span>' : '<span class="txtblue">'.__('display').'</span>';
				$rs[img] = $rs[img] ? '<img src="{$rs[img]}" border="0" />' : '';
				$rs[pop_ads] = $rs[pop_ads] ? __('yes') : __('no');
				$rs[search_down] = $rs[search_down] ? __('only_search_public') : __('search_and_down');
				$rs['a_change_status'] = urr(ADMINCP,"item=$item&menu=user&action=change_status&vip_id={$rs['vip_id']}");
				$rs['a_edit_vip'] = urr(ADMINCP,"item=$item&menu=user&action=edit&vip_id={$rs['vip_id']}");
				$rs['a_del_vip'] = urr(ADMINCP,"item=$item&menu=user&action=del&vip_id={$rs['vip_id']}");
				$vips[] = $rs;
			}
			$db->free($q);
			unset($rs);

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}
function get_vip_users($vip_id){
	global $db,$tpf;
	return @$db->result_first("select count(*) from {$tpf}users where vip_id='$vip_id'");
}
function get_active_users($vip_id){
	global $db,$tpf,$timestamp;
	return @$db->result_first("select count(*) from {$tpf}users where vip_id='$vip_id' and vip_end_time>'$timestamp'");
}
?>
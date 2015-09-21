<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: advertisement.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}

admin_no_power($task,28,$pd_uid);

switch($action){

	case 'add_adv':

		$adv_position = gpc('adv_position','GP','');
		$adv_type = gpc('adv_type','GP','');

		if($task =='add_adv'){
			form_auth(gpc('formhash','P',''),formhash());

			$adv_title = trim(gpc('adv_title','P',''));
			$adv_starttime = trim(gpc('adv_starttime','P',''));
			$adv_endtime = trim(gpc('adv_endtime','P',''));
			$adv_scope = gpc('adv_scope','P',array());
			$params = array();
			$code = '';

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			$tmp = '';
			for($i=0;$i<count($adv_scope);$i++){
				$tmp .= $adv_scope[$i].',';
			}
			$params['adv_scope'] = substr($tmp,-1)==',' ? substr($tmp,0,-1) : $tmp;
			switch($adv_type){
				case 'adv_code':
					$code = trim(gpc('adv_html_code','P',''));
					if(strpos($code,"\\\'")!==false){
						$error = true;
						$sysmsg[] = "广告代码含有非法字符 <b class=txtred>\'</b> ，请返回修改";
					}
					break;
				case 'adv_text':
					$params['adv_txt_title'] = trim(gpc('adv_txt_title','P',''));
					$params['adv_txt_url'] = trim(gpc('adv_txt_url','P',''));
					$params['adv_txt_size'] = trim(gpc('adv_txt_size','P',''));
					$params['adv_txt_color'] = trim(gpc('adv_txt_color','P',''));

					if(!$params['adv_txt_title'] || !$params['adv_txt_url']){
						$error = true;
						$sysmsg[] = __('adv_txt_error');
					}
					break;
				case 'adv_flash':
					$params['adv_flash_src'] = trim(gpc('adv_flash_src','P',''));
					$params['adv_flash_width'] = trim(gpc('adv_flash_width','P',''));
					$params['adv_flash_height'] = trim(gpc('adv_flash_height','P',''));
					if(!$params['adv_flash_src']){
						$error = true;
						$sysmsg[] = __('adv_flash_src_error');
					}
					if(!is_numeric($params['adv_flash_width']) || !is_numeric($params['adv_flash_height'])){
						$error = true;
						$sysmsg[] = __('adv_flash_number_error');
					}
					break;
				default:
					$params['adv_img_src'] = trim(gpc('adv_img_src','P',''));
					$params['adv_img_url'] = trim(gpc('adv_img_url','P',''));
					$params['adv_img_width'] = trim(gpc('adv_img_width','P',''));
					$params['adv_img_height'] = trim(gpc('adv_img_height','P',''));
					$params['adv_img_alt'] = trim(gpc('adv_img_alt','P',''));
					if(!$params['adv_img_src']){
						$error = true;
						$sysmsg[] = __('adv_img_src_error');
					}
					if(!$params['adv_img_url']){
						$error = true;
						$sysmsg[] = __('adv_img_url_error');
					}
			}
			$params = $params ? serialize($params) : '';

			if(checklength($adv_title,2,300)){
				$error = true;
				$sysmsg[] = __('adv_title_error');
			}
			if($adv_starttime){
				$arr = explode('-',$adv_starttime);
				$tmp_count = count($arr)-1;
				if(strlen($adv_starttime) !=10 || $tmp_count !=2 || ((int)$arr[0] < date('Y'))){
					$error = true;
					$sysmsg[] = __('time_format_error');
				}else{
					$adv_starttime = @mktime(0,0,0,(int)$arr[1],(int)$arr[2],(int)$arr[0]);
				}
			}else{
				$adv_starttime = 0;
			}
			if($adv_endtime){
				$arr = explode('-',$adv_endtime);
				$tmp_count = count($arr)-1;
				if(strlen($adv_endtime) !=10 || $tmp_count !=2 || ((int)$arr[0] < date('Y'))){
					$error = true;
					$sysmsg[] = __('time_format_error');
				}else{
					$adv_endtime = @mktime(0,0,0,(int)$arr[1],(int)$arr[2],(int)$arr[0]);
				}
			}else{
				$adv_endtime = 0;
			}
			if($adv_starttime && $adv_endtime && ($adv_starttime >$adv_endtime)){
				$error = true;
				$sysmsg[] = __('start_end_time_error');
			}
			$num = $db->result_first("select count(*) from {$tpf}advertisements where title='$adv_title'");
			if($num){
				$error = true;
				$sysmsg[] = __('adv_title_exists');
			}
			if(!$error){
				$ins = array(
				'title' => $adv_title,
				'adv_type' => $adv_type,
				'adv_position' => $adv_position,
				'params' => $params,
				'code' => $code,
				'starttime' => $adv_starttime,
				'endtime' => $adv_endtime,
				);
				$db->query("insert into {$tpf}advertisements set ".$db->sql_array($ins).";");
				ads_cache();
				$sysmsg[] = __('add_adv_success');
				redirect(urr(ADMINCP,"item=advertisement&menu=extend"),$sysmsg);
			}else{
				redirect('back',$sysmsg,5000);
			}
		}else{
			$adv_scope = 'all';
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'modify_adv':

		$advid = (int)gpc('advid','GP',0);
		$adv_position = gpc('adv_position','GP','');
		$adv_type = gpc('adv_type','GP','');

		if($task =='modify_adv'){
			form_auth(gpc('formhash','P',''),formhash());

			$adv_title = trim(gpc('adv_title','P',''));
			$adv_starttime = trim(gpc('adv_starttime','P',''));
			$adv_endtime = trim(gpc('adv_endtime','P',''));
			$adv_scope = gpc('adv_scope','P',array());
			$params = array();
			$code = '';

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			$tmp = '';
			for($i=0;$i<count($adv_scope);$i++){
				$tmp .= $adv_scope[$i].',';
			}
			$params['adv_scope'] = substr($tmp,-1)==',' ? substr($tmp,0,-1) : $tmp;
			switch($adv_type){
				case 'adv_code':
					$code = trim(gpc('adv_html_code','P',''));
					if(strpos($code,"\\\'")!==false){
						$error = true;
						$sysmsg[] = "广告代码含有非法字符 <b class=txtred>\'</b> ，请返回修改";
					}
					break;
				case 'adv_text':
					$params['adv_txt_title'] = trim(gpc('adv_txt_title','P',''));
					$params['adv_txt_url'] = trim(gpc('adv_txt_url','P',''));
					$params['adv_txt_size'] = trim(gpc('adv_txt_size','P',''));
					$params['adv_txt_color'] = trim(gpc('adv_txt_color','P',''));

					if(!$params['adv_txt_title'] || !$params['adv_txt_url']){
						$error = true;
						$sysmsg[] = __('adv_txt_error');
					}
					break;
				case 'adv_flash':
					$params['adv_flash_src'] = trim(gpc('adv_flash_src','P',''));
					$params['adv_flash_width'] = trim(gpc('adv_flash_width','P',''));
					$params['adv_flash_height'] = trim(gpc('adv_flash_height','P',''));
					if(!$params['adv_flash_src']){
						$error = true;
						$sysmsg[] = __('adv_flash_src_error');
					}
					if(!is_numeric($params['adv_flash_width']) || !is_numeric($params['adv_flash_height'])){
						$error = true;
						$sysmsg[] = __('adv_flash_number_error');
					}
					break;
				default:
					$params['adv_img_src'] = trim(gpc('adv_img_src','P',''));
					$params['adv_img_url'] = trim(gpc('adv_img_url','P',''));
					$params['adv_img_width'] = trim(gpc('adv_img_width','P',''));
					$params['adv_img_height'] = trim(gpc('adv_img_height','P',''));
					$params['adv_img_alt'] = trim(gpc('adv_img_alt','P',''));
					if(!$params['adv_img_src']){
						$error = true;
						$sysmsg[] = __('adv_img_src_error');
					}
					if(!$params['adv_img_url']){
						$error = true;
						$sysmsg[] = __('adv_img_url_error');
					}
			}
			$params = $params ? serialize($params) : '';

			if(checklength($adv_title,2,300)){
				$error = true;
				$sysmsg[] = __('adv_title_error');
			}
			if($adv_starttime){
				$arr = explode('-',$adv_starttime);
				$tmp_count = count($arr)-1;
				if(strlen($adv_starttime) !=10 || $tmp_count !=2 || ((int)$arr[0] < date('Y'))){
					$error = true;
					$sysmsg[] = __('time_format_error');
				}else{
					$adv_starttime = @mktime(0,0,0,(int)$arr[1],(int)$arr[2],(int)$arr[0]);
				}
			}else{
				$adv_starttime = 0;
			}
			if($adv_endtime){
				$arr = explode('-',$adv_endtime);
				$tmp_count = count($arr)-1;
				if(strlen($adv_endtime) !=10 || $tmp_count !=2 || ((int)$arr[0] < date('Y'))){
					$error = true;
					$sysmsg[] = __('time_format_error');
				}else{
					$adv_endtime = @mktime(0,0,0,(int)$arr[1],(int)$arr[2],(int)$arr[0]);
				}
			}else{
				$adv_endtime = 0;
			}
			if($adv_starttime && $adv_endtime && ($adv_starttime >$adv_endtime)){
				$error = true;
				$sysmsg[] = __('start_end_time_error');
			}
			$num = $db->result_first("select count(*) from {$tpf}advertisements where title='$adv_title' and advid<>'$advid'");
			if($num){
				$error = true;
				$sysmsg[] = __('adv_title_exists');
			}

			if(!$error){
				$ins = array(
				'title' => $adv_title,
				'adv_type' => $adv_type,
				'adv_position' => $adv_position,
				'params' => $params,
				'code' => $code,
				'starttime' => $adv_starttime,
				'endtime' => $adv_endtime,
				);
				$db->query_unbuffered("update {$tpf}advertisements set ".$db->sql_array($ins)." where advid='$advid'");
				ads_cache();
				$sysmsg[] = __('modify_adv_success');
				redirect(urr(ADMINCP,"item=advertisement&menu=extend"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$rs = $db->fetch_one_array("select * from {$tpf}advertisements where advid='$advid'");
			if($rs){
				$adv_title = $rs['title'];
				$adv_type = $rs['adv_type'];
				$adv_position = $rs['adv_position'];
				$adv_starttime = $rs['starttime'] ? date("Y-m-d",$rs['starttime']) : '';
				$adv_endtime = $rs['endtime'] ? date("Y-m-d",$rs['endtime']) : '';
				$param = unserialize($rs['params']);
				$code = $rs['code'];
				$adv_scope = $param['adv_scope'] ? $param['adv_scope'] : 'all';

				switch($adv_type){
					case 'adv_text':
						$adv_txt_title = $param['adv_txt_title'];
						$adv_txt_url = $param['adv_txt_url'];
						$adv_txt_size = $param['adv_txt_size'];
						break;
					case 'adv_code':
						$adv_html_code = $code;
						break;
					case 'adv_flash':
						$adv_flash_src = $param['adv_flash_src'];
						$adv_flash_width = $param['adv_flash_width'];
						$adv_flash_height = $param['adv_flash_heigth'];
						break;
					default:
						$adv_img_src = $param['adv_img_src'];
						$adv_img_url = $param['adv_img_url'];
						$adv_img_width = $param['adv_img_width'];
						$adv_img_height = $param['adv_img_height'];
						$adv_img_alt = $param['adv_img_alt'];
				}
			}
			unset($rs);

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'delete_adv':
		if($settings['online_demo']){
			$error = true;
			$sysmsg[] = __('online_demo_deny');
		}
		if(!$error){
			$advid = (int)gpc('advid','G',0);
			$db->query_unbuffered("delete from {$tpf}advertisements where advid='$advid' limit 1");
			ads_cache();
			redirect(urr(ADMINCP,"item=advertisement&menu=extend"),'',0);
		}else{
			redirect('back',$sysmsg);
		}
		break;

	default:

		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$show_order = gpc('show_order','P',array());
			$advids = gpc('advids','P',array());
			$adv_titles = gpc('adv_titles','P',array());
			$is_hidden = gpc('is_hidden','P',array());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				for($i =0;$i<count($advids);$i++){
					if($adv_titles[$i]){
						$ins = array(
						'show_order' => (int)$show_order[$i],
						'title' => $db->escape(trim($adv_titles[$i])),
						);
						$db->query_unbuffered("update {$tpf}advertisements set ".$db->sql_array($ins)." where advid='".(int)$advids[$i]."'");
					}
				}
				$db->query_unbuffered("update {$tpf}advertisements set is_hidden=0");
				foreach($is_hidden as $k => $v){
					$db->query_unbuffered("update {$tpf}advertisements set is_hidden=1 where advid='".(int)$k."' limit 1");
				}
				$sysmsg[] = __('adv_update_success');
				ads_cache();
				redirect(urr(ADMINCP,"item=advertisement&menu=extend"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$q = $db->query("select * from {$tpf}advertisements order by show_order asc,advid asc");
			$advs = array();
			while($rs = $db->fetch_array($q)){
				if($rs['endtime'] && $rs['endtime'] <$timestamp){
					$rs['status'] = '<span class="txtred">'.__('is_over').'</span>';
				}else{
					$rs['status'] = '';
				}

				$rs['adv_starttime'] = $rs['starttime'] ? date("Y-m-d",$rs['starttime']) : '-';
				$rs['adv_endtime'] = $rs['endtime'] ? date("Y-m-d",$rs['endtime']) : '-';
				$rs['a_modify_adv'] = urr(ADMINCP,"item=advertisement&menu=extend&action=modify_adv&advid={$rs['advid']}");
				$rs['a_delete_adv'] = urr(ADMINCP,"item=advertisement&menu=extend&action=delete_adv&advid={$rs['advid']}");
				$advs[] = $rs;
			}
			$db->free($q);
			unset($rs);
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}
?>
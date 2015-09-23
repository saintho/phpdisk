<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: link.inc.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}

switch($action){
	case 'index':

		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$show_order = gpc('show_order','P',array());
			$linkids = gpc('linkids','P',array());
			$link_titles = gpc('link_titles','P',array());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				for($i =0;$i<count($linkids);$i++){
					$title = trim(replace_js($link_titles[$i]));
					if($title){
						$db->query_unbuffered("update {$tpf}links set show_order='".(int)$show_order[$i]."',title='$title' where linkid='".(int)$linkids[$i]."'");
					}
				}
				redirect(urr(ADMINCP,"item=$item&action=index"),'',0);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$q = $db->query("select * from {$tpf}links order by show_order asc,linkid asc");
			$links = array();
			while($rs = $db->fetch_array($q)){
				$rs['logo'] = $rs['logo'] ? '<img src="'.$rs['logo'].'" width="88" height="31" border="0"/>' : "--";
				$rs['status_text'] = $rs['is_hidden'] ? '<span class="txtblue">'.__('display').'</span>' : __('hidden');
				$rs['a_modify_link'] = urr(ADMINCP,"item=$item&menu=extend&action=modify_link&linkid={$rs['linkid']}");
				$rs['a_change_status'] = urr(ADMINCP,"item=$item&menu=extend&action=change_status&linkid={$rs['linkid']}");
				$rs['a_delete_link'] = urr(ADMINCP,"item=$item&menu=extend&action=delete_link&linkid={$rs['linkid']}");
				$links[] = $rs;
			}
			$db->free($q);
			unset($rs);
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'add_link':

		if($task =='add_link'){
			form_auth(gpc('formhash','P',''),formhash());

			$link_title = trim(gpc('link_title','P',''));
			$link_url = trim(gpc('link_url','P',''));
			$link_logo = trim(gpc('link_logo','P',''));

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(checklength($link_title,2,100)){
				$error = true;
				$sysmsg[] = __('link_title_error');
			}
			if(checklength($link_url,5,100)){
				$error = true;
				$sysmsg[] = __('link_url_error');
			}
			if(substr($link_url,0,7) != 'http://' && substr($link_url,0,8) != 'https://'){
				$error = true;
				$sysmsg[] = __('link_url_prefix');
			}

			if(!$error){
				$ins = array(
				'title' => replace_js($link_title),
				'url' => replace_js($link_url),
				'logo' => replace_js($link_logo),
				);
				$db->query("insert into {$tpf}links set ".$db->sql_array($ins).";");
				redirect(urr(ADMINCP,"item=$item&menu=extend&action=index"),'',0);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$link_url = 'http://';
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'modify_link':
		$linkid = (int)gpc('linkid','GP',0);

		if($task =='modify_link'){
			form_auth(gpc('formhash','P',''),formhash());

			$link_title = trim(gpc('link_title','P',''));
			$link_url = trim(gpc('link_url','P',''));
			$link_logo = trim(gpc('link_logo','P',''));

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(checklength($link_title,2,100)){
				$error = true;
				$sysmsg[] = __('link_title_error');
			}
			if(checklength($link_url,5,100)){
				$error = true;
				$sysmsg[] = __('link_url_error');
			}
			if(substr($link_url,0,7) != 'http://' && substr($link_url,0,8) != 'https://'){
				$error = true;
				$sysmsg[] = __('link_url_prefix');
			}

			if(!$error){
				$ins = array(
				'title' => replace_js($link_title),
				'url' => replace_js($link_url),
				'logo' => replace_js($link_logo),
				);
				$db->query_unbuffered("update {$tpf}links set ".$db->sql_array($ins)." where linkid='$linkid' limit 1;");
				redirect(urr(ADMINCP,"item=$item&menu=extend&action=index"),'',0);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$rs = $db->fetch_one_array("select * from {$tpf}links where linkid='$linkid'");
			if($rs){
				$link_title = $rs['title'];
				$link_url = $rs['url'];
				$link_logo = $rs['logo'];
			}
			unset($rs);
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'delete_link':
		if($settings['online_demo']){
			$error = true;
			$sysmsg[] = __('online_demo_deny');
		}
		if(!$error){
			$linkid = (int)gpc('linkid','G',0);
			$db->query_unbuffered("delete from {$tpf}links where linkid='$linkid' limit 1");
			redirect(urr(ADMINCP,"item=$item&menu=extend&action=index"),'',0);
		}else{
			redirect('back',$sysmsg);
		}
		break;

	case 'change_status':
		if($settings['online_demo']){
			$error = true;
			$sysmsg[] = __('online_demo_deny');
		}
		if(!$error){
			$linkid = (int)gpc('linkid','G',0);
			$rs = $db->fetch_one_array("select is_hidden from {$tpf}links where linkid='$linkid'");
			$status = $rs['is_hidden'] ? 0 : 1;
			unset($rs);
			$db->query_unbuffered("update {$tpf}links set is_hidden='$status' where linkid='$linkid'");
			redirect(urr(ADMINCP,"item=$item&menu=extend&action=index"),'',0);
		}else{
			redirect('back',$sysmsg);
		}
		break;

	default:
		redirect(urr(ADMINCP,"item=$item&menu=extend&action=index"),'',0);
}
?>
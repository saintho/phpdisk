<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: navigation.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,30,$pd_uid);
switch($action){
	case 'index':

		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$show_order = gpc('show_order','P',array());
			$navids = gpc('navids','P',array());
			$nav_texts = gpc('nav_texts','P',array());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				for($i =0;$i<count($navids);$i++){
					$text = $db->escape(trim(replace_js($nav_texts[$i])));
					if($text){
						$db->query_unbuffered("update {$tpf}navigations set show_order='".(int)$show_order[$i]."',text='$text' where navid='".(int)$navids[$i]."'");
					}
				}
				redirect(urr(ADMINCP,"item=$item&menu=extend&action=index"),'',0);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$q = $db->query("select * from {$tpf}navigations order by show_order asc,navid asc");
			$navigations = array();
			while($rs = $db->fetch_array($q)){
				$rs['a_modify_nav'] = urr(ADMINCP,"item=$item&menu=extend&action=modify_nav&navid={$rs['navid']}");
				$rs['a_delete_nav'] = urr(ADMINCP,"item=$item&menu=extend&action=delete_nav&navid={$rs['navid']}");
				$navigations[] = $rs;
			}
			$db->free($q);
			unset($rs);
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'add_nav':

		if($task =='add_nav'){
			form_auth(gpc('formhash','P',''),formhash());

			$nav_text = trim(gpc('nav_text','P',''));
			$nav_title = trim(gpc('nav_title','P',''));
			$nav_href = trim(gpc('nav_href','P',''));
			$nav_target = trim(gpc('nav_target','P',''));
			$nav_position = trim(gpc('nav_position','P',''));

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(checklength($nav_text,2,250)){
				$error = true;
				$sysmsg[] = __('nav_text_error');
			}
			if($nav_title && checklength($nav_title,2,50)){
				$error = true;
				$sysmsg[] = __('nav_title_error');
			}
			if(checklength($nav_href,5,80)){
				$error = true;
				$sysmsg[] = __('nav_href_error');
			}

			if(!$error){
				$ins = array(
				'text' => replace_js($nav_text),
				'title' => replace_js($nav_title),
				'href' => replace_js($nav_href),
				'target' => $nav_target,
				'position' => $nav_position,
				);
				$db->query("insert into {$tpf}navigations set ".$db->sql_array($ins).";");
				redirect(urr(ADMINCP,"item=$item&menu=extend&action=index"),'',0);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$nav_position = 'top';
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'modify_nav':
		$navid = (int)gpc('navid','GP',0);

		if($task =='modify_nav'){
			form_auth(gpc('formhash','P',''),formhash());

			$nav_text = trim(gpc('nav_text','P',''));
			$nav_title = trim(gpc('nav_title','P',''));
			$nav_href = trim(gpc('nav_href','P',''));
			$nav_target = trim(gpc('nav_target','P',''));
			$nav_position = trim(gpc('nav_position','P',''));

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(checklength($nav_text,2,250)){
				$error = true;
				$sysmsg[] = __('nav_text_error');
			}
			if($nav_title && checklength($nav_title,2,50)){
				$error = true;
				$sysmsg[] = __('nav_title_error');
			}
			if(checklength($nav_href,5,80)){
				$error = true;
				$sysmsg[] = __('nav_href_error');
			}

			if(!$error){
				$ins = array(
				'text' => replace_js($nav_text),
				'title' => replace_js($nav_title),
				'href' => replace_js($nav_href),
				'target' => $nav_target,
				'position' => $nav_position,
				);
				$db->query_unbuffered("update {$tpf}navigations set ".$db->sql_array($ins)." where navid='$navid' limit 1;");
				redirect(urr(ADMINCP,"item=$item&menu=extend&action=index"),'',0);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$rs = $db->fetch_one_array("select * from {$tpf}navigations where navid='$navid'");
			if($rs){
				$nav_text = $rs['text'];
				$nav_title = $rs['title'];
				$nav_href = $rs['href'];
				$nav_target = $rs['target'];
				$nav_position = $rs['position'];
			}
			unset($rs);
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'delete_nav':
		if($settings['online_demo']){
			$error = true;
			$sysmsg[] = __('online_demo_deny');
		}
		if(!$error){
			$navid = (int)gpc('navid','G',0);
			$db->query_unbuffered("delete from {$tpf}navigations where navid='$navid' limit 1");
			redirect(urr(ADMINCP,"item=$item&menu=extend&action=index"),'',0);
		}else{
			redirect('back',$sysmsg);
		}
		break;

	default:
		redirect(urr(ADMINCP,"item=$item&menu=extend&action=index"),'',0);
}
?>
<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: comment.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,33,$pd_uid);
switch($action){

	default:

		if($task !='update_setting'){
			$cmt_ids = gpc('cmt_ids','P',array(''));
			$ids_arr = get_ids_arr($cmt_ids,__('please_select_cmts'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$cmt_str = $ids_arr[1];
			}
		}

		if($task =='update_setting'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'open_comment' => 0,
			'check_comment' => 0,
			);
			$settings = gpc('setting','P',$setting);

			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('comment_update_success');
				redirect(urr(ADMINCP,"item=$item&menu=extend"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}

		}elseif($task =='is_checked'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}comments set is_checked=1 where cmt_id in ($cmt_str)");
				$sysmsg[] = __('cmt_checked_success');
				redirect(urr(ADMINCP,"item=$item&menu=extend"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='is_unchecked'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}comments set is_checked=0 where cmt_id in ($cmt_str)");
				$sysmsg[] = __('cmt_unchecked_success');
				redirect(urr(ADMINCP,"item=$item&menu=extend"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='del_cmts'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("delete from {$tpf}comments where cmt_id in ($cmt_str)");
				$sysmsg[] = __('del_cmt_success');
				redirect(urr(ADMINCP,"item=$item"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$rs = $db->fetch_one_array("select count(*) as total_num from {$tpf}comments");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select c.*,fl.file_name,fl.file_extension from {$tpf}comments c,{$tpf}files fl where c.file_id=fl.file_id order by cmt_id desc limit $start_num,$perpage");
			$cmts = array();
			while($rs = $db->fetch_array($q)){
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				$rs['file_name'] = $rs['file_name'].$tmp_ext;
				$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
				$rs['a_space'] = urr("space","username=".rawurlencode($rs['username']));
				$rs['username'] = $db->result_first("select username from {$tpf}users where userid='{$rs['userid']}' limit 1");
				$rs['content'] = preg_replace("/<.+?>/i","",str_replace('<br>',LF,$rs['content']));
				$rs['status'] = $rs['is_checked'] ? "<span class='txtblue'>".__('checked_txt')."<span>" :"<span class='txtred'>".__('unchecked_txt')."</span>";
				$rs['in_time'] = date("Y-m-d H:i:s",$rs['in_time']);
				$cmts[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=extend"));
			$setting = $settings;
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}
?>
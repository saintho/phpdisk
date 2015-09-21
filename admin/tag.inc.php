<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: tag.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,41,$pd_uid);
switch($action){

	default:

		if($task){
			$tagids = gpc('tagids','P',array(''));

			$ids_arr = get_ids_arr($tagids,__('please_select_tags'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$tag_str = $ids_arr[1];
			}
		}

		if($task =='chg_show'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}tags set is_hidden=0 where tag_id in ($tag_str)");

				$sysmsg[] = __('chg_status_success');
				redirect(urr(ADMINCP,"item=$item&menu=file"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}elseif($task =='chg_hidden'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}tags set is_hidden=1 where tag_id in ($tag_str)");

				$sysmsg[] = __('chg_status_success');
				redirect(urr(ADMINCP,"item=$item&menu=file"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}elseif($task =='del_tag'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("delete from {$tpf}file2tag where tag_name in (select tag_name from {$tpf}tags where tag_id in ($tag_str))");
				$db->query_unbuffered("delete from {$tpf}tags where tag_id in ($tag_str)");

				$sysmsg[] = __('del_tag_success');
				redirect(urr(ADMINCP,"item=$item&menu=file"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$rs = $db->fetch_one_array("select count(*) as total_num from {$tpf}tags");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select * from {$tpf}tags order by tag_id asc limit $start_num,$perpage");
			$tags = array();
			while($rs = $db->fetch_array($q)){
				$rs['a_tag'] = urr("tag","tag=".rawurlencode($rs['tag_name']));
				$rs['status'] = $rs['is_hidden'] ? "<span class='txtred'>".__('is_hidden')."<span>" :"<span class='txtblue'>".__('is_show')."</span>";
				$tags[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=file"));
			$setting = $settings;
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}
?>
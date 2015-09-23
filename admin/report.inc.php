<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: report.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}

switch($action){
	case 'user':
		admin_no_power($task,21,$pd_uid);
		$title = __('report_user_title');
		$tips = __('report_user_tips');
		$op_action = __('locked');

		if($task){
			$file_ids = gpc('file_ids','P',array());

			$ids_arr = get_ids_arr($file_ids,__('please_select_operation_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}
		}

		if($task =='change_status'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set report_status=0,is_locked=1 where file_id in ($file_str)");
				$sysmsg[] = __('locked_file_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task=='checked_done'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("delete from {$tpf}reports where file_id in ($file_str) ");
				$db->query_unbuffered("update {$tpf}files set report_status=0 where file_id in ($file_str)");
				$sysmsg[] = __('file_checked_done_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='delete'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set is_del=1 where file_id in ($file_str)");
				//syn_folder_size();
				$sysmsg[] = __('delete_file_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$sql_ext = "{$tpf}files fl,{$tpf}users u where fl.userid=u.userid and report_status=1 and fl.is_del=0";
			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_ext}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select fl.*,u.username from {$sql_ext} order by file_id desc limit $start_num,$perpage");
			$files_array = array();
			while($rs = $db->fetch_array($q)){
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				$rs['file_thumb'] = get_file_thumb($rs);
				$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
				$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,35);
				$rs['file_size'] = get_size($rs['file_size']);
				$rs['file_time'] = date("Y-m-d",$rs['file_time']);
				$rs['a_downfile'] = urr("downfile","file_id={$rs['file_id']}&file_key={$rs['file_key']}");
				$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
				$rs['status_txt'] = '<span class="txtblue">'.__('common_status').'</span>';
				$rs['owner'] = '<a href="'.urr("space","username=".rawurlencode($rs['username'])).'" target="_blank">'.$rs['username'].'</a>';
				$rs2 = $db->fetch_one_array("select u.userid,username,r.content from {$tpf}reports r, {$tpf}users u where r.userid=u.userid and r.file_id='{$rs['file_id']}'");
				$rs['reporter'] = $rs2['username'] ? '<a href="'.urr("space","username=".rawurlencode($rs2['username'])).'" target="_blank">'.$rs2['username'].'</a>' : '--';
				$rs['reason'] = str_replace("\r\n",' ',preg_replace("/<.+?>/i","",$rs2['content']));
				$files_array[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=user&action=$action"));
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}

		break;

	case 'system':
		admin_no_power($task,22,$pd_uid);
		$title = __('report_system_title');
		$tips = __('report_system_tips');
		$op_action = __('locked');

		if($task){
			$file_ids = gpc('file_ids','P',array());

			$ids_arr = get_ids_arr($file_ids,__('please_select_operation_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}
		}

		if($task =='change_status'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set report_status=0,is_locked=1 where file_id in ($file_str)");
				$sysmsg[] = __('locked_file_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task=='checked_done'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set report_status=0 where file_id in ($file_str)");
				$sysmsg[] = __('file_checked_done_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='delete'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set is_del=1 where file_id in ($file_str)");
				//syn_folder_size();
				$sysmsg[] = __('delete_file_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$sql_ext = "{$tpf}files fl,{$tpf}users u where fl.userid=u.userid and report_status=2 and fl.is_del=0";
			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_ext}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select * from {$sql_ext} order by file_id desc limit $start_num,$perpage");
			$files_array = array();
			while($rs = $db->fetch_array($q)){
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				$rs['file_thumb'] = get_file_thumb($rs);
				$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
				$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,35);
				$rs['file_size'] = get_size($rs['file_size']);
				$rs['file_time'] = date("Y-m-d",$rs['file_time']);
				$rs['a_downfile'] = urr("downfile","file_id={$rs['file_id']}&file_key={$rs['file_key']}");
				$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
				$rs['status_txt'] = '<span class="txtblue">'.__('common_status').'</span>';
				$rs['owner'] = '<a href="'.urr("space","username=".rawurlencode($rs['username'])).'" target="_blank">'.$rs['username'].'</a>';
				$rs2 = $db->fetch_one_array("select u.userid,username,r.id,r.content from {$tpf}reports r, {$tpf}users u where r.userid=u.userid and r.file_id='{$rs['file_id']}'");
				$rs['reporter'] = $rs2['username'] ? '<a href="'.urr("space","username=".rawurlencode($rs2['username'])).'" target="_blank">'.$rs2['username'].'</a>' : '--';
				$rs['reason'] = str_replace("\r\n",' ',preg_replace("/<.+?>/i","",$rs2['content']));
				$rs['id'] = $rs2['id'];
				unset($rs2);
				$files_array[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=user&action=$action"));
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}

		break;

	case 'file_unlocked':
		admin_no_power($task,23,$pd_uid);
		$title = __('report_unlocked_title');
		$tips = __('report_unlocked_tips');
		$op_action = __('unlocked');

		if($task){
			$file_ids = gpc('file_ids','P',array());

			$ids_arr = get_ids_arr($file_ids,__('please_select_operation_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}
		}

		if($task =='change_status'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set is_locked=0 where file_id in ($file_str)");
				$sysmsg[] = __('unlocked_file_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='delete'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set is_del=1 where file_id in ($file_str)");
				//syn_folder_size();
				$sysmsg[] = __('delete_file_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$sql_ext = "{$tpf}files fl,{$tpf}users u where u.userid=fl.userid and fl.is_locked=1 and fl.is_del=0";
			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_ext}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select * from {$sql_ext} order by file_id desc limit $start_num,$perpage");
			$files_array = array();
			while($rs = $db->fetch_array($q)){
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				$rs['file_thumb'] = get_file_thumb($rs);
				$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
				$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,35);
				$rs['file_size'] = get_size($rs['file_size']);
				$rs['file_time'] = date("Y-m-d",$rs['file_time']);
				$rs['a_downfile'] = urr("downfile","file_id={$rs['file_id']}&file_key={$rs['file_key']}");
				$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
				$rs['status_txt'] = '<span class="txtred">'.__('locked_status').'</span>';
				$rs['owner'] = '<a href="'.urr("space","username=".rawurlencode($rs['username'])).'" target="_blank">'.$rs['username'].'</a>';
				$rs2 = $db->fetch_one_array("select username from {$tpf}reports r, {$tpf}users u where r.userid=u.userid and r.id='{$rs['id']}'");
				$rs['reporter'] = $rs2['username'] ? '<a href="'.urr("space","username=".rawurlencode($rs['username'])).'" target="_blank">'.$rs2['username'].'</a>' : '--';
				$files_array[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=user&action=$action"));
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	default:
		admin_no_power($task,20,$pd_uid);
		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'open_report' => 0,
			'report_word' => '',
			);
			$settings = gpc('setting','P',$setting);

			if($settings['report_word']){
				$report_word = str_replace('，',',',$settings['report_word']);
				$arr = explode(',',$report_word);
				$str = '';
				for($i=0;$i<count($arr);$i++){
					if(trim($arr[$i])){
						$str .= trim($arr[$i]).',';
					}
				}
				$settings['report_word'] = substr($str,0,-1);
			}

			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('report_success');
				redirect(urr(ADMINCP,"item=$item&menu=user&action=$action"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$setting = $settings;
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}
?>
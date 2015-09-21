<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: public.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,0,$pd_uid);
switch($action){
	case 'add_cate':

		if($task =='add_cate'){
			form_auth(gpc('formhash','P',''),formhash());

			$cate_name = trim(gpc('cate_name','P',''));
			$pid = (int)gpc('pid','P',0);
			$nav_show = (int)gpc('nav_show','P',0);
			$cate_list = (int)gpc('cate_list','P',0);
			$share_index = (int)gpc('share_index','P',0);

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(checklength($cate_name,1,60)){
				$error = true;
				$sysmsg[] = __('cate_name_error');
			}
			$rs = $db->fetch_one_array("select count(*) as total from {$tpf}categories where cate_name='$cate_name'");
			if($rs['total']){
				$error = true;
				$sysmsg[] = __('cate_name_exists');
			}
			if(!$error){
				$ins = array(
				'cate_name' => $cate_name,
				'pid' => $pid,
				'nav_show' => $nav_show,
				'cate_list' => $cate_list,
				'share_index' => $share_index,
				);
				$db->query("insert into {$tpf}categories set ".$db->sql_array($ins).";");
				$sysmsg[] = __('cate_add_success');
				redirect(urr(ADMINCP,"item=$item&menu=file&action=category"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$nav_show = 0;
			$cate_list = 0;
			$share_index = 0;
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'modify_cate':
		$cate_id = (int)gpc('cate_id','GP',0);

		if($task =='modify_cate'){
			form_auth(gpc('formhash','P',''),formhash());

			$cate_name = trim(gpc('cate_name','P',''));
			$pid = (int)gpc('pid','P',0);
			$nav_show = (int)gpc('nav_show','P',0);
			$cate_list = (int)gpc('cate_list','P',0);
			$share_index = (int)gpc('share_index','P',0);

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(checklength($cate_name,1,60)){
				$error = true;
				$sysmsg[] = __('cate_name_error');
			}
			$rs = $db->fetch_one_array("select count(*) as total from {$tpf}categories where cate_name='$cate_name' and pid='$pid' and cate_id<>'$cate_id'");
			if($rs['total']){
				$error = true;
				$sysmsg[] = __('cate_name_exists');
			}
			if($cate_id==$pid){
				$error = true;
				$sysmsg[] = __('cateid_pid_cannot_same');
			}
			if(!$error){
				$ins = array(
				'cate_name' => $cate_name,
				'pid' => $pid,
				'nav_show' => $nav_show,
				'cate_list' => $cate_list,
				'share_index' => $share_index,
				);
				$db->query_unbuffered("update {$tpf}categories set ".$db->sql_array($ins)." where cate_id='$cate_id';");
				$sysmsg[] = __('cate_modify_success');
				redirect(urr(ADMINCP,"item=$item&menu=file&action=category"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{

			$rs = $db->fetch_one_array("select * from {$tpf}categories where cate_id='$cate_id'");
			if($rs){
				$cate_name = $rs['cate_name'];
				$pid = $rs['pid'];
				$nav_show = $rs['nav_show'];
				$cate_list = $rs['cate_list'];
				$share_index = $rs['share_index'];
			}
			unset($rs);
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'category':

		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$show_order = gpc('show_order','P',array());
			$cate_ids = gpc('cate_ids','P',array());
			$cate_names = gpc('cate_names','P',array());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				for($i =0;$i<count($cate_ids);$i++){
					$title = trim(replace_js($cate_names[$i]));
					if($title){
						$db->query_unbuffered("update {$tpf}categories set show_order='".(int)$show_order[$i]."',cate_name='$title' where cate_id='".(int)$cate_ids[$i]."'");
					}
				}
				redirect(urr(ADMINCP,"item=$item&menu=file&action=category"),'',0);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$q = $db->query("select * from {$tpf}categories order by show_order asc, cate_id asc");
			$cates = array();
			while($rs = $db->fetch_array($q)){
				$cates[] = $rs;
			}
			$db->free($q);
			unset($rs);

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}

		break;

	case 'del_cate':
		if($settings['online_demo']){
			$error = true;
			$sysmsg[] = __('online_demo_deny');
		}
		if(!$error){
			$cate_id = (int)gpc('cate_id','G',0);
			if($cate_id){
				$db->query_unbuffered("update {$tpf}files set is_del=1 where cate_id='$cate_id'");
				$db->query_unbuffered("delete from {$tpf}categories where cate_id='$cate_id'");
			}
			$sysmsg[] = __('del_cate_success');
			redirect(urr(ADMINCP,"item=$item&menu=file&action=category"),$sysmsg);
		}else{
			redirect('back',$sysmsg);
		}
		break;

	case 'viewfile':
		$cate_id = trim(gpc('cate_id','GP',''));
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
		if($task == 'check_file'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set is_checked=1 where file_id in ($file_str)");
				$sysmsg[] = __('check_file_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task=='uncheck_file'){
			form_auth(gpc('formhash','P',''),formhash());
			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set cate_id=0,is_checked=1 where file_id in ($file_str)");
				$sysmsg[] = __('uncheck_file_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task=='move_to'){
			form_auth(gpc('formhash','P',''),formhash());
			$dest_sid = (int)gpc('dest_sid','GP',0);

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set cate_id='$dest_sid' where file_id in ($file_str)");
				$sysmsg[] = __('move_file_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task == 'delete'){
			
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}files set is_del=1 where file_id in ($file_str)");

				$sysmsg[] = __('delete_file_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task=='commend' || $task=='uncommend'){
			form_auth(gpc('formhash','P',''),formhash());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				$commend = $task=='commend' ? 1 : 0;
				$db->query_unbuffered("update {$tpf}files set commend='$commend' where file_id in ($file_str)");

				$sysmsg[] = $task=='commend' ? __('commend_file_success') :  __('uncommend_file_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			if($cate_id=='-1'){
				$sql_ext = " where f.is_checked=0";
			}elseif($cate_id=='-2'){
				$sql_ext = " where f.commend=1";
			}else{
				$cate_id = (int)$cate_id;
				$sql_ext = " where f.cate_id='$cate_id'";
			}

			$rs = $db->fetch_one_array("select count(*) as total_num from {$tpf}files f {$sql_ext}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select f.*,u.username from {$tpf}files f,{$tpf}users u {$sql_ext} and f.is_del=0 and f.userid=u.userid order by is_checked desc,file_id desc limit $start_num,$perpage");
			$files_array = array();
			while($rs = $db->fetch_array($q)){
				//$rs[cate_name] = @$db->result_first("select cate_name from {$tpf}categories where cate_id='{$rs[cate_id]}'");
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				$rs['file_thumb'] = get_file_thumb($rs);
				$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
				$rs['file_name'] = $rs['file_name'].$tmp_ext;
				//$rs['a_space'] = urr("space","username=".rawurlencode($rs['username']));
				$rs['a_user_view'] = urr(ADMINCP,"item=files&menu=file&action=index&view=user&uid=".$rs['userid']);
				$rs['file_size'] = get_size($rs['file_size']);
				$rs['file_time'] = date("Y-m-d H:i:s",$rs['file_time']);
				$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
				$rs[commend_txt] = $rs[commend] ? __('commending') : '';
				$rs[commend_class] = $rs[commend] ? 'class="txtblue"' : '';
				$rs['a_recycle_delete'] = urr(ADMINCP,"item=files&action=recycle_delete&file_id={$rs['file_id']}");
				$rs['status_txt'] = $rs['is_checked'] ? '<span class="txtblue">'.__('checked').'</span>' : '<span class="txtred">'.__('unchecked').'</span>';
				$rs['file_abs_path'] = $rs['file_store_path'].$rs['file_real_name'].get_real_ext($rs['file_extension']);
				$files_array[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=file&app=$app&action=$action&cate_id=$cate_id"));
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'chg_cate_status':
		$cate_id = (int)gpc('cate_id','G',0);
		$status = (int)gpc('status','G',0);

		$status = $status ? 0 : 1;
		if($cate_id){
			$db->query_unbuffered("update {$tpf}categories set {$task}='$status' where cate_id='$cate_id' limit 1");
		}

		$sysmsg[] = __('cate_position_upate_success');
		redirect('back',$sysmsg);
		break;

	default:

		if($task == 'update'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'check_public_file' => 0,
			);
			$settings = gpc('setting','P',$setting);

			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('public_update_success');
				redirect(urr(ADMINCP,"item=$item&menu=file"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$setting = $settings;

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}

function get_cate_tree($pid=0,$lv=0){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}categories order by show_order asc");
	while ($rs = $db->fetch_array($q)) {
		$data[] = $rs;
	}
	$db->free($q);
	unset($rs);
	if(count($data)){
		$html = '<tr>'.LF;
		foreach($data as $v){
			if($v['pid'] == $pid){
				$total = (int)@$db->result_first("select count(*) from {$tpf}files where cate_id='{$v[cate_id]}' and is_del=0");
				$a_modify = urr(ADMINCP,"item=public&menu=file&action=modify_cate&cate_id={$v['cate_id']}");
				$a_cate_href = urr("public","cate_id={$v['cate_id']}");
				$a_del_cate = urr(ADMINCP,"item=public&menu=file&action=del_cate&cate_id={$v['cate_id']}");
				$nav_show = $v['nav_show'] ? '<span class="txtblue" title="'.__('nav_show').'">'.__('nav_show_min').'</span>' : '<span class="txtgray" title="'.__('nav_show').'">'.__('nav_show_min').'</span>';
				$cate_list = $v['cate_list'] ? '<span class="txtblue" title="'.__('cate_list').'">'.__('cate_list_min').'</span>' : '<span class="txtgray" title="'.__('cate_list').'">'.__('cate_list_min').'</span>';
				$share_index = $v['share_index'] ? '<span class="txtblue" title="'.__('share_index').'">'.__('share_index_min').'</span>' : '<span class="txtgray" title="'.__('share_index').'">'.__('share_index_min').'</span>';

				$html .= "<td>".LF;
				$html .= '<input type="text" name="show_order[]" value="'.$v['show_order'].'" style="width:20px; text-align:center" maxlength="2" />'.LF;
				$html .= '<input type="hidden" name="cate_ids[]" value="'.$v['cate_id'].'" />'.LF;
				$html .= str_repeat('&nbsp;',$lv*2).'<input type="text" name="cate_names[]" size="30" value="'.$v['cate_name'].'" /></td>'.LF;
				$html .= '<td><a href="'.urr(ADMINCP,"item=public&menu=file&action=chg_cate_status&task=nav_show&cate_id={$v['cate_id']}&status={$v['nav_show']}").'">'.$nav_show.'</a>-<a href="'.urr(ADMINCP,"item=public&menu=file&action=chg_cate_status&task=cate_list&cate_id={$v['cate_id']}&status={$v['cate_list']}").'">'.$cate_list.'</a>-<a href="'.urr(ADMINCP,"item=public&menu=file&action=chg_cate_status&task=share_index&cate_id={$v['cate_id']}&status={$v['share_index']}").'">'.$share_index.'</a></td>'.LF;
				$html .= '	<td align="center">';
				$html .= '	<a href="'.$a_cate_href.'" target="_blank">'.$total.'</a>';
				$html .= '	</td>'.LF;
				$html .= '	<td align="right">';
				$html .= '	<a href="'.$a_modify.'">'.__('modify').'</a>&nbsp;';
				$html .= '	<a href="'.$a_del_cate.'" onclick="return confirm(\''.__('del_category_confirm').'\');">'.__('delete').'</a></td>'.LF;
				$lv++;
				$html .= get_cate_tree($v['cate_id'],$lv);
				$lv--;
			}
		}
		$html .= '</tr>'.LF;
		return $html;
	}else{
		return '';
	}
}


?>
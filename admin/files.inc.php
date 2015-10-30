<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: files.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,14,$pd_uid);
function get_servers(){
	global $db,$tpf;
	$q = $db->query("select server_name,server_oid from {$tpf}servers where server_oid>1 order by server_id asc");
	while ($rs = $db->fetch_array($q)) {
		$arr[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $arr;
}
switch($action){
	case 'filterword':
		if($task=='update'){
			form_auth(gpc('formhash','P',''),formhash());
			$setting = array(
			'filter_word'=>'',
			);

			$settings = gpc('setting','P',$setting);
			if($online_demo){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}

			if(!$error){
				settings_cache($settings);
				$sysmsg[] = __('filterword_update_success');
				redirect(urr(ADMINCP,"item=$item&menu=file&action=$action"),$sysmsg);
			}else{
				redirect('back',$system);
			}
		}else{
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'total_del':
		$file_id = (int)gpc('file_id','G',0);
		$safe = $task=='safe' ? 1 : 0;

		if($file_id){
			$num = @$db->result_first("select count(*) from {$tpf}files where file_id='$file_id'");
			if($num){
				$msg = '';
				$rs = $db->fetch_one_array("select * from {$tpf}files where file_id='$file_id'");
				if($rs){
					$tmp_ext = $rs[file_extension] ? '.'.$rs[file_extension] : '';
					$file_real_name = $rs[file_real_name];//convert_str('utf-8','gbk',$rs[file_real_name]);
					$pp = $settings[file_path].'/'.$rs[file_store_path].'/'.$file_real_name.$tmp_ext;
					$file_name = $rs[file_name].$tmp_ext;
					if($rs[server_oid]>1){
						$rs2 = $db->fetch_one_array("select * from {$tpf}servers where server_oid='{$rs[server_oid]}' limit 1");
						if($rs2){
							$msg = '';
							if($rs2[server_dl_host]){
								$arr = explode(LF,$rs2[server_dl_host]);
								for($i=0;$i<count($arr);$i++){
									//$str .= '<option value='.rawurlencode($arr[$i]).'>'.$arr[$i].'</option>'.LF;
									$msg .= '<script type="text/javascript" src="'.$arr[$i].'/phpdisk_del_process.php?'.pd_encode("pp=$pp&file_id={$rs[file_id]}&file_name={$file_name}&safe=$safe&server=down").'"></script>'.LF;
								}
							}
							$up_del_url = $rs2[server_host].'phpdisk_del_process.php?'.pd_encode("pp=$pp&file_id={$rs[file_id]}&file_name={$file_name}&safe=$safe&server=up");
							//$down_del_url = $rs2[server_host].'phpdisk_del_process.php?'.pd_encode("pp=$pp&file_id={$rs[file_id]}&file_name={$file_name}&safe=$safe&server=down");
							$msg .= '<script type="text/javascript" src="'.$up_del_url.'"></script>'.LF;
							//$msg .= '<script type="text/javascript" src="'.$down_del_url.'"></script>'.LF;
						}else{
							exit('Error param!');
						}
					}else{
						exit('Remote server error');
					}
				}
				unset($rs);
			}
		}else{
			$num = @$db->result_first("select count(*) from {$tpf}files where is_del=1");
			if($num){
				$msg = '';
				$q = $db->query("select * from {$tpf}files where is_del=1 limit 2");
				while ($rs = $db->fetch_array($q)) {
					$tmp_ext = $rs[file_extension] ? '.'.$rs[file_extension] : '';
					$file_real_name = $rs[file_real_name];//convert_str('utf-8','gbk',$rs[file_real_name]);
					$pp = $settings[file_path].'/'.$rs[file_store_path].'/'.$file_real_name.$tmp_ext;
					$file_name = $rs[file_name].$tmp_ext;
					if($rs[server_oid]>1){
						$rs2 = $db->fetch_one_array("select * from {$tpf}servers where server_oid='{$rs[server_oid]}' limit 1");
						if($rs2){
							$msg = '';
							if($rs2[server_dl_host]){
								$arr = explode(LF,$rs2[server_dl_host]);
								for($i=0;$i<count($arr);$i++){
									//$str .= '<option value='.rawurlencode($arr[$i]).'>'.$arr[$i].'</option>'.LF;
									$msg .= '<script type="text/javascript" src="'.$arr[$i].'/phpdisk_del_process.php?'.pd_encode("pp=$pp&file_id={$rs[file_id]}&file_name={$file_name}&safe=$safe&server=down").'"></script>'.LF;
								}
							}
							$up_del_url = $rs2[server_host].'phpdisk_del_process.php?'.pd_encode("pp=$pp&file_id={$rs[file_id]}&file_name={$file_name}&safe=$safe&server=up");
							//$down_del_url = $rs2[server_host].'phpdisk_del_process.php?'.pd_encode("pp=$pp&file_id={$rs[file_id]}&file_name={$file_name}&safe=$safe&server=down");
							$msg .= '<script type="text/javascript" src="'.$up_del_url.'"></script>'.LF;
							//$msg .= '<script type="text/javascript" src="'.$down_del_url.'"></script>'.LF;
						}else{
							exit('Error param!');
						}
					}else{
						exit('Remote server error');
					}
				}
				$db->free($q);
				unset($rs);

				echo '<script type="text/javascript">'.LF;
				echo 'setTimeout(function(){'.LF;
				echo 'document.location.reload();'.LF;
				echo '},1500);'.LF;
				echo '</script>'.LF;
			}else{
				$msg = __('safe_del_file_success');
			}
		}
		require_once template_echo($item,$admin_tpl_dir,'',1);
		break;
	case 'index':

		$view = trim(gpc('view','GP',''));
		$uid = (int)gpc('uid','GP',0);

		if(in_array($task,array('check_public','file_to_locked','file_to_unlocked','delete_file_complete','restore_del_file','move_to','move_oid'))){
			form_auth(gpc('formhash','P',''),formhash());

			$file_ids = gpc('file_ids','P',array(''));

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			$ids_arr = get_ids_arr($file_ids,__('please_select_check_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}
			if(!$error){
				switch($task){
					case 'check_public':
						$db->query_unbuffered("update {$tpf}files set is_checked=1 where file_id in ($file_str)");
						$sysmsg[] = __('check_public_success');
						break;
					case 'file_to_locked':
						$db->query_unbuffered("update {$tpf}files set is_locked=1 where file_id in ($file_str)");
						$sysmsg[] = __('file_to_locked_success');
						break;
					case 'file_to_unlocked':
						$db->query_unbuffered("update {$tpf}files set is_locked=0 where file_id in ($file_str)");
						$sysmsg[] = __('file_to_unlocked_success');
						break;
					case 'delete_file_complete':
						$db->query_unbuffered("update {$tpf}files set is_del=1 where file_id in ($file_str)");
						$sysmsg[] = __('file_delete_to_recycle_success');
						break;
					case 'restore_del_file':
						$db->query_unbuffered("update {$tpf}files set is_del=0,folder_id=0 where file_id in ($file_str)");
						$sysmsg[] = __('restore_del_file_success');
						break;
					case 'move_to':
						$dest_sid = (int)gpc('dest_sid','GP',0);
						$db->query_unbuffered("update {$tpf}files set cate_id='$dest_sid' where file_id in ($file_str)");
						$sysmsg[] = __('move_file_success');
						break;
					case 'move_oid':
						$server_oid = (int)gpc('server_oid','P',0);
						$db->query_unbuffered("update {$tpf}files set server_oid='$server_oid' where file_id in ($file_str)");
						$sysmsg[] = '服务器标识ID设置成功';
						break;
				}
				redirect(urr(ADMINCP,"item=files&action=index&view=checked_file"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$perpage = 100;
			$sql_ext = '';
			switch($view){
				case 'user':
					$sql_ext = " where f.is_del=0 and f.userid='$uid'";
					break;
				case 'user_del':
					$sql_ext = " where f.is_del=1";
					break;
				case 'checked_file':
					$sql_ext = " where f.is_checked=1 and f.is_del=0";
					break;
				case 'unchecked_file':
					$sql_ext = " where f.is_checked=0 and f.is_del=0";
					break;
				default:
					$sql_ext = " where f.is_del=0";
			}
			$rs = $db->fetch_one_array("select count(*) as total_num from {$tpf}files f {$sql_ext}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select f.*,u.username from {$tpf}files f,{$tpf}users u {$sql_ext} and f.userid=u.userid order by file_id desc limit $start_num,$perpage");
			$files_array = array();
			while($rs = $db->fetch_array($q)){
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				//$rs['file_thumb'] = get_file_thumb($rs);
				$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
				$rs['file_name'] = $rs['file_name'].$tmp_ext;
				$rs[file_description] = str_replace("\r\n",' ',cutstr(preg_replace("/<.+?>/i","",$rs['file_description']),80));
				$rs['a_user_view'] = urr(ADMINCP,"item=files&menu=file&action=$action&view=user&uid=".$rs['userid']);
				//$rs['a_user_view'] = urr("space","username=".rawurlencode($rs['username']));
				$rs['file_size'] = get_size($rs['file_size']);
				$rs['file_time'] = date("Y-m-d H:i:s",$rs['file_time']);
				$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
				$rs['a_recycle_delete'] = urr(ADMINCP,"item=files&menu=file&action=recycle_delete&file_id={$rs['file_id']}");
				$rs[a_edit] = urr(ADMINCP,"item=files&menu=file&action=edit&file_id={$rs['file_id']}");
				$rs['status_txt'] = $rs['is_locked'] ? "<span class=\"txtred\">".__('locked_status')."</span>" : "<span class=\"txtblue\">".__('common_status')."</span>";
				$rs[checked_txt] = $check_arr_txt[$rs[is_checked]] ? $check_arr_txt[$rs[is_checked]] : '';
				$rs['file_abs_path'] = $rs[yun_fid] ? '网盘云存储' : $rs['file_store_path'].$rs['file_real_name'].get_real_ext($rs['file_extension']);
				$files_array[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=file&action=$action&view=$view&uid=$uid"));
			$dd = date('Y-m-d');
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'search':
		$view = trim(gpc('view','GP',''));
		if(in_array($task,array('check_public','file_to_locked','file_to_unlocked','delete_file_complete','restore_del_file','move_to','move_oid'))){
			form_auth(gpc('formhash','P',''),formhash());

			$file_ids = gpc('file_ids','P',array(''));

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			$ids_arr = get_ids_arr($file_ids,__('please_select_check_files'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$file_str = $ids_arr[1];
			}
			if(!$error){
				switch($task){
					case 'check_public':
						$db->query_unbuffered("update {$tpf}files set is_checked=1 where file_id in ($file_str)");
						$sysmsg[] = __('check_public_success');
						redirect(urr(ADMINCP,"item=files&action=index&view=checked_file"),$sysmsg);
						break;
					case 'file_to_locked':
						$db->query_unbuffered("update {$tpf}files set is_locked=1 where file_id in ($file_str)");
						$sysmsg[] = __('file_to_locked_success');
						redirect($_SERVER['HTTP_REFERER'],$sysmsg);
						break;
					case 'file_to_unlocked':
						$db->query_unbuffered("update {$tpf}files set is_locked=0 where file_id in ($file_str)");
						$sysmsg[] = __('file_to_unlocked_success');
						redirect($_SERVER['HTTP_REFERER'],$sysmsg);
						break;
					case 'delete_file_complete':
						$db->query_unbuffered("update {$tpf}files set is_del=1 where file_id in ($file_str)");
						$sysmsg[] = __('file_delete_success');
						redirect($_SERVER['HTTP_REFERER'],$sysmsg);
						break;
					case 'restore_del_file':
						$db->query_unbuffered("update {$tpf}files set is_del=0,folder_id=0 where file_id in ($file_str)");
						$sysmsg[] = __('restore_del_file_success');
						redirect($_SERVER['HTTP_REFERER'],$sysmsg);
						break;
					case 'move_to':
						$dest_sid = (int)gpc('dest_sid','GP',0);
						$db->query_unbuffered("update {$tpf}files set cate_id='$dest_sid' where file_id in ($file_str)");
						$sysmsg[] = __('move_file_success');
						break;
					case 'move_oid':
						$server_oid = (int)gpc('server_oid','P',0);
						$db->query_unbuffered("update {$tpf}files set server_oid='$server_oid' where file_id in ($file_str)");
						$sysmsg[] = '服务器标识ID设置成功';
						break;
				}

			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$dd = gpc('dd','G','');
			$user = gpc('user','G','');
			$sel_type = (int)gpc('sel_type','G',0);
			$word = trim(gpc('word','G',''));
			$word_str = str_replace('　',' ',replace_inject_str($word));
			$dd_sql = $dd ? " and (file_time between ".strtotime($dd)." and ".strtotime($dd.' 23:59:59').")" : '';
			$u_sql = '';
			if($user){
				$uid = @$db->result_first("select userid from {$tpf}users where username='$user'");
				if(!$uid){
					echo '<script>alert("用户名不存在");window.history.back();</script>';
					exit;
				}else{
					$u_sql = $uid ? " and u.userid='$uid'" : '';
				}
			}
			if($sel_type){
				if(!is_numeric($word_str)){
					echo '<script>alert("文件ID只能为整数");window.history.back();</script>';
					exit;
				}else{
					$word_str = (int)$word_str;
					$sql_keyword = " and file_id='$word_str'";
				}
			}else{
				$arr = explode(' ',$word_str);
				if(count($arr)>1){
					for($i=0;$i<count($arr);$i++){
						if(trim($arr[$i]) <> ''){
							$str .= " (file_name like '%{$arr[$i]}%' or file_extension like '%{$arr[$i]}%') and";
						}
					}
					$str = substr($str,0,-3);
					$sql_keyword = " and (".$str.")";

				}else{
					$sql_keyword = " and (file_name like '%{$word_str}%' or file_extension like '%{$word_str}%')";
				}
			}
			$is_del = $view=='user_del' ? 1 : 0;
			$sql_do = " {$tpf}files fl,{$tpf}users u where fl.userid=u.userid and is_del=$is_del $sql_keyword $dd_sql $u_sql";

			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select fl.*,u.username from {$sql_do} order by file_id desc limit $start_num,$perpage");
			$files_array = array();
			while($rs = $db->fetch_array($q)){
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
				$rs['file_name'] = str_replace($word,'<span class="txtred">'.$word.'</span>',$rs['file_name'].$tmp_ext);
				$rs['a_user_view'] = urr(ADMINCP,"item=files&menu=file&action=index&view=user&uid=".$rs['userid']);
				$rs['file_size'] = get_size($rs['file_size']);
				$rs['file_time'] = custom_time("Y-m-d",$rs['file_time']);
				$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
				$rs['a_recycle_delete'] = urr(ADMINCP,"item=files&menu=file&action=recycle_delete&file_id={$rs['file_id']}");
				$rs[a_edit] = urr(ADMINCP,"item=files&menu=file&action=edit&file_id={$rs['file_id']}");
				$rs['status_txt'] = $rs['is_locked'] ? "<span class=\"txtred\">".__('locked_status')."</span>" : "<span class=\"txtblue\">".__('common_status')."</span>";
				$rs[checked_txt] = $check_arr_txt[$rs[is_checked]] ? $check_arr_txt[$rs[is_checked]] : '';
				$rs['file_abs_path'] = $rs[yun_fid] ? '网盘云存储' : $rs['file_store_path'].$rs['file_real_name'].get_real_ext($rs['file_extension']);
				$files_array[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=file&action=search&view=$view&dd=$dd&user=".rawurlencode($user)."&word=".rawurlencode($word)."&sel_type=$sel_type"));

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'recycle_delete':
		if($settings['online_demo']){
			$error = true;
			$sysmsg[] = __('online_demo_deny');
		}
		if(!$error){
			$file_id = (int)gpc('file_id','G',0);
			$db->query_unbuffered("update {$tpf}files set is_del=1 where file_id='$file_id'");
			//syn_folder_size();

			$sysmsg[] = __('file_delete_success');
			redirect('back',$sysmsg);
		}else{
			redirect('back',$sysmsg);
		}
		break;
	case 'edit':
		$file_id = (int)gpc('file_id','GP',0);
		if(!$file_id){
			header('Location:'.urr(ADMINCP,"item=files&menu=file&action=index"));
			exit;
		}
		if($task=='edit'){
			form_auth(gpc('formhash','P',''),formhash());
			$meta_title = trim(gpc('meta_title','P',''));
			$meta_keywords = trim(gpc('meta_keywords','P',''));
			$meta_description = trim(gpc('meta_description','P',''));
			$meta_title2 = trim(gpc('meta_title2','P',''));
			$meta_keywords2 = trim(gpc('meta_keywords2','P',''));
			$meta_description2 = trim(gpc('meta_description2','P',''));
			$file_description = gpc('file_description','P','');
			$ref = trim(gpc('ref','P',''));

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if($file_description && checklength($file_description,1,6000)){
				$error = true;
				$sysmsg[] = __('file_description_error');
			}else{
				$file_description = preg_replace("/<(\/?i?frame.*?)>/si","",$file_description);
				$file_description = preg_replace("/<(\/?script.*?)>/si","",$file_description);
			}
			if(!$error){
				if($auth[pd_a]){
					update_seo('viewfile',$file_id,$meta_title,$meta_keywords,$meta_description);
					update_seo('download',$file_id,$meta_title2,$meta_keywords2,$meta_description2);
				}
				$db->query_unbuffered("update {$tpf}files set file_description='$file_description' where file_id='$file_id'");
				$sysmsg[] = __('file_edit_success');
				redirect($ref,$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$rs = $db->fetch_one_array("select file_description,file_name,file_extension from {$tpf}files where file_id='$file_id'");
			if($rs){
				$file_description = str_replace('<br>',LF,$rs[file_description]);
				$tmp_ext = $rs[file_extension] ? '.'.$rs[file_extension] : '';
				$file_name = file_icon($rs['file_extension']).$rs[file_name].$tmp_ext;
			}
			unset($rs);
			$ref = $_SERVER['HTTP_REFERER'];
			if($auth[pd_a]){
				$s = get_seo('viewfile',$file_id);
				$s2 = get_seo('download',$file_id);
			}
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

}

?>
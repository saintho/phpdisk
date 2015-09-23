<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: plugins.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,0,$pd_uid);
$all_plugins_count = get_all_plugins_count('all');
$actived_plugins_count = get_all_plugins_count('actived');
$inactived_plugins_count = get_all_plugins_count('inactived');
$tmp = @$db->result_first("select count(*) from {$tpf}plugins where actived=1 and action_time>0");
$last_plugins_count = $tmp>10 ? 10 : $tmp;

switch($action){
	case 'active':
		$plugin_name = trim(gpc('plugin_name','G',''));
		if($plugin_name){
			$ins = array(
			'plugin_name' => $plugin_name,
			'active' => 1,
			);
			$sqls = "('{$ins[plugin_name]}','{$ins[active]}')";
			$db->query("replace into {$tpf}plugins(plugin_name,actived) values $sqls ;");
		}
		$sysmsg[] = __('plugins_actived_success');
		redirect($_SERVER['HTTP_REFERER'],$sysmsg);
		break;

	case 'inactive':
		$plugin_name = trim(gpc('plugin_name','G',''));
		if($plugin_name){
			$ins = array(
			'plugin_name' => $plugin_name,
			'active' => 0,
			);
			$sqls = "('{$ins[plugin_name]}','{$ins[active]}')";
			$db->query("replace into {$tpf}plugins(plugin_name,actived) values $sqls ;");
		}
		$sysmsg[] = __('plugins_inactived_success');
		redirect($_SERVER['HTTP_REFERER'],$sysmsg);
		break;

	case 'install':
		$plugin_name = trim(gpc('plugin_name','G',''));
		if($plugin_name){
			include_once PD_PLUGINS_DIR."$plugin_name/install.inc.php";
			install_plugin();
			write_file(PD_PLUGINS_DIR."$plugin_name/install.lock","PHPDISK $plugin_name plugin installed!");
		}
		$sysmsg[] = __('plugin_install_success');
		redirect($_SERVER['HTTP_REFERER'],$sysmsg);
		break;

	case 'uninstall':
		$plugin_name = trim(gpc('plugin_name','G',''));
		if($plugin_name){
			include_once PD_PLUGINS_DIR."$plugin_name/install.inc.php";
			uninstall_plugin();
			@unlink(PD_PLUGINS_DIR."$plugin_name/install.lock");
			$ins = array(
			'plugin_name' => $plugin_name,
			'active' => 0,
			);
			$sqls = "('{$ins[plugin_name]}','{$ins[active]}')";
			$db->query("replace into {$tpf}plugins(plugin_name,actived) values $sqls ;");
		}
		$sysmsg[] = __('plugin_uninstall_success');
		redirect($_SERVER['HTTP_REFERER'],$sysmsg);
		break;

	case 'actived_plugins':
		$sql_do = " where actived=1";
		$perpage = 10;
		$rs = $db->fetch_one_array("select count(*) as total_num from {$tpf}plugins $sql_do");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;

		$q = $db->query("select * from {$tpf}plugins $sql_do order by plugin_name asc limit $start_num,$perpage");
		while($rs = $db->fetch_array($q)){
			if(check_plugin($rs['plugin_name'])){
				$plugins_arr[] = get_plugin_info($rs['plugin_name']);
			}
		}
		$db->free($q);
		unset($rs);
		$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=plugin&action=$action"));

		require_once template_echo($item,$admin_tpl_dir,'',1);
		break;

	case 'inactived_plugins':
		$sql_do = " where actived=0";
		$perpage = 10;
		$rs = $db->fetch_one_array("select count(*) as total_num from {$tpf}plugins $sql_do");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;

		$q = $db->query("select * from {$tpf}plugins $sql_do order by plugin_name asc limit $start_num,$perpage");
		while($rs = $db->fetch_array($q)){
			if(check_plugin($rs['plugin_name'])){
				$plugins_arr[] = get_plugin_info($rs['plugin_name']);
			}
		}
		$db->free($q);
		unset($rs);
		$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=plugin&action=$action"));

		require_once template_echo($item,$admin_tpl_dir,'',1);
		break;

	case 'last_plugins':
		$q = $db->query("select * from {$tpf}plugins where actived=1 and action_time>0 order by action_time desc, plugin_name asc limit 10");
		while($rs = $db->fetch_array($q)){
			if(check_plugin($rs['plugin_name'])){
				$plugins_arr[] = get_plugin_info($rs['plugin_name']);
			}
		}
		$db->free($q);
		unset($rs);

		require_once template_echo($item,$admin_tpl_dir,'',1);
		break;

	case 'shortcut':
		if($task =='shortcut'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'open_plugins_cp' => 0,
			'open_plugins_last' => 0,
			);
			$plugin_ids = gpc('plugin_ids','P',array());
			$settings = gpc('setting','P',$setting);

			if(!$error){
				if(count($plugin_ids)){
					foreach($plugin_ids as $k => $v){
						$plugin_name = $db->escape(trim($k));
						$db->query_unbuffered("update {$tpf}plugins set in_shortcut=1 where plugin_name='$plugin_name'");
					}
				}
				settings_cache($settings);

				$sysmsg[] = __('shortcut_settings_update_success');
				redirect(urr(ADMINCP,"item=$item&menu=plugin&action=$action"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$setting = $settings;
			$shortcut_status = '';
			$q = $db->query("select plugin_name,in_shortcut from {$tpf}plugins order by actived desc, plugin_name asc");
			while($rs = $db->fetch_array($q)){
				$shortcut_status .= $rs['in_shortcut'] ? 'g("cp_'.$rs['plugin_name'].'").checked=true;'.LF : '';
				$plugins_list[] = get_plugin_info($rs['plugin_name']);
			}
			$db->free($q);
			unset($rs);

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	default:
		if($task =='active'){
			form_auth(gpc('formhash','P',''),formhash());

			$plugin_ids = gpc('plugin_ids','P',array());

			$ids_arr = get_ids_arr($plugin_ids,__('please_select_plugins'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$plugin_ids = $ids_arr[1];
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}plugins set actived=1 where plugin_name in($plugin_ids)");
				$sysmsg[] = __('plugins_actived_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}elseif($task =='inactive'){
			form_auth(gpc('formhash','P',''),formhash());

			$plugin_ids = gpc('plugin_ids','P',array());

			$ids_arr = get_ids_arr($plugin_ids,__('please_select_plugins'));
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$plugin_ids = $ids_arr[1];
			}
			if(!$error){
				$db->query_unbuffered("update {$tpf}plugins set actived=0 where plugin_name in($plugin_ids)");
				$sysmsg[] = __('plugins_inactived_success');
				redirect($_SERVER['HTTP_REFERER'],$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			syn_plugins();

			$sql_do = "";
			$perpage = 10;
			$rs = $db->fetch_one_array("select count(*) as total_num from {$tpf}plugins $sql_do");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select * from {$tpf}plugins $sql_do order by actived desc, plugin_name asc limit $start_num,$perpage");
			while($rs = $db->fetch_array($q)){
				if(check_plugin($rs['plugin_name'])){
					$plugins_arr[] = get_plugin_info($rs['plugin_name']);
				}
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=plugin&action=$action"));

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}

}
?>
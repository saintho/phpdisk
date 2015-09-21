<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: admin.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
phpdisk_core::admin_login();
$remote_server_url = remote_server_url();
switch($action){
	case 'add_server':

		if($task =='add_server'){
			form_auth(gpc('formhash','P',''),formhash());

			$server_name = trim(gpc('server_name','P',''));
			$server_oid = (int)gpc('server_oid','P',0);
			$server_host = trim(gpc('server_host','P',''));
			$server_dl_host = trim(gpc('server_dl_host','P',''));
			$server_closed = (int)gpc('server_closed','P',0);
			$server_key = trim(gpc('server_key','P',''));
			$server_store_path = trim(gpc('server_store_path','P',''));

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(checklength($server_name,2,100)){
				$error = true;
				$sysmsg[] = __('server_name_error');
			}
			if(!is_numeric($server_oid)){
				$error = true;
				$sysmsg[] = __('server_oid_error');
			}elseif((int)$server_oid==1){
				$error = true;
				$sysmsg[] = __('server_oid_key_error');
			}
			$num = $db->result_first("select count(*) from {$tpf}servers where server_oid='$server_oid'");
			if($num){
				$error = true;
				$sysmsg[] = __('server_oid_error');
			}
			if(substr($server_host,0,7) !='http://' && substr($server_host,0,8) !='https://'){
				$error = true;
				$sysmsg[] = __('server_host_error');
			}else{
				$server_host = substr($server_host,-1) =='/' ? $server_host : $server_host.'/';
			}
			if(!$server_key){
				$error = true;
				$sysmsg[] = __('server_key_error');
			}else{
				$num = @$db->result_first("select count(*) from {$tpf}servers where server_key='$server_key'");
				if($num){
					$error = true;
					$sysmsg[] = __('server_key_exists');
				}
			}
			if(!$server_store_path){
				$error = true;
				$sysmsg[] = __('server_store_path_error');
			}

			$rs = $db->fetch_one_array("select count(*) as total from {$tpf}servers where server_host='$server_host'");
			if($rs['total']){
				$error = true;
				$sysmsg[] = __('server_host_exists');
			}
			unset($rs);
			if($server_dl_host && strpos($server_dl_host,'http')===false){
				$error = true;
				$sysmsg[] = __('server_dl_host_format_error');
			}
			if(!$error){
				$ins = array(
				'server_name' => $server_name,
				'server_oid' => $server_oid,
				'server_host' => $server_host,
				'server_dl_host' => $server_dl_host,
				'server_closed' => $server_closed,
				'server_key' => $server_key,
				'server_store_path' => $server_store_path,
				);
				$db->query_unbuffered("insert into {$tpf}servers set ".$db->sql_array($ins).";");


				$sysmsg[] = __('server_add_success');

				redirect(urr(ADMINCP,"item=plugins&menu=plugin&app=$app"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$server_oid = (int)$db->result_first("select server_id from {$tpf}servers order by server_id desc limit 1");
			$server_oid = $server_oid ? ($server_oid+1) : 1;
			$server_key = random(12);
			$server_store_path = $settings['file_path'];
			require_once template_echo('admin','',$app);
		}
		break;

	case 'edit_server':
		$server_id = (int)gpc('server_id','GP',0);

		if($task =='edit_server'){
			form_auth(gpc('formhash','P',''),formhash());

			$server_name = trim(gpc('server_name','P',''));
			$server_oid = (int)gpc('server_oid','P',0);
			$server_host = trim(gpc('server_host','P',''));
			$server_dl_host = trim(gpc('server_dl_host','P',''));
			$server_closed = (int)gpc('server_closed','P',0);
			$server_key = trim(gpc('server_key','P',''));
			$server_store_path = trim(gpc('server_store_path','P',''));

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!is_numeric($server_oid)){
				$error = true;
				$sysmsg[] = __('server_oid_error');
			}elseif((int)$server_oid==1){
				$error = true;
				$sysmsg[] = __('server_oid_key_error');
			}
			$num = $db->result_first("select count(*) from {$tpf}servers where server_oid='$server_oid' and server_id<>'$server_id'");
			if($num){
				$error = true;
				$sysmsg[] = __('server_oid_error');
			}
			if(substr($server_host,0,7) !='http://' && substr($server_host,0,8) !='https://'){
				$error = true;
				$sysmsg[] = __('server_host_error');
			}else{
				$server_host = substr($server_host,-1) =='/' ? $server_host : $server_host.'/';
			}
			if(!$server_key){
				$error = true;
				$sysmsg[] = __('server_key_error');
			}else{
				$num = @$db->result_first("select count(*) from {$tpf}servers where server_key='$server_key' and server_id<>'$server_id'");
				if($num){
					$error = true;
					$sysmsg[] = __('server_key_exists');
				}
			}
			$rs = $db->fetch_one_array("select count(*) as total from {$tpf}servers where server_host='$server_host' and server_id<>'$server_id'");
			if($rs['total']){
				$error = true;
				$sysmsg[] = __('server_host_exists');
			}
			unset($rs);
			if($server_dl_host && strpos($server_dl_host,'http')===false){
				$error = true;
				$sysmsg[] = __('server_dl_host_format_error');
			}
			if(!$error){
				$ooid = $db->result_first("select server_oid from {$tpf}servers where server_id='$server_id'");
				$db->query_unbuffered("update {$tpf}files set server_oid='$server_oid' where server_oid='$ooid'");
				$ins = array(
				'server_name' => $server_name,
				'server_oid' => $server_oid,
				'server_host' => $server_host,
				'server_dl_host' => $server_dl_host,
				'server_closed' => $server_closed,
				'server_key' => $server_key,
				'server_store_path' => $server_store_path,
				);
				$db->query_unbuffered("update {$tpf}servers set ".$db->sql_array($ins)." where server_id='$server_id';");

				$sysmsg[] = __('server_edit_success');

				redirect(urr(ADMINCP,"item=plugins&menu=plugin&app=$app"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}else{

			$rs = $db->fetch_one_array("select * from {$tpf}servers where server_id='$server_id' limit 1");
			if($rs){
				$server_name = $rs['server_name'];
				$server_oid = $rs['server_oid'] ? (int)$rs['server_oid'] : $rs['server_id'];
				$server_host = $rs['server_host'];
				$server_dl_host = $rs['server_dl_host'];
				$server_closed = $rs['server_closed'];
				$server_store_path = $rs['server_store_path'];
				$server_key = $rs['server_key'];
				$ftp_closed = $rs['ftp_closed'];
			}
			unset($rs);
			require_once template_echo('admin','',$app);
		}
		break;

	case 'del_server':
		if($settings['online_demo']){
			$error = true;
			$sysmsg[] = __('online_demo_deny');
		}
		if(!$error){
			$server_oid = (int)gpc('server_oid','G',0);
			$num = @$db->result_first("select count(*) from {$tpf}files where server_oid='$server_oid'");
			if($num){
				$sysmsg[] = __('cannot_del_server');
				redirect('back',$sysmsg);
			}else{
				$db->query_unbuffered("delete from {$tpf}servers where server_oid='$server_oid'");
				$sysmsg[] = __('server_del_success');
				redirect(urr(ADMINCP,"item=plugins&menu=plugin&app=$app"),$sysmsg);
			}
		}else{
			redirect('back',$sysmsg);
		}
		break;
	case 'set_default':
		$server_id = trim(gpc('server_id','G',0));
		if($settings['online_demo']){
			$error = true;
			$sysmsg[] = __('online_demo_deny');
		}
		if(!$server_id){
			$error = true;
			$sysmsg[] = __('server_oid_set_error');
		}
		if(!$error){
			$db->query_unbuffered("update {$tpf}servers set is_default=0 where server_oid>1");
			$db->query_unbuffered("update {$tpf}servers set is_default=1 where server_id='$server_id'");
			$sysmsg[] = __('server_set_default_success');
			redirect(urr(ADMINCP,"item=plugins&menu=plugin&app=$app"),$sysmsg);
		}else{
			redirect('back',$sysmsg);
		}
		break;
	default:
		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'open_multi_server' => 0,
			);
			$settings = gpc('setting','P',$setting);

			if(!$error){
				settings_cache($settings);
				$sysmsg[] = __('multi_update_success');
				redirect(urr(ADMINCP,"item=plugins&menu=plugin&app=$app"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$upload_max = get_byte_value(ini_get('upload_max_filesize'));
			$post_max = get_byte_value(ini_get('post_max_size'));
			$max_php_file_size = min($upload_max, $post_max);
			$q = $db->query("select * from {$tpf}servers order by is_default desc,server_id asc");
			$server_arr = array();
			while($rs = $db->fetch_array($q)){
				$total_size = $db->result_first("select sum(file_size) from {$tpf}files where server_oid='{$rs['server_oid']}'");
				$rs['server_size'] = get_size($total_size);
				$rs['is_default'] = $rs['is_default'] ==1 ? '<span class="txtblue">'.__('default_server').'</span>' : '';
				$rs['server_status'] = $rs['server_closed'] ? '<span class="txtred">'.__('closed').'</span>' : '<span class="txtblue">'.__('using').'</span>';
				$rs['a_default_server'] = urr(ADMINCP,"item=plugins&menu=plugin&app=$app&action=set_default&server_id={$rs['server_id']}");
				$rs['a_edit_server'] = urr(ADMINCP,"item=plugins&menu=plugin&app=$app&action=edit_server&server_id={$rs['server_id']}");
				$rs['a_del_server'] = urr(ADMINCP,"item=plugins&menu=plugin&app=$app&action=del_server&server_oid={$rs['server_oid']}");
				$rs['client_status'] = !$rs['server_closed'] ? '<span class="txtblue">'.__('success').'</span>' : '<span class="txtred">'.__('fail').'</span>';

				$rs['a_test_server'] = $rs['server_host'].'phpdisk_multi_client.php?code='.$rs['server_key'];
				$rs['a_update_env'] = $rs['server_host'].'update_configs.php?code='.$rs[server_key].'&up_size='.$max_php_file_size;
				$server_arr[] = $rs;
			}
			$db->free($q);
			unset($rs,$rs2);
			$settings['upload_server_type'] = $settings['upload_server_type'] ? trim($settings['upload_server_type']) : 'ftp_server';
			require_once template_echo('admin','',$app);
		}
}
update_action_time($app);

?>
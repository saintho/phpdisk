<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: templates.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,27,$pd_uid);
switch($action){

	case 'active':
		$tpl_id = trim(gpc('tpl_id','G',''));

		$tpl_type = $db->result_first("select tpl_type from {$tpf}templates where tpl_name='$tpl_id'");
		$db->query_unbuffered("update {$tpf}templates set actived=0 where tpl_type='$tpl_type'");
		$db->query_unbuffered("update {$tpf}templates set actived=1 where tpl_name='$tpl_id'");
		tpl_cache();
		$sysmsg[] = __('tpl_active_success');
		redirect(urr(ADMINCP,"item=templates&menu=lang_tpl"),$sysmsg);

		break;
	case 'scan_tpl':
		syn_templates();
		$sysmsg[] = '模板检测入库成功';
		redirect(urr(ADMINCP,"item=templates&menu=lang_tpl"),$sysmsg);
		break;
	default:
		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'open_switch_tpls' => 0,
			);
			$settings = gpc('setting','P',$setting);
			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('tpl_update_success');
				redirect(urr(ADMINCP,"item=templates&menu=lang_tpl"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{			

			$templates_arr = get_tpl_list();
			
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}

}
function get_tpl_list(){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}templates order by tpl_type desc,actived desc,tpl_name asc");
	while($rs = $db->fetch_array($q)){
		if(check_template($rs['tpl_name'])){
			$templates_arr[] = get_template_info($rs['tpl_name']);
		}
	}
	$db->free($q);
	unset($rs);
	return $templates_arr;
}
function syn_templates(){
	global $db,$tpf;
	$dirs = scandir(PHPDISK_ROOT.'templates');
	sort($dirs);

	for($i=0;$i<count($dirs);$i++){
		if(check_template($dirs[$i])){
			$arr[] = $dirs[$i];
		}
	}

	$q = $db->query("select * from {$tpf}templates where actived=1");
	while($rs = $db->fetch_array($q)){
		if(check_template($rs['tpl_name'])){
			$active_templates .= $rs['tpl_name'].',';
		}
	}
	$db->free($q);
	unset($rs);

	if(trim(substr($active_templates,0,-1))){
		$active_arr = explode(',',$active_templates);
	}
	for($i=0;$i<count($arr);$i++){
		$tmp = get_template_info($arr[$i]);
		if(@in_array($arr[$i],$active_arr)){
			$sql_do .= "('".$db->escape($arr[$i])."','1','".$db->escape(trim($tmp['tpl_type']))."'),";
		}else{
			$sql_do .= "('".$db->escape($arr[$i])."','0','".$db->escape(trim($tmp['tpl_type']))."'),";
		}
	}
	$sql_do = substr($sql_do,0,-1);
	$db->query_unbuffered("truncate table {$tpf}templates;");
	$db->query_unbuffered("replace into {$tpf}templates(tpl_name,actived,tpl_type) values $sql_do ;");

	$num = @$db->result_first("select count(*) from {$tpf}templates where tpl_type='admin' and actived=1");
	if(!$num){
		$db->query_unbuffered("update {$tpf}templates set actived=1 where tpl_name='admin'");
	}
	$num = @$db->result_first("select count(*) from {$tpf}templates where tpl_type='user' and actived=1");
	if(!$num){
		$db->query_unbuffered("update {$tpf}templates set actived=1 where tpl_name='default'");
	}
	return true;
}


?>
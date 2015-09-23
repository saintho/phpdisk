<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: lang.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,26,$pd_uid);
switch($action){

	case 'active':
		$lang_name = trim(gpc('lang_name','G',''));

		$lang_package = PHPDISK_ROOT.'languages/'.$lang_name.'/LC_MESSAGES/phpdisk.mo';
		
		if(!file_exists($lang_package)){
			$sysmsg[] = __('lang_not_exists');

		}else{
			$db->query_unbuffered("update {$tpf}langs set actived=0;");
			$db->query_unbuffered("update {$tpf}langs set actived=1 where lang_name='$lang_name'");

			$sysmsg[] = __('lang_active_success');
		}
		redirect(urr(ADMINCP,"item=lang&menu=lang_tpl"),$sysmsg);

		break;

	default:
		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'open_switch_langs' => 0,
			);
			$settings = gpc('setting','P',$setting);
			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('lang_update_success');
				redirect(urr(ADMINCP,"item=lang&menu=lang_tpl"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			syn_languages();

			$q = $db->query("select * from {$tpf}langs order by actived desc,lang_name asc");
			while($rs = $db->fetch_array($q)){
				if(check_lang($rs['lang_name'])){
					$languages_arr[] = get_lang_info($rs['lang_name']);
				}
			}
			$db->free($q);
			unset($rs);
			require_once template_echo('lang',$admin_tpl_dir,'',1);
		}
}
function syn_languages(){
	global $db,$tpf;
	$dirs = scandir(PHPDISK_ROOT.'./languages');
	sort($dirs);
	for($i=0;$i<count($dirs);$i++){
		if(check_lang($dirs[$i])){
			$arr[] = $dirs[$i];
		}
	}
	$q = $db->query("select * from {$tpf}langs where actived=1");
	while($rs = $db->fetch_array($q)){
		if(check_lang($rs['lang_name'])){
			$active_languages .= $rs['lang_name'].',';
		}
	}
	$db->free($q);
	unset($rs);

	if(trim(substr($active_languages,0,-1))){
		$active_arr = explode(',',$active_languages);
	}
	for($i=0;$i<count($arr);$i++){
		if(@in_array($arr[$i],$active_arr)){
			$sql_do .= "('".$db->escape($arr[$i])."','1'),";
		}else{
			$sql_do .= "('".$db->escape($arr[$i])."','0'),";
		}
	}
	$sql_do = substr($sql_do,0,-1);
	$db->query_unbuffered("truncate table {$tpf}langs;");
	$db->query_unbuffered("replace into {$tpf}langs(lang_name,actived) values $sql_do ;");

	$num = @$db->result_first("select count(*) from {$tpf}langs where actived=1");
	if(!$num){
		$db->query_unbuffered("update {$tpf}langs set actived=1 where lang_name='zh_cn'");
	}
	return true;
}



?>
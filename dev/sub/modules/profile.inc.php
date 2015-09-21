<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: profile.inc.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

switch($action){
	default:
		if($task =='mod_pro'){
			form_auth(gpc('formhash','P',''),formhash());
			$space_name = trim(gpc('space_name','P',''));
			$income_account = trim(gpc('income_account','P',''));
			$income_name = trim(gpc('income_name','P',''));
			
			if(checklength($space_name,1,90)){
				$error = true;
				$sysmsg[] = '网盘标题不能为空';
			}
			if(!$error){
				$ins = array(
				'space_name' => $db->escape($space_name),
				'income_account' => $db->escape($income_account),
				'income_name' => $db->escape($income_name),
				);
				$db->query_unbuffered("update {$tpf}users set ".$db->sql_array($ins)." where userid='$pd_uid'");
				$sysmsg[] = '更新成功';
				tb_redirect(urr("space",""),$sysmsg);
			}else{
				tb_redirect('back',$sysmsg);
			}
			
		}elseif($task == 'password'){
			form_auth(gpc('formhash','P',''),formhash());

			$old_pwd = trim(gpc('old_pwd','P',''));
			$new_pwd = trim(gpc('new_pwd','P',''));
			$cfm_pwd = trim(gpc('cfm_pwd','P',''));

			$rs = $db->fetch_one_array("select userid from {$tpf}users where password='".md5($old_pwd)."' and userid='$pd_uid'");
			if(!$rs){
				$error = true;
				$sysmsg[] = $L['invalid_password'];
			}
			unset($rs);
			if(checklength($new_pwd,6,20)){
				$error = true;
				$sysmsg[] = $L['password_max_min'];
			}elseif($new_pwd != $cfm_pwd){
				$error = true;
				$sysmsg[] = $L['confirm_password_invalid'];
			}else{
				$md5_pwd = md5($new_pwd);
			}
			if(!$error){
				$sql = "update {$tpf}users set password='$md5_pwd' where userid='$pd_uid'";
				$db->query_unbuffered($sql);
				pd_setcookie('phpdisk_zcore_info','');
				$sysmsg[] = $L['password_modify_success'];
				tb_redirect(urr("account","action=login"),$sysmsg,2000,'top');
			}else{
				tb_redirect('back',$sysmsg);
			}

		}else{
			$rs = $db->fetch_one_array("select space_name,income_account,income_name from {$tpf}users where userid='$pd_uid'");
			if($rs){
				$space_name = $rs['space_name'];
				$income_account = $rs['income_account'];
				$income_name = $rs['income_name'];
			}
			unset($rs);
			require_once template_echo('profile',$user_tpl_dir);
		}

		break;

}

?>
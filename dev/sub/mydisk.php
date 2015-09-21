<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: mydisk.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

if($action =='guest'){
	$sess_id = trim(gpc('sess_id','G',''));
	$rs = $db->fetch_one_array("select userid,username,password,email,gid from {$tpf}users where reset_code='$sess_id' limit 1");
	if($rs){
		$userid = $rs['userid'];
		$gid = $rs['gid'];
		$username = $rs['username'];
		$password = $rs['password'];
		$email = $rs['email'];
		pd_setcookie('phpdisk_zcore_info',pd_encode("$userid\t$gid\t$username\t$password\t$email"),86400*7);
	}
	unset($rs);
	$username = $pd_username ? $pd_username : $username;
	$db->query_unbuffered("update {$tpf}users set reset_code='' where reset_code='$sess_id' limit 1");
	redirect($settings['phpdisk_url'].urr("space","username=".rawurlencode($username)),'',0);
	exit;
}

phpdisk_core::user_login();

define('IN_MYDISK' ,true);

if($item){
	if($item=='files' && $action=='modify_file'){
		$inner_box = true;
	}
	if($item=='upload'){
		$inner_box = true;
	}
	if($item =='profile'){
		$inner_box = true;
	}
	if($inner_box){
		require_once template_echo('my_header',$user_tpl_dir);
	}else{
		require_once template_echo('pd_header',$user_tpl_dir);
	}
	$items = array('upload','files','profile');
	if(in_array($item,$items)){
		require_once PHPDISK_ROOT."modules/".$item.".inc.php";
	}else{
		echo "Error operation, system halt!";
	}
	if($inner_box){
		require_once template_echo('my_footer',$user_tpl_dir);
	}else{
		require_once template_echo('pd_footer',$user_tpl_dir);
	}
}

include PHPDISK_ROOT."./includes/footer.inc.php";

?>



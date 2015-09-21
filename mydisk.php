<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: mydisk.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

phpdisk_core::user_login();

define('IN_MYDISK' ,true);

$item = $item ? $item : 'profile';

if($item=='files' && in_array($action,array('modify_file','post_report','post_comment'))){
	$inner_box = true;
}
if($item=='folders' && in_array($action,array('add_folder','modify_folder','folder_delete'))){
	$inner_box = true;
}
if($item=='profile' && in_array($action,array('conv_income','guest'))){
	$inner_box = true;
}
if($item=='upload'){
	$inner_box = true;
}
if($inner_box){
	if($item){
		require_once template_echo('my_header',$user_tpl_dir);
		require_once PHPDISK_ROOT.'modules/'.$item.'.inc.php';
		require_once template_echo('my_footer',$user_tpl_dir);
	}else{
		echo "Error operation, system halt,inner_box!";
	}
}else{
	$in_front = true;
	$num = @$db->result_first("select count(*) from {$tpf}users where userid='$pd_uid' and is_locked=1 limit 1");
	if($num){
		include PHPDISK_ROOT."./includes/header.inc.php";
		require_once template_echo("pd_mydisk_locked",$user_tpl_dir);
	}else{
		if($item){

			include PHPDISK_ROOT."./includes/header.inc.php";
			$items = array('files','profile');
			if(in_array($item,$items)){
				$action_module = PHPDISK_ROOT.'modules/'.$item.'.inc.php';
			}else{
				echo "Error operation, system halt!";
			}
			require_once template_echo("mydisk",$user_tpl_dir);
		}else{
			echo "Error operation, system halt!";
		}
	}
}

include PHPDISK_ROOT."./includes/footer.inc.php";

?>



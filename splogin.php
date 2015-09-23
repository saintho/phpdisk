<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: splogin.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

if($pd_gid==1){
	$username = trim(gpc('username','G',''));
	if(!empty($username)){
		$rs = $db->fetch_one_array("select * from {$tpf}users where username='$username' limit 1");
		
		if($rs){
			pd_setcookie('phpdisk_zcore_info',pd_encode("{$rs['userid']}\t{$rs['gid']}\t{$rs['username']}\t{$rs['password']}\t{$rs['email']}"),86400*7);
			header('Location:'.$settings[phpdisk_url].urr("mydisk",""));
			echo 'Loading...';
			exit();
		}
	}else{
		header('Location:'.$settings[phpdisk_url]);
		exit();
	}
}else{
	header('Location:'.$settings[phpdisk_url]);
	exit();
}

							


?>


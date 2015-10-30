<?php 
##
#	Project: PHPDisk
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: passport.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2009 PHPDisk Team. All Rights Reserved.
#
##
include '../../includes/commons.inc.php';

//print_r($_POST);
$param = trim(gpc('param','G',''));
if($param){
	parse_str(pd_encode(base64_decode($param),'DECODE'));
}else{
	exit('Error Param');
}

$username = is_utf8() ? $username : convert_str('utf-8','gbk',$username);
$password = is_utf8() ? $password : convert_str('utf-8','gbk',$password);
$username = $db->escape($username);
$password = $db->escape($password);

if($action=='passportlogin'){
	$rs = $db->fetch_one_array("select userid,gid,username,password,email from {$tpf}users where username='$username' and password='$password' limit 1");
	if($rs){
		pd_setcookie('phpdisk_info',pd_encode("{$rs[userid]}\t{$rs[gid]}\t{$rs[username]}\t{$rs[password]}\t{$rs[email]}"));
		header("Location: ".$settings[phpdisk_url].urr("mydisk",""));
	}else{
		exit('Passport Error!');
	}
}

exit;
?>

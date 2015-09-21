<?php 
##
#	Project: PHPDisk Enterprice Edition
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: phpdisk_multi_client.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##

include 'includes/commons.inc.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHPDisk Remote Server</title>
<style type="text/css">body{font-size:12px}</style>
</head>

<body>
<?
$code = gpc('code','G','');
if($code && ($code==$configs['server_key'])){
	echo "PHPDISK Multi-Server Test Tool. <br><br>";
	echo "<span style='color:#0000FF'>Multi-Server Install Success.</span><br>";
	echo "Time:".date("Y-m-d H:i:s");
}else{
	echo "<span style='color:#FF0000'>[PHPDISK] Server Key Error!</span>";
}
?>
</body>
</html>
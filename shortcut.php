<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: shortcut.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$url = trim(gpc('url','G',''));
$name = trim(gpc('name','G',''));

if($url){
	$shortcut = "[InternetShortcut]
URL=$url
IDList=
IconIndex=1
IconFile=C:\Program Files\Internet Explorer\iexplore.exe
[{000214A0-0000-0000-C000-000000000046}]Prop3=19,2";
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".convert_str('utf-8','gbk',$name).".url;");
	echo $shortcut;
}
exit;
?>
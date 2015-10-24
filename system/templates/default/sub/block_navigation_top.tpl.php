<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-09-23 21:41:40

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_navigation_top.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php 
if(count($C[navi_top_link])){
	foreach($C[navi_top_link] as $v){
 ?>
<a href="<?=$v['href']?>" target="<?=$v['target']?>" title="<?=$v['title']?>"><?=$v['text']?></a>&nbsp;
<?php 
	}
}
 ?>

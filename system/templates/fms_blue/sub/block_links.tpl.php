<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-27 18:27:46

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_links.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php 
if(count($C[links_arr])){
 ?>
<div class="f_link">
<div class="tit"><img src="images/link_icon.gif" align="absmiddle" border="0" /> <?=__('site_link')?></div>
<div class="ctn">
<?php 
	foreach($C[links_arr] as $k => $v){
		if($v[has_logo]){
 ?>
	<a href="<?=$v['url']?>" target="_blank"><img src="<?=$v['logo']?>" align="absbottom" border="0" alt="<?=$v['title']?>"></a>&nbsp;
<?php 
	}else{
 ?>
	<a href="<?=$v['url']?>" target="_blank"><?=$v['title']?></a>&nbsp;
<?php 
	}
	}
 ?>
</div>
</div>
<?php 
}
 ?>

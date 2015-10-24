<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-09-26 17:55:14

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_index_tag.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="tag_box">
<div class="tit2"><?=__('last_tag_title')?></div>
<div class="ctn">
<?php 
if(count($C[index_tags])){
	foreach($C[index_tags] as $v){
 ?>
<a href="<?=$v['a_view_tag']?>" target="_blank"><?=$v['tag_name']?><span class="txtgray"><?=$v['tag_count']?></span></a>
<?php 
	}
	unset($C[index_tags]);
}
 ?>
</div>
<div class="clear"></div>
</div>

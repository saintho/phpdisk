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
#	$Id: block_file_index.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="fl_box">
<div class="tit2"><span style="float:right;"><a href="<?=urr("public","")?>" title="<?=__('more')?>"><img src="images/more.gif" align="absmiddle" border="0"></a></span><?=__('last_file')?></div>
<ul>
<?php 
if(count($C[last_file])){
	foreach($C[last_file] as $v){
 ?>
	<li><?=$v['file_time']?><a href="<?=$v['a_viewfile']?>" target="_blank" title="<?=$v['file_name']?>"><?=$v[file_icon]?><?=$v['file_name']?></a></li>
<?php 
	}
}
 ?>
</ul>
</div>

<div class="fl_box" style="margin-left:10px">
<div class="tit2"><?=__('commend_file_list')?></div>
<ul>
<?php 
if(count($C[commend_file])){
	foreach($C[commend_file] as $v){
 ?>
	<li><?=$v['file_time']?><a href="<?=$v['a_viewfile']?>" target="_blank" title="<?=$v['file_name']?>"><?=$v[file_icon]?><?=$v['file_name']?></a></li>
<?php 
	}
}
 ?>
</ul>
</div>

<div class="clear"></div>

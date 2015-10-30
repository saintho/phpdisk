<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-27 20:50:05

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_cate_last_file.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="panel panel-default">
	<div class="panel-heading"><?=__('this_cate_last_file_list')?></div>
	<ul class="list-group">
	<?php 
	if(count($C[cate_last_file])){
		foreach($C[cate_last_file] as $v){
	 ?>
		<li class="list-group-item"><?=$v['file_size']?><a href="<?=$v['a_viewfile']?>" target="_blank"><?=$v['file_name']?></a></li>
	<?php 
		}
	}
	 ?>
	</ul>
</div>

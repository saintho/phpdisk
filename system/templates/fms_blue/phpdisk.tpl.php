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
#	$Id: phpdisk.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="index_box">
<?php require_once template_echo('sub/block_adv_middle','templates/fms_blue/'); ?>
<div class="l">
<?php require_once template_echo('sub/block_file_index','templates/fms_blue/'); ?>
<br />
<?php require_once template_echo('sub/block_index_tag','templates/fms_blue/'); ?>
</div>
<div class="r">
 <?php require_once template_echo('sub/block_share_file_box','templates/fms_blue/'); ?>
	<br />
 <?php require_once template_echo('sub/block_announce_list','templates/fms_blue/'); ?>
	<br />
 <div class="idx_r_box"> 
 <div class="tit"><?=__('last_user_list')?></div>
 <ul>
 	<?php 
	if(count($C[last_users])){
		foreach($C[last_users] as $v){
	 ?>
 	<li><span class="txtgray" style="float:right"><?=$v[reg_time]?></span><a href="<?=$v[a_space]?>" target="_blank"><img src="images/demo_icon.gif" align="absmiddle" border="0" /><?=$v[username]?></a></li>
	<?php 
		}
		unset($C[last_users]);
	}
	 ?>
 </ul>
 </div>
  
</div>
<div class="clear"></div>
</div>
<div class="index_box">
<?php if(!$settings[close_index_stats]){ ?>
<div class="f_link">
<div class="tit"><span><img src="images/stat_icon.gif" align="absmiddle" border="0" /><?=__('site_stat')?></span></div>
<div class="ctn"><?=__('welcome_member')?>:<a href="<?=$C[last_one]['a_last_user']?>" title="<?=$C[last_one]['username_all']?>"><b><?=$C[last_one]['username']?></b></a> , <?=__('all_member')?>: <b><?=$stats['users_count']?></b> , <?=__('all_file')?>: <b><?=$stats['all_files_count']?></b> , <?=__('all_storage')?>: <b><?=$stats['total_storage_count']?></b>
</div>
</div>
<?php } ?>
<?php require_once template_echo('sub/block_links','templates/fms_blue/'); ?>
<div class="clear"></div>
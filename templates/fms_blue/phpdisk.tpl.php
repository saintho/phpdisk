<!--#
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
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="index_box">
<!--#include sub/block_adv_middle#-->
<div class="l">
<!--#include sub/block_file_index#-->
<br />
<!--#include sub/block_index_tag#-->
</div>
<div class="r">
 <!--#include sub/block_share_file_box#-->
	<br />
 <!--#include sub/block_announce_list#-->
	<br />
 <div class="idx_r_box"> 
 <div class="tit"><?=__('last_user_list')?></div>
 <ul>
 	<!--#
	if(count($C[last_users])){
		foreach($C[last_users] as $v){
	#-->
 	<li><span class="txtgray" style="float:right">{$v[reg_time]}</span><a href="{$v[a_space]}" target="_blank"><img src="images/demo_icon.gif" align="absmiddle" border="0" />{$v[username]}</a></li>
	<!--#
		}
		unset($C[last_users]);
	}
	#-->
 </ul>
 </div>
  
</div>
<div class="clear"></div>
</div>
<div class="index_box">
<!--#if(!$settings[close_index_stats]){#-->
<div class="f_link">
<div class="tit"><span><img src="images/stat_icon.gif" align="absmiddle" border="0" /><?=__('site_stat')?></span></div>
<div class="ctn"><?=__('welcome_member')?>:<a href="{$C[last_one]['a_last_user']}" title="{$C[last_one]['username_all']}"><b>{$C[last_one]['username']}</b></a> , <?=__('all_member')?>: <b>{$stats['users_count']}</b> , <?=__('all_file')?>: <b>{$stats['all_files_count']}</b> , <?=__('all_storage')?>: <b>{$stats['total_storage_count']}</b>
</div>
</div>
<!--#}#-->
<!--#include sub/block_links#-->
<div class="clear"></div>
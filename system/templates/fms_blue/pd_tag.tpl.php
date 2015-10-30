<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-27 21:36:39

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_tag.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<script language="javascript">
$(document).ready(function(){
	$("#f_tab tr").mouseover(function(){
		$(this).addClass("alt_bg");
	}).mouseout(function(){
		$(this).removeClass("alt_bg");
	});
});
</script>
<div id="container">
<div class="layout_box">
<?php require_once template_echo('sub/block_adv_middle','templates/fms_blue/'); ?>
<div class="l">
<?php show_adv_data('adv_right'); ?>
<?php require_once template_echo('sub/block_share_file_box','templates/fms_blue/'); ?>
<br />
<?php require_once template_echo('sub/block_last_week_down_file','templates/fms_blue/'); ?>
</div>
<div class="r">
<div class="tit"><?=$tag_title?></div>
<?php if(!$tag){ ?>
<div class="tag_list">
<div class="t_tit"><?=__('last_tag_title')?></div>
<ul>
<li>
<?php 
if(count($last_tags)){
	foreach($last_tags as $v){
 ?>
<a href="<?=$v['a_view_tag']?>"><?=$v['tag_name']?><span class="txtgray"><?=$v['tag_count']?></span></a>
<?php 
	}
	unset($last_tags);
}
 ?>
</li>
</ul>
<br />
<div class="clear"></div>
</div>
<br />
<div class="tag_list">
<div class="t_tit"><?=__('hot_tag_title')?></div>
<ul>
<li>
<?php 
if(count($hot_tags)){
	foreach($hot_tags as $v){
 ?>
<a href="<?=$v['a_view_tag']?>"><?=$v['tag_name']?><span class="txtgray"><?=$v['tag_count']?></span></a>
<?php 
	}
	unset($hot_tags);
}
 ?>
</li>
</ul>
<br />
<div class="clear"></div>
</div>
<?php }else{ ?>
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line">
<?php 
if(count($files_array)){
 ?>
<tr class="head_bar">
	<td width="50%" class="bold"><?=__('file_name')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td align="center" width="150" class="bold"><?=__('file_upload_time')?></td>
</tr>
<?php 
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>" height="20">
	<td class="td_line">&nbsp;<?=file_icon($v['file_extension'])?>&nbsp;
	<?php if($v['is_locked']){ ?>
	<span class="txtgray" title="<?=__('file_locked')?>"><?=$v['file_name']?> <?=$v['file_description']?></span>
	<?php }elseif($v['is_image']){ ?>
	<a href="<?=$v['a_viewfile']?>" id="p_<?=$k?>" target="_blank" ><?=$v['file_name']?></a>&nbsp;<span class="txtgray"><?=$v['file_description']?></span><br />
<div id="c_<?=$k?>" class="menu_thumb"><img src="<?=$v['file_thumb']?>" /></div>
<script type="text/javascript">on_menu('p_<?=$k?>','c_<?=$k?>','x','');</script>
	<?php }else{ ?>
	<a href="<?=$v['a_viewfile']?>" target="_blank" ><?=$v['file_name']?></a> <span class="txtgray"><?=$v['file_description']?></span>
	<?php } ?>
	</td>
	<td align="center" class="td_line"><?=$v['file_size']?></td>
	<td align="center" width="150"  class="td_line txtgray"><?=$v['file_time']?></td>
</tr>
<?php 		
	}
	unset($files_array);
}	
 ?>
<?php if($page_nav){ ?>
<tr>
	<td colspan="6"><?=$page_nav?></td>
</tr>
<?php } ?>
</table>
<?php } ?>
</div>
<div class="clear"></div>
</div>
</div>
<Br />
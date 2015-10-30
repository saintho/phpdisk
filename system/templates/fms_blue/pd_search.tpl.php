<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-27 21:53:26

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_search.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<?php require_once template_echo('sub/block_adv_middle','templates/fms_blue/'); ?>
<div class="tit"><?=__('search_title')?></div>
<div class="layout_box2">
<div class="m" <?php if($action =='search'){ ?>style="padding:10px"<?php } ?>>
<?php if(!$error){ ?>
<form name="search_frm" action="<?=urr("search","")?>" method="get" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="search" />
<table align="center"<?php if($action =='search'){ ?> width="98%" <?php } ?> cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="td_box"><?=__('keyword')?>: <input type="text" name="word" size="30" value="<?=$word?>" title="<?=__('search_files_tips')?>" class="td_input" />
	<?php if($pd_uid){ ?>
	<select name="scope" class="td_sel">
	<option value="all" <?=ifselected('all',$scope,'str')?>><?=__('all_file')?></option>
	<option value="mydisk" <?=ifselected('mydisk',$scope,'str')?>><?=__('scope_mydisk')?></option>
	</select>
	<?php } ?>
	<input type="submit" class="btn" value="<?=__('search')?>" /></td>
</tr>
</table>
</form>
<script language="javascript">
document.search_frm.word.focus();
function dosubmit(o){
	if(o.word.value.strtrim().length <1){
		o.word.focus();
		return false;
	}
}
</script>
<?php if($action =='search'){ ?>
<script language="javascript">
$(document).ready(function(){
	$("#f_tab tr").mouseover(function(){
		$(this).addClass("alt_bg");
	}).mouseout(function(){
		$(this).removeClass("alt_bg");
	});
});
</script>
<br />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line">
<?php 
if(count($files_array)){
 ?>
<tr class="head_bar">
	<td width="40%" class="bold"><a href="<?=$n_url?>"><?=__('file_name')?><?=$n_order?></a></td>
	<?php if(!$settings['open_vip']){ ?>
	<td align="center" class="bold"><a href="<?=$u_url?>"><?=__('username')?><?=$u_order?></a></td>
	<?php } ?>
	<td align="center" class="bold"><?=__('file_views')?></td>
	<td align="center" class="bold"><?=__('file_downs')?></td>
	<td align="center" class="bold"><a href="<?=$s_url?>"><?=__('file_size')?><?=$s_order?></a></td>
	<td align="center" width="150" class="bold"><a href="<?=$t_url?>"><?=__('file_upload_time')?><?=$t_order?></a></td>
</tr>
<?php 
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>">
	<td class="f14">
	<?php if($settings['open_vip']){ ?>
	<?php if(!$pd_uid){ ?>
		<?=file_icon($v['file_extension'])?><a href="javascript:alert('<?=__('vip_user_download')?>');"><?=$v['file_name_all']?></a><br /><span class="txtgray"><?=$v['file_description']?></span>
	<?php }elseif(get_profile($pd_uid,'vip_end_time')>$timestamp){ ?>
		<?php if(get_vip(get_profile($pd_uid,'vip_id'),'search_down')){ ?>
			<?=file_icon($v['file_extension'])?><a href="javascript:alert('<?=__('vip_user_download')?>');"><?=$v['file_name_all']?></a><br /><span class="txtgray"><?=$v['file_description']?></span>
		<?php }else{ ?>
			<?php if($v['is_image']){ ?>
			<?=file_icon($v['file_extension'])?><a href="<?=$v['a_viewfile']?>" id="p_<?=$k?>" target="_blank" ><?=$v['file_name_all']?></a><br /><span class="txtgray"><?=$v['file_description']?></span>
		<div id="c_<?=$k?>" class="menu_thumb"><img src="<?=$v['file_thumb']?>" /></div>
		<script type="text/javascript">on_menu('p_<?=$k?>','c_<?=$k?>','x','');</script>
			<?php }else{ ?>
			<?=file_icon($v['file_extension'])?><a href="<?=$v['a_viewfile']?>" target="_blank" ><?=$v['file_name_all']?></a><br /><span class="txtgray"><?=$v['file_description']?></span>
			<?php } ?>
		<?php } ?>
		
	<?php }else{ ?>
		<?=file_icon($v['file_extension'])?><a href="javascript:alert('<?=__('vip_user_download')?>');"><?=$v['file_name_all']?></a><br /><span class="txtgray"><?=$v['file_description']?></span>
	<?php } ?>
	
	<?php }else{ ?>
		<?php if($v['is_image']){ ?>
		<?=file_icon($v['file_extension'])?><a href="<?=$v['a_viewfile']?>" id="p_<?=$k?>" target="_blank" ><?=$v['file_name_all']?></a><br /><span class="txtgray"><?=$v['file_description']?></span>
	<div id="c_<?=$k?>" class="menu_thumb"><img src="<?=$v['file_thumb']?>" /></div>
	<script type="text/javascript">on_menu('p_<?=$k?>','c_<?=$k?>','x','');</script>
		<?php }else{ ?>
		<?=file_icon($v['file_extension'])?><a href="<?=$v['a_viewfile']?>" target="_blank" ><?=$v['file_name_all']?></a><br /><span class="txtgray"><?=$v['file_description']?></span>
		<?php } ?>
	<?php } ?>
	</td>
	<?php if(!$settings['open_vip']){ ?>
	<td align="center"><a href="<?=$v['a_space']?>" target="_blank"><?=$v['username']?></a></td>
	<?php } ?>
	<td align="center"><?=get_discount($v[userid],$v['file_views'])?></td>
	<td align="center"><?=get_discount($v[userid],$v['file_downs'])?></td>
	<td align="center"><?=$v['file_size']?></td>
	<td align="center" width="150"  class="td_line txtgray"><?=$v['file_time']?></td>
</tr>
<?php 		
	}
	unset($files_array);
}else{	
 ?>
<tr>
	<td colspan="6"><?=__('search_is_empty')?></td>
</tr>
<?php 
}
 ?>
<?php if($page_nav){ ?>
<tr>
	<td colspan="6" class="head_bar"><?=$page_nav?></td>
</tr>
<?php } ?>
</table>
<?php } ?>
<?php } ?>
</div>
</div>
</div>
<br />
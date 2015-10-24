<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-03 18:56:24

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_hotfile.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="layout_box">
<?php require_once template_echo('sub/block_adv_middle','templates/fms_blue/'); ?>
<div class="l">
<?php require_once template_echo('sub/block_hot_cate_list','templates/fms_blue/'); ?>
<br />
<?php show_adv_data('adv_right'); ?>
<?php require_once template_echo('sub/block_cate_last_file','templates/fms_blue/'); ?>
<br />
<?php require_once template_echo('sub/block_yesterday_down_file','templates/fms_blue/'); ?>
</div>
<div class="r">
<div class="file_box">
	<h2 class="file_tit"><?=$nav_title?></h2>
	<div class="dl_nav">
	<ul>
		<li><a href="<?=urr("hotfile","o_type=d_all&cate_id=0")?>" id="a_dlnv_"><span class="txtred"><?=__('all_site_download')?></span></a></li>
		<li><a href="<?=urr("hotfile","o_type=d_all&cate_id=$cate_id")?>" id="a_dlnv_d_all"><span><?=__('all_download')?></span></a></li>
		<li><a href="<?=urr("hotfile","o_type=d_day&cate_id=$cate_id")?>" id="a_dlnv_d_day"><span><?=__('yesterday_download')?></span></a></li>
		<li><a href="<?=urr("hotfile","o_type=d_3day&cate_id=$cate_id")?>" id="a_dlnv_d_3day"><span><?=__('3day_download')?></span></a></li>
		<li><a href="<?=urr("hotfile","o_type=d_now_week&cate_id=$cate_id")?>" id="a_dlnv_d_now_week"><span><?=__('now_week_download')?></span></a></li>
		<li><a href="<?=urr("hotfile","o_type=d_week&cate_id=$cate_id")?>" id="a_dlnv_d_week"><span><?=__('last_week_download')?></span></a></li>
		<li><a href="<?=urr("hotfile","o_type=d_month&cate_id=$cate_id")?>" id="a_dlnv_d_month"><span><?=__('the_month_download')?></span></a></li>
	</ul>
	</div>
	<div class="clear"></div>
<?php if(!$cate_id){ ?>
<script type="text/javascript">getId('a_dlnv_').className='cate_sel2';</script>	
<?php }else{ ?>
<script type="text/javascript">getId('a_dlnv_<?=$o_type?>').className='cate_sel';</script>	
<?php } ?>
	<br />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line">
<tr class="head_bar">
	<td width="60%" class="bold"><?=__('file_name')?></td>
	<td align="center" class="bold"><?=__('username')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td align="right" width="100" class="bold"><?=__('file_upload_time')?></td>
</tr>
<?php 
if(count($files_array)){
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>">
	<td class="f14 bw">&nbsp;<?=file_icon($v['file_extension'])?>
	<?php if($v['is_image']){ ?>
	<a href="<?=$v['a_viewfile']?>" id="p_<?=$k?>" target="_blank" ><?=$v['file_name_all']?></a><br /><span class="txtgray"><?=$v['file_description']?></span>
<div id="c_<?=$k?>" class="menu_thumb"><img src="<?=$v['file_thumb']?>" /></div>
<script type="text/javascript">on_menu('p_<?=$k?>','c_<?=$k?>','x','');</script>
	<?php }else{ ?>
	<a href="<?=$v['a_viewfile']?>" target="_blank" ><?=$v['file_name_all']?></a><br /><span class="txtgray"><?=$v['file_description']?></span>
	<?php } ?>
	</td>
	<td align="center"><a href="<?=$v['a_space']?>" target="_blank"><?=$v['username']?></a></td>
	<td align="center"><?=$v['file_size']?></td>
	<td align="right" class="td_line txtgray"><?=$v['file_time']?></td>
</tr>
<?php 		
	}
	unset($files_array);
}else{	
 ?>
<tr>
	<td colspan="6"><?=__('file_not_found')?></td>
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
</div>

</div>
<div class="clear"></div>
</div>


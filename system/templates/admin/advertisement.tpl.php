<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2014-04-29 00:37:10

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: advertisement.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php 
if($action =='add_adv' || $action =='modify_adv'){
 ?>
<div id="container">
<?php if($action =='add_adv'){ ?>
<h1><?=__('add_advs_title')?></h1>
<?php }else{ ?>
<h1><?=__('modify_advs_title')?></h1>
<?php } ?>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('adv_manage_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=advertisement&menu=extend")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="advid" value="<?=$advid?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><b><?=__('adv_position')?>:</b><br /><span class="txtgray"><?=__('adv_position_tips')?></span></td>
	<td><select name="adv_position">
	<option value="adv_top" <?=ifselected('adv_top',$adv_position,'str')?>><?=__('adv_top')?></option>
	<option value="adv_right" <?=ifselected('adv_right',$adv_position,'str')?>><?=__('adv_right')?></option>
	<option value="adv_viewfile_right" <?=ifselected('adv_viewfile_right',$adv_position,'str')?>><?=__('adv_viewfile_right')?></option>
	<option value="adv_viewfile_hits_bottom" <?=ifselected('adv_viewfile_hits_bottom',$adv_position,'str')?>><?=__('adv_viewfile_hits_bottom')?></option>
	<option value="adv_viewfile_download_top" <?=ifselected('adv_viewfile_download_top',$adv_position,'str')?>><?=__('adv_viewfile_download_top')?></option>
	<option value="adv_viewfile_download_bottom" <?=ifselected('adv_viewfile_download_bottom',$adv_position,'str')?>><?=__('adv_viewfile_download_bottom')?></option>
	<?php if($auth[is_fms]){ ?>
	<option value="adv_midddle" <?=ifselected('adv_midddle',$adv_position,'str')?>><?=__('adv_midddle')?></option>
	<option value="adv_download_top" <?=ifselected('adv_download_top',$adv_position,'str')?>><?=__('adv_download_top')?></option>
	<option value="adv_download_inner" <?=ifselected('adv_download_inner',$adv_position,'str')?>><?=__('adv_download_inner')?></option>
	<option value="adv_download_bottom" <?=ifselected('adv_download_bottom',$adv_position,'str')?>><?=__('adv_download_bottom')?></option>
	<option value="adv_download_side" <?=ifselected('adv_download_side',$adv_position,'str')?>><?=__('adv_download_side')?></option>
	<?php } ?>
	<option value="adv_bottom" <?=ifselected('adv_bottom',$adv_position,'str')?>><?=__('adv_bottom')?></option>
</select>
</td>
</tr>
<tr>
	<td><b><?=__('adv_scope')?>:</b><br /><span class="txtgray"><?=__('adv_scope_tips')?></span></td>
	<td><select name="adv_scope[]" multiple="multiple" style="width:120px" size="5">
	<option value="all" style="color:#0000FF" <?=multi_selected('all',$adv_scope)?>><?=__('adv_scope_all')?></option>
	<option value="index" <?=multi_selected('index',$adv_scope)?>><?=__('adv_scope_index')?></option>
	<option value="viewfile" <?=multi_selected('viewfile',$adv_scope)?>><?=__('adv_scope_viewfile')?></option>
	<option value="space" <?=multi_selected('space',$adv_scope)?>><?=__('adv_scope_space')?></option>
	<option value="search" <?=multi_selected('search',$adv_scope)?>><?=__('adv_scope_search')?></option>
	<option value="public" <?=multi_selected('public',$adv_scope)?>><?=__('adv_scope_public')?></option>
	<option value="extract" <?=multi_selected('extract',$adv_scope)?>><?=__('adv_scope_extract')?></option>
	<option value="tag" <?=multi_selected('tag',$adv_scope)?>><?=__('adv_scope_tag')?></option>
	<?php if($auth[is_fms]){ ?>
	<option value="hotfile" <?=multi_selected('hotfile',$adv_scope)?>><?=__('adv_scope_hotfile')?></option>
	<?php } ?>
	</select></td>
</tr>
<tr>
	<td><b><?=__('adv_title')?>:</b><br /><span class="txtgray"><?=__('adv_title_tips')?></span></td>
	<td><input type="text" name="adv_title" size="50" value="<?=$adv_title?>" maxlength="100" /></td>
</tr>
<tr>
	<td><b><?=__('adv_starttime')?>(<?=__('optional')?>):</b><br /><span class="txtgray"><?=__('adv_starttime_tips')?></span></td>
	<td><input type="text" name="adv_starttime" value="<?=$adv_starttime?>" maxlength="10" /> (<?=__('time_format')?>)</td>
</tr>
<tr>
	<td><b><?=__('adv_endtime')?>(<?=__('optional')?>):</b><br /><span class="txtgray"><?=__('adv_endtime_tips')?></span></td>
	<td><input type="text" name="adv_endtime" value="<?=$adv_endtime?>" maxlength="10" /> (<?=__('time_format')?>)</td>
</tr>
<tr>
	<td><b><?=__('adv_type')?>:</b><br /><span class="txtgray"><?=__('adv_type_tips')?></span></td>
	<td>
	<select id="adv_type" name="adv_type" onchange="chg_adv_type(this.options[this.selectedIndex].value);">
		<option value="adv_img" <?=ifselected('adv_img',$adv_type,'str')?>><?=__('adv_img')?></option>
		<option value="adv_code" <?=ifselected('adv_code',$adv_type,'str')?>><?=__('adv_code')?></option>
		<option value="adv_text" <?=ifselected('adv_text',$adv_type,'str')?>><?=__('adv_text')?></option>
		<option value="adv_flash" <?=ifselected('adv_flash',$adv_type,'str')?>><?=__('adv_flash')?></option>
	</select>&nbsp;
	</td>
</tr>
</table>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tbody id="adv_1" style="display:none">
<tr>
	<td colspan="2" class="bold"><?=__('adv_img')?>:</td>
</tr>
<tr>
	<td width="40%"><b><?=__('adv_img_src')?>:</b><br /><span class="txtgray"><?=__('adv_img_src_tips')?></span></td>
	<td><input type="text" name="adv_img_src" size="50" value="<?=$adv_img_src?>" maxlength="255" /></td>
</tr>
<tr>
	<td><b><?=__('adv_img_url')?>:</b><br /><span class="txtgray"><?=__('adv_img_url_tips')?></span></td>
	<td><input type="text" name="adv_img_url" size="50" value="<?=$adv_img_url?>" maxlength="255" /></td>
</tr>
<tr>
	<td><b><?=__('adv_img_width')?>(<?=__('optional')?>):</b><br /><span class="txtgray"><?=__('adv_img_width_tips')?></span></td>
	<td><input type="text" name="adv_img_width" size="50" value="<?=$adv_img_width?>" maxlength="255" /></td>
</tr>
<tr>
	<td><b><?=__('adv_img_height')?>(<?=__('optional')?>):</b><br /><span class="txtgray"><?=__('adv_img_height_tips')?></span></td>
	<td><input type="text" name="adv_img_height" size="50" value="<?=$adv_img_height?>" maxlength="255" /></td>
</tr>
<tr>
	<td><b><?=__('adv_img_alt')?>(<?=__('optional')?>):</b><br /><span class="txtgray"><?=__('adv_img_alt_tips')?></span></td>
	<td><input type="text" name="adv_img_alt" size="50" value="<?=$adv_img_alt?>" maxlength="255" /></td>
</tr>
</tbody>
<tbody id="adv_2" style="display:none">
<tr>
	<td colspan="2" class="bold"><?=__('adv_code')?>:</td>
</tr>
<tr>
	<td width="40%"><b><?=__('adv_html_code')?>:</b><br /><span class="txtgray"><?=__('adv_html_code_tips')?></span></td>
	<td><textarea id="adv_html_code" name="adv_html_code" style="width:350px;height:100px"><?=$adv_html_code?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('adv_html_code','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('adv_html_code','sub');">[-]</a></td>
</tr>
</tbody>
<tbody id="adv_3" style="display:none">
<tr>
	<td colspan="2" class="bold"><?=__('adv_text')?>:</td>
</tr>
<tr>
	<td width="40%"><b><?=__('adv_txt_title')?>:</b><br /><span class="txtgray"><?=__('adv_txt_title_tips')?></span></td>
	<td><input type="text" name="adv_txt_title" size="50" value="<?=$adv_txt_title?>" maxlength="255" /></td>
</tr>
<tr>
	<td><b><?=__('adv_txt_url')?>:</b><br /><span class="txtgray"><?=__('adv_txt_url_tips')?></span></td>
	<td><input type="text" name="adv_txt_url" size="50" value="<?=$adv_txt_url?>" maxlength="255" /></td>
</tr>
<tr>
	<td><b><?=__('adv_txt_size')?>(<?=__('optional')?>):</b><br /><span class="txtgray"><?=__('adv_txt_size_tips')?></span></td>
	<td><input type="text" name="adv_txt_size" size="50" value="<?=$adv_txt_size?>" maxlength="255" /></td>
</tr>
<tr>
	<td><b><?=__('adv_txt_color')?>(<?=__('optional')?>):</b><br /><span class="txtgray"><?=__('adv_txt_color_tips')?></span></td>
	<td><input type="text" name="adv_txt_color" size="50" value="<?=$adv_txt_color?>" maxlength="255" /></td>
</tr>
</tbody>
<tbody id="adv_4" style="display:none">
<tr>
	<td colspan="2" class="bold"><?=__('adv_flash')?>:</td>
</tr>
<tr>
	<td width="40%"><b><?=__('adv_flash_src')?>:</b><br /><span class="txtgray"><?=__('adv_flash_src_tips')?></span></td>
	<td><input type="text" name="adv_flash_src" size="50" value="<?=$adv_flash_src?>" maxlength="255" /></td>
</tr>
<tr>
	<td><b><?=__('adv_flash_width')?>:</b><br /><span class="txtgray"><?=__('adv_flash_width_tips')?></span></td>
	<td><input type="text" name="adv_flash_width" size="50" value="<?=$adv_flash_width?>" maxlength="255" /></td>
</tr>
<tr>
	<td><b><?=__('adv_flash_height')?>:</b><br /><span class="txtgray"><?=__('adv_flash_height_tips')?></span></td>
	<td><input type="text" name="adv_flash_height" size="50" value="<?=$adv_flash_height?>" maxlength="255" /></td>
</tr>
</tbody>
<tr>
	<td width="40%">&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
function chg_adv_type(adv_type){
	if(adv_type == 'adv_code'){
		var j = 2;
	}else if(adv_type =='adv_text'){
		var j = 3;
	}else if(adv_type =='adv_flash'){
		var j = 4;
	}else{
		var j =1;
	}
	for(var i=1;i<=4;i++){
		getId('adv_'+i).style.display = 'none';
	}
	getId('adv_'+j).style.display = '';
}
function dosubmit(o){
	if(o.adv_title.value.strtrim().length <1){
		alert("<?=__('adv_title_error')?>");
		o.adv_title.focus();
		return false;
	}
	var st = o.adv_starttime.value.strtrim();
	var et = o.adv_endtime.value.strtrim();
	if(st !=''){
		if(st.length !=10 || st.indexOf('-') !=4 ){
			alert("<?=__('time_format_error')?>");
			o.adv_starttime.focus();
			return false;
		}
	}
	if(et != ''){
		if(et.length !=10 || et.indexOf('-') !=4 ){
			alert("<?=__('time_format_error')?>");
			o.adv_endtime.focus();
			return false;
		}
	}
}
chg_adv_type('<?=$adv_type?>');
</script>
<?php 
}else{
 ?>
<div id="container">
<h1><?=__('adv_manage')?><?php sitemap_tag(__('adv_manage')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('adv_manage_tips')?></span>
</div>
<div style=" padding:8px"><b><?=__('add_advs_title')?>: </b>
<select id="adv_type">
	<option value="adv_img"><?=__('adv_img')?></option>
	<option value="adv_code"><?=__('adv_code')?></option>
	<option value="adv_text"><?=__('adv_text')?></option>
	<option value="adv_flash"><?=__('adv_flash')?></option>
</select>&nbsp;
<select id="adv_position" onchange="chg_adv_position();">
	<option value="0" class="txtgreen"><?=__('please_select')?></option>
	<option value="adv_top"><?=__('adv_top')?></option>
	<option value="adv_right"><?=__('adv_right')?></option>
	<option value="adv_viewfile_right"><?=__('adv_viewfile_right')?></option>
	<option value="adv_viewfile_hits_bottom"><?=__('adv_viewfile_hits_bottom')?></option>
	<option value="adv_viewfile_download_top"><?=__('adv_viewfile_download_top')?></option>
	<option value="adv_viewfile_download_bottom"><?=__('adv_viewfile_download_bottom')?></option>
	<?php if($auth[is_fms]){ ?>
	<option value="adv_midddle"><?=__('adv_midddle')?></option>
	<option value="adv_download_top"><?=__('adv_download_top')?></option>
	<option value="adv_download_inner"><?=__('adv_download_inner')?></option>
	<option value="adv_download_bottom"><?=__('adv_download_bottom')?></option>
	<option value="adv_download_side"><?=__('adv_download_side')?></option>
	<?php } ?>
	<option value="adv_bottom"><?=__('adv_bottom')?></option>
</select>
</div>
<br />
<form name="adv_form" action="<?=urr(ADMINCP,"item=advertisement&menu=extend")?>" method="post">
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<?php 
if(count($advs)){
 ?>
<tr>
	<td width="30" align="center" class="bold"><?=__('show_order')?></td>
	<td width="30" align="center" class="bold"><?=__('is_hidden')?></td>
	<td class="bold"><?=__('adv_title')?></td>
	<td class="bold"><?=__('adv_position')?></td>
	<td class="bold"><?=__('adv_type')?></td>
	<td class="bold"><?=__('adv_starttime')?></td>
	<td class="bold"><?=__('adv_endtime')?></td>
	<td class="bold"><?=__('operation')?></td>
</tr>
<?php 
	foreach($advs as $k => $v){
 ?>
<tr>
	<td>
	<input type="text" name="show_order[]" value="<?=$v['show_order']?>" style="width:20px; text-align:center" maxlength="2" />
	<input type="hidden" name="advids[]" value="<?=$v['advid']?>" />
	</td>
	<td><input type="checkbox" name="is_hidden[<?=$v['advid']?>]" value="1" <?=ifchecked($v['is_hidden'],1)?>/></td>
	<td><input type="text" name="adv_titles[]" value="<?=$v['title']?>" size="30" /></td>
	<td><?=__($v['adv_position'])?></td>
	<td><?=__($v['adv_type'])?></td>
	<td><?=$v['adv_starttime']?></td>
	<td><?=$v['adv_endtime']?></td>
	<td><a href="<?=$v['a_modify_adv']?>" id="p_<?=$k?>"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>
	<div id="c_<?=$k?>" class="menu_box2 menu_common">
	<a href="<?=$v['a_modify_adv']?>"><?=__('modify')?></a>
	<a href="<?=$v['a_delete_adv']?>" onclick="return confirm('<?=__('advs_delete_confirm')?>');"><?=__('delete')?></a>
	</div>
	<?=$v['status']?>
	<script type="text/javascript">on_menu('p_<?=$k?>','c_<?=$k?>','-x','');</script>
	</td>
</tr>
<?php 
	}
	unset($advs);
 ?>
<tr>
	<td align="center" colspan="8"> <input type="submit" class="btn" value="<?=__('btn_update')?>"/></td>
</tr>
<?php 
}else{
 ?>
<tr>
	<td colspan="8" align="center"><?=__('advs_not_found')?></td>
</tr>
<?php 
}
 ?>
</table>
</form>
</div>
</div>
<script language="javascript">
function chg_adv_position(){
	var adv_position = getId('adv_position').value;
	var adv_type = getId('adv_type').value;
	if(adv_position != 0){
		document.location.href = '<?=urr(ADMINCP,"item=advertisement&menu=extend&action=add_adv&adv_type='+adv_type+'&adv_position='+adv_position+'")?>';
	}
}
</script>
<?php } ?>

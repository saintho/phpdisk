<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: vip.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action=='list'){#-->
<div id="container">
<h1><?=__('vip_manage')?><!--#sitemap_tag(__('vip_manage'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('vip_manage_tips')?></span>
</div>
<form name="vip_form" action="{#urr(ADMINCP,"item=vip&menu=user")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_vip')?></span>: <br /><span class="txtgray"><?=__('open_vip_tips')?></span></td>
	<td><input type="radio" id="ot1" name="setting[open_vip]" value="1" {#ifchecked(1,$settings['open_vip'])#} /><label for="ot1"><?=__('yes')?></label>&nbsp;&nbsp;<input type="radio" id="ot0" name="setting[open_vip]" value="0" {#ifchecked(0,$settings['open_vip'])#}/><label for="ot2"><?=__('no')?></label></td>
</tr>
</table>
<br />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30" align="center" class="bold"><?=__('show_order')?></td>
	<td class="bold" width="15%"><?=__('vip_subject')?></td>
	<td class="bold" align="center"><?=__('vip_price')?></td>
	<td class="bold" align="center"><?=__('vip_pop_ads')?></td>
	<td class="bold" align="center"><?=__('vip_down_second')?></td>
	<td class="bold" align="center"><?=__('vip_search_down')?></td>
	<!--#if($auth[buy_vip_a]){#-->
	<td class="bold" align="center"><?=__('vip_img_link')?></td>
	<td class="bold" align="center"><?=__('vip_music_link')?></td>
	<td class="bold" align="center"><?=__('vip_video_link')?></td>
	<td class="bold" align="center"><?=__('zero_store_time')?></td>
	<!--#}#-->
	<td class="bold" align="center"><?=__('status')?>|<?=__('user_count')?></td>
	<td class="bold" align="right"><?=__('operation')?></td>
</tr>
<!--#
if(count($vips)){
	foreach($vips as $k=>$v){
#-->
<tr>
	<td>
	<input type="text" name="show_order[]" value="{$v['show_order']}" style="width:20px; text-align:center" maxlength="2" />
	<input type="hidden" name="vip_ids[]" value="{$v['vip_id']}" />
	</td>
	<td><a href="{$v['a_edit_vip']}">{$v['subject']}</a><br /><span class="txtgray">{$v['content']}</span><br />{$v[img]}</td>
	<td align="center">{$v[price]}<?=__('money_unit')?>/{#$day_arr[$v[days]]#}</td>
	<td align="center">{$v[pop_ads]}</td>	
	<td align="center">{$v[down_second]}<?=__('second')?></td>
	<td align="center">{$v[search_down]}</td>
	<!--#if($auth[buy_vip_a]){#-->
	<td align="center">{$v[img_link]}</td>
	<td align="center">{$v[music_link]}</td>
	<td align="center">{$v[video_link]}</td>
	<td align="center">{$v[zero_store_time]}</td>
	<!--#}#-->
	<td align="center"><a href="{$v['a_change_status']}">{$v['status_text']}</a>|<a href="javascript:;" id="svip_{$v[vip_id]}" onclick="vip_count('{$v[vip_id]}')">...</a></td>
	<td align="right">
	<a href="{$v['a_edit_vip']}" id="p_{$k}"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>&nbsp;
	<div id="c_{$k}" class="menu_box2 menu_common">
	<a href="{$v['a_edit_vip']}"><?=__('modify')?></a>
	<a href="{$v['a_del_vip']}" onclick="return confirm('<?=__('vip_delete_confirm')?>');"><?=__('delete')?></a>
	</div>
	</td>
</tr>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','-x','');</script>
<!--#
	}
	unset($vips);
}else{	
#-->
<tr>
	<td align="center" colspan="12"><?=__('vip_not_found')?></td>
</tr>
<!--#
}
#-->
<tr>
	<td align="center" colspan="12"><input type="button" class="btn" value="<?=__('add_vip')?>" onclick="go('{#urr(ADMINCP,"item=vip&menu=user&action=add")#}');" /> <input type="submit" class="btn" value="<?=__('btn_submit')?>" />
	</td>
</tr>
</table>
</form>
</div>
</div>
<script type="text/javascript">
function vip_count(id){
	$.ajax({
		type : 'post',
		url : 'adm_ajax.php',
		data : 'action=vip_count&vip_id='+id+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			var arr = msg.split('|');
			if(arr[0]=='true'){
				$('#svip_'+id).html(arr[1]);
			}else{
				alert(msg);
			}
		},
		error:function(){
		}

	});
}
</script>
<!--#}elseif($action=='add' || $action=='edit'){#-->
<div id="container">
<!--#if($action =='add'){#-->
<h1><?=__('add_vip')?></h1>
<!--#}else{#-->
<h1><?=__('edit_vip')?></h1>
<!--#}#-->
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('add_edit_vip_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=vip&menu=user")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="vip_id" value="{$vip_id}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><b><?=__('vip_subject')?></b>:<br /><span class="txtgray"><?=__('vip_subject_tips')?></span></td>
	<td><input type="text" name="subject" value="{$pa[subject]}" size="50" maxlength="100" /></td>
</tr>
<tr>
	<td><b><?=__('vip_content')?></b>:<br /><span class="txtgray"><?=__('vip_content_tips')?></span></td>
	<td><textarea name="content" id="content" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('content','expand');">{$pa[content]}</textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('content','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('content','sub');">[-]</a></td>
</tr>
<tr>
	<td><b><?=__('vip_img')?></b>:<br /><span class="txtgray"><?=__('vip_img_tips')?></span></td>
	<td><input type="text" name="img" value="{$pa[img]}" size="50" maxlength="255" /></td>
</tr>
<tr>
	<td><b><?=__('vip_price')?></b>:<br /><span class="txtgray"><?=__('vip_price_tips')?></span></td>
	<td><input type="text" name="price" value="{$pa[price]}" size="3" maxlength="5" /><?=__('money_unit')?>/
	<select name="days">
	<option value="7" {#ifselected($pa[days],'7')#}><?=__('one_week')?></option>
	<option value="15" {#ifselected($pa[days],'15')#}><?=__('half_month')?></option>
	<option value="30" {#ifselected($pa[days],'30')#}><?=__('one_month')?></option>
	<option value="60" {#ifselected($pa[days],'60')#}><?=__('two_month')?></option>
	<option value="90" {#ifselected($pa[days],'90')#}><?=__('three_month')?></option>
	<option value="180" {#ifselected($pa[days],'180')#}><?=__('half_year')?></option>
	<option value="365" {#ifselected($pa[days],'365')#}><?=__('one_year')?></option>
	</select></td>
</tr>
<tr>
	<td><b><?=__('vip_pop_ads')?></b>:<br /><span class="txtgray"><?=__('vip_pop_ads_tips')?></span></td>
	<td><input type="radio" name="pop_ads" value="1" {#ifchecked($pa[pop_ads],1)#} /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="pop_ads" value="0" {#ifchecked($pa[pop_ads],0)#} /><?=__('no')?></td>
</tr>
<tr>
	<td><b><?=__('vip_down_second')?></b>:<br /><span class="txtgray"><?=__('vip_down_second_tips')?></span></td>
	<td><input type="text" name="down_second" value="{$pa[down_second]}" size="3" maxlength="3" /></td>
</tr>
<!--#if($auth[open_downline2]){#-->
<tr>
	<td><b>VIP可添加下线数量</b>:<br /><span class="txtgray">此VIP套餐可以添加多少下线用户，只统计后台添加的下线数量</span></td>
	<td><input type="text" name="downline_num" value="{$pa[downline_num]}" size="3" maxlength="5" /></td>
</tr>
<!--#}#-->
<tr>
	<td><b><?=__('vip_search_down')?></b>:<br /><span class="txtgray"><?=__('vip_search_down_tips')?></span></td>
	<td><input type="radio" name="search_down" value="1" {#ifchecked($pa[search_down],1)#} /><?=__('only_search_public')?>&nbsp;&nbsp;<input type="radio" name="search_down" value="0" {#ifchecked($pa[search_down],0)#} /><?=__('search_and_down')?></td>
</tr>
<!--#if($auth[buy_vip_a]){#-->
<tr>
	<td><b><?=__('vip_img_link')?></b>:<br /><span class="txtgray"><?=__('vip_img_link_tips')?></span></td>
	<td><input type="text" name="img_link" value="{$pa[img_link]}" maxlength="8" /></td>
</tr>
<tr>
	<td><b><?=__('vip_music_link')?></b>:<br /><span class="txtgray"><?=__('vip_music_link_tips')?></span></td>
	<td><input type="text" name="music_link" value="{$pa[music_link]}" maxlength="8" /></td>
</tr>
<tr>
	<td><b><?=__('vip_video_link')?></b>:<br /><span class="txtgray"><?=__('vip_video_link_tips')?></span></td>
	<td><input type="text" name="video_link" value="{$pa[video_link]}" maxlength="8" /></td>
</tr>
<tr>
	<td><b><?=__('vip_zero_store_time')?></b>:<br /><span class="txtgray"><?=__('vip_zero_store_time_tips')?></span></td>
	<td><input type="text" name="zero_store_time" value="{$pa[zero_store_time]}" maxlength="8" /></td>
</tr>
<!--#}#-->
<tr>
	<td><b><?=__('vip_hidden')?></b>:<br /><span class="txtgray"><?=__('vip_hidden_tips')?></span></td>
	<td><input type="radio" name="is_hidden" value="1" {#ifchecked($pa[is_hidden],1)#} /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="is_hidden" value="0" {#ifchecked($pa[is_hidden],0)#} /><?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" <!--#if(get_active_users($vip_id) && $action=='edit'){#-->onclick="return confirm('<?=__('vip_has_user_edit')?>');"<!--#}#--> value="<?=__('btn_submit')?>"/>&nbsp;
	<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(o.subject.value.strtrim()==''){
		alert("<?=__('vip_subject_error')?>");
		o.subject.focus();
		return false;
	}
	if(o.content.value.strtrim()==''){
		alert("<?=__('vip_content_error')?>");
		o.content.focus();
		return false;
	}
	if(o.price.value.strtrim()==''){
		alert("<?=__('vip_price_error')?>");
		o.price.focus();
		return false;
	}
}
</script>
<!--#}#-->

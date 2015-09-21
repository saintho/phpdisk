<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_vip.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<!--#include sub/block_adv_middle#-->
<div class="tit"><?=__('buy_vip')?></div>
<div class="layout_box2">
<div class="m" style="padding:10px">
<form name="vip_frm" action="{#urr("vip","")#}" method="post" target="_blank" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="buy_vip" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<!--#if($pd_uid && $settings[open_vip]){#-->
<tr>
	<td colspan="12" class="f14 bold txtblue">{$my_vip}</td>
</tr>
<!--#}#-->
<tr>
	<td>&nbsp;</td>
	<td class="bold" width="15%"><?=__('vip_server')?></td>
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
</tr>
<!--#
if(count($vips)){
	foreach($vips as $k=>$v){
#-->
<tr <!--#if($pd_uid){#-->onclick="hl_vip({$k},{#count($vips)#});"<!--#}#--> id="tr_{$k}">
	<td><!--#if($pd_uid){#--><input type="hidden" id="m_{$k}" value="{$v[price]}" /><input type="radio" name="vip_id" value="{$v[vip_id]}" id="p_sel_{$k}"/><!--#}#-->{$v[img]}</td>
	<td>{$v['subject']}<br /><span class="txtgray">{$v['content']}</span></td>
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
</tr>
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
<!--#if($pd_uid){#-->
<tr id="t_tr" style="display:none">
	<td align="center" colspan="12"><span id="total_txt" style="display:none"><?=__('total_txt')?></span>&nbsp;<span id="total_money" class="f18 bold txtred"></span></td>
</tr>
<tr>
	<td align="center" colspan="12">
		<input type="radio" name="pv" value="mywealth" onclick="put_value('mywealth');" /><span class="f18 txtblue"><?=__('mywealth')?></span>&nbsp;
	<!--#if(display_plugin('payment','open_payment_plugin',$settings['open_payment'],0)){#-->
		<!--#if(display_plugin('payment','open_payment_plugin',$settings['open_alipay'],0)){#-->
		<input type="radio" name="pv" value="alipay" onclick="put_value('alipay');" /><img src="images/alipay_icon.gif" align="absmiddle" border="0" />&nbsp;
		<!--#}#-->
		<!--#if(display_plugin('payment','open_payment_plugin',$settings['open_tenpay'],0)){#-->
		<input type="radio" name="pv" value="tenpay" onclick="put_value('tenpay');" /><img src="images/tenpay_icon.gif" align="absmiddle" border="0" />&nbsp;
		<!--#}#-->
		<!--#if(display_plugin('payment','open_payment_plugin',$settings['open_chinabank'],0)){#-->
		<input type="radio" name="pv" value="chinabank" onclick="put_value('chinabank');" /><img src="images/chinabank_icon.gif" align="absmiddle" border="0" />&nbsp;
		<!--#}#-->
		<!--#if(display_plugin('payment','open_payment_plugin',$settings['open_yeepay'],0)){#-->
		<input type="radio" name="pv" value="yeepay" onclick="put_value('yeepay');" /><img src="images/yeepay_icon.gif" align="absmiddle" border="0" />&nbsp;
		<!--#}#-->
	<!--#}#-->
	</td>
</tr>
<tr>
	<td align="center" colspan="12"><input type="hidden" name="money" id="money" /><input type="hidden" name="task" id="task" /><input type="submit" id="submit" class="btn" value="<?=__('btn_buy_vip')?>"/>&nbsp;<span id="submit_tips" class="txtred f14"></span>
	</td>
</tr>
<!--#}#-->
</table>
</form>
<script type="text/javascript">
function hl_vip(id,count){
	for(var i=0;i<count;i++){
		getId('tr_'+i).className='';
		getId('p_sel_'+i).checked = false;
	}
	getId('tr_'+id).className='color4 txtblue';
	getId('p_sel_'+id).checked = true;
	getId('total_money').innerHTML = getId('m_'+id).value+'<?=__('money_unit')?>';
	getId('money').value = getId('m_'+id).value;
	getId('t_tr').style.display = '';
	getId('total_txt').style.display = '';
}
function put_value(val){
	getId('task').value = val;
}
function dosubmit(o){
	if(o.money.value==''){
		alert('<?=__('vip_type_not_select')?>');
		return false;
	}
	if(o.task.value==''){
		alert('<?=__('vip_payment_not_select')?>');
		return false;
	}
	getId('submit').value ='<?=__('buy_vip_new_page')?>';
	getId('submit').disabled=true;
}
</script>

</div>
</div>
</div>
<br />
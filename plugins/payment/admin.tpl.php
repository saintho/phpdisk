<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: admin.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<!--#if($action =='order'){#-->
<div id="container">
<h1><?=__('payment_title')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('payment_title_tips')?></span>
</div>
<div class="search_box">
<a href="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app")#}" id="n_"><?=__('payment_setting')?></a>&nbsp;&nbsp;
<a href="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app&action=order")#}" id="n_order"><?=__('payment_order')?></a>&nbsp;&nbsp;
</div>
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<!--#
if(count($logs)){
#-->
<tr>
	<td class="bold"><?=__('order_number')?></td>
	<td align="center" class="bold"><?=__('pay_method')?></td>
	<td align="center" class="bold"><?=__('total_fee')?></td>
	<td align="center" class="bold"><?=__('pay_status')?></td>
	<td align="center" class="bold"><?=__('order_user')?></td>
	<td align="center" class="bold"><?=__('in_time')?></td>
	<td align="center" class="bold"><?=__('ip')?></td>
</tr>
<!--#
}
#-->
<!--#
if(count($logs)){
	foreach($logs as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td><a href="{$v['a_edit']}" title="<?=__('fill_order')?>">{$v['order_number']}</a></td>
	<td align="center">{$v['pay_method']}</td>
	<td align="center">{$v['total_fee']}</td>
	<td align="center">{$v['pay_status']}</td>
	<td align="center"><a href="{$v['a_space']}">{$v['username']}</a></td>
	<td align="center"><span class="txtgray">{$v['in_time']}</span></td>
	<td align="center">{$v['ip']}</td>
</tr>
<!--#
	}
	unset($logs);
}else{
#-->
<tr>
	<td colspan="7" align="center"><?=__('none_logs')?></td>
</tr>
<!--#
}
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="7">{$page_nav}</td>
</tr>
<!--#}#-->
</table>
</div>
</div>
<script language="javascript">
getId('n_{$action}').className = 'sel_a';
</script>
<!--#}elseif($action =='edit'){#-->
<div id="container">
<h1><?=__('edit_order')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('edit_order_tips')?></span>
</div>
<div class="search_box">
<a href="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app")#}" id="n_"><?=__('payment_setting')?></a>&nbsp;&nbsp;
<a href="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app&action=order")#}" id="n_order"><?=__('payment_order')?></a>&nbsp;&nbsp;
</div>
<form action="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="order_id" value="{$order_id}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 bold"><?=__('edit_order')?>:</td>
</tr>
<tr>
	<td width="40%" class="bold"><?=__('order_number')?></td>
	<td>{$rs['order_number']}</td>
</tr>
<tr>
	<td class="bold"><?=__('pay_method')?></td>
	<td>{$rs['pay_method']}</td>
</tr>
<tr>
	<td class="bold"><?=__('total_fee')?></td>
	<td>{$rs['total_fee']}</td>
</tr>
<tr>
	<td class="bold"><?=__('order_user')?></td>
	<td><a href="{$rs[a_space]}">{$rs[username]}</a></td>
</tr>
<tr>
	<td class="bold"><?=__('in_time')?></td>
	<td>{$rs['in_time']}</td>
</tr>
<tr>
	<td class="bold"><?=__('ip')?></td>
	<td>{$rs['ip']}</td>
</tr>
<tr>
	<td class="bold"><?=__('pay_status')?></td>
	<td><select name="pay_status">
	<option value="pendding" {#ifselected($rs[pay_status],'pendding','str')#}><?=__('pay_pendding')?></option>
	<option value="success" {#ifselected($rs[pay_status],'success','str')#}><?=__('pay_success')?></option>
	<option value="fail" {#ifselected($rs[pay_status],'fail','str')#}><?=__('pay_fail')?></option>
	</select>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
getId('n_order').className = 'sel_a';
</script>
<!--#}else{#-->
<div id="container">
<h1><?=__('payment_title')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('payment_title_tips')?></span>
</div>
<div class="search_box">
<a href="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app")#}" id="n_"><?=__('payment_setting')?></a>&nbsp;&nbsp;
<a href="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app&action=order")#}" id="n_order"><?=__('payment_order')?></a>&nbsp;&nbsp;
</div>
<form action="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_payment')?></span>: <br /><span class="txtgray"><?=__('open_payment_tips')?></span></td>
	<td><input type="radio" name="setting[open_payment]" value="1" {#ifchecked(1,$settings['open_payment'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_payment]" value="0" {#ifchecked(0,$settings['open_payment'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
<br />
<fieldset><legend><span class="bold"><?=__('alipay_setting')?></span></legend>
<form action="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app")#}" method="post" onsubmit="return alipay_submit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="alipay" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2"><a href="http://www.alipay.com/" target="_blank"><img src="images/alipay_icon.gif" align="absmiddle" border="0" /></a></td>
</tr>
<tr>
	<td width="30%"><span class="bold"><?=__('open_alipay')?></span> :</td>
	<td><input type="radio" id="ot1" name="setting[open_alipay]" value="1" {#ifchecked(1,$setting['open_alipay'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" id="ot0" name="setting[open_alipay]" value="0" {#ifchecked(0,$setting['open_alipay'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('ali_partner')?></span> :</td>
	<td><input type="text" id="ali_partner" name="setting[ali_partner]" value="{$settings['ali_partner']}" maxlength="50" size="50" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('ali_security_code')?></span> :</td>
	<td><input type="text" id="ali_security_code" name="setting[ali_security_code]" value="{$settings['ali_security_code']}" maxlength="50" size="50" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('ali_seller_email')?></span> :</td>
	<td><input type="text" id="ali_seller_email" name="setting[ali_seller_email]" value="{$settings['ali_seller_email']}" maxlength="50" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input name="submit" type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<a href="https://www.alipay.com/himalayas/practicality_customer.htm?customer_external_id=C4335324344127901113&market_type=from_agent_contract&pro_codes=26A533A9D11BD074727C1991119AA03E" target="_blank">(<?=__('alipay_reg')?>)</a></td>
</tr>
</table>
</form>
</fieldset>
<br />
<fieldset><legend><span class="bold"><?=__('tenpay_setting')?></span></legend>
<form action="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app")#}" method="post" onsubmit="return tenpay_submit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="tenpay" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2"><a href="http://www.tenpay.com/" target="_blank"><img src="images/tenpay_icon.gif" align="absmiddle" border="0" /></a></td>
</tr>
<tr>
	<td width="30%"><span class="bold"><?=__('open_tenpay')?></span> :</td>
	<td><input type="radio" id="ot1" name="setting[open_tenpay]" value="1" {#ifchecked(1,$setting['open_tenpay'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" id="ot0" name="setting[open_tenpay]" value="0" {#ifchecked(0,$setting['open_tenpay'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('ten_mch')?></span> :</td>
	<td><input type="text" id="ten_mch" name="setting[ten_mch]" value="{$settings['ten_mch']}" maxlength="50" /> <span class="txtred">(<?=__('tenpay_warning')?>)</span></td>
</tr>
<tr>
	<td><span class="bold"><?=__('ten_key')?></span> :</td>
	<td><input type="text" id="ten_key" name="setting[ten_key]" value="{$settings['ten_key']}" size="50" maxlength="50"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<a href="http://mch.tenpay.com/market/index.shtml" target="_blank">(<?=__('tenpay_reg')?>)</a></td>
</tr>
</table>
</form>
</fieldset>
<br />
<fieldset><legend><span class="bold"><?=__('chinabank_setting')?></span></legend>
<form action="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app")#}" method="post" onsubmit="return chinabank_submit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="chinabank" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2"><a href="http://www.chinabank.com.cn/" target="_blank"><img src="images/chinabank_icon.gif" align="absmiddle" border="0" /></a></td>
</tr>
<tr>
	<td width="30%"><span class="bold"><?=__('open_chinabank')?></span> :</td>
	<td><input type="radio" id="ot1" name="setting[open_chinabank]" value="1" {#ifchecked(1,$setting['open_chinabank'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" id="ot0" name="setting[open_chinabank]" value="0" {#ifchecked(0,$setting['open_chinabank'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('chinabank_mch')?></span> :</td>
	<td><input type="text" id="chinabank_mch" name="setting[chinabank_mch]" value="{$settings['chinabank_mch']}" maxlength="50" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('chinabank_key')?></span> :</td>
	<td><input type="text" id="chinabank_key" name="setting[chinabank_key]" value="{$settings['chinabank_key']}" size="50" maxlength="100"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<a href="http://www.chinabank.com.cn/gateway/foropening.html" target="_blank">(<?=__('chinabank_reg')?>)</a></td>
</tr>
</table>
</form>
</fieldset>
<br />
<fieldset><legend><span class="bold"><?=__('yeepay_setting')?></span></legend>
<form action="{#urr(ADMINCP,"item=plugins&menu=$menu&app=$app")#}" method="post" onsubmit="return yeepay_submit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="yeepay" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2"><a href="http://www.yeepay.com/" target="_blank"><img src="images/yeepay_icon.gif" align="absmiddle" border="0" /></a></td>
</tr>
<tr>
	<td width="30%"><span class="bold"><?=__('open_yeepay')?></span> :</td>
	<td><input type="radio" id="ot1" name="setting[open_yeepay]" value="1" {#ifchecked(1,$setting['open_yeepay'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" id="ot0" name="setting[open_yeepay]" value="0" {#ifchecked(0,$setting['open_yeepay'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('yeepay_mch')?></span> :</td>
	<td><input type="text" id="yeepay_mch" name="setting[yeepay_mch]" value="{$settings['yeepay_mch']}" maxlength="50" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('yeepay_key')?></span> :</td>
	<td><input type="text" id="yeepay_key" name="setting[yeepay_key]" value="{$settings['yeepay_key']}" size="50" maxlength="100"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<a href="http://www.yeepay.com/enterpriseregister.shtml" target="_blank">(<?=__('yeepay_reg')?>)</a></td>
</tr>
</table>
</form>
</fieldset>
<script language="javascript">
getId('n_{$action}').className = 'sel_a';
function alipay_submit(){
	if(getId('ali_partner').value.strtrim().length <8){
		alert("<?=__('ali_partner_error')?>");
		getId('ali_partner').focus();
		return false;
	}
	if(getId('ali_security_code').value.strtrim().length <8){
		alert("<?=__('ali_security_code_error')?>");
		getId('ali_security_code').focus();
		return false;
	}
	if(getId('ali_seller_email').value.strtrim().length <6){
		alert("<?=__('ali_seller_email_error')?>");
		getId('ali_seller_email').focus();
		return false;
	}
}
function tenpay_submit(){
	if(getId('ten_mch').value.strtrim().length <3){
		alert("<?=__('ten_mch_error')?>");
		getId('ten_mch').focus();
		return false;
	}
	if(getId('ten_key').value.strtrim().length <2){
		alert("<?=__('ten_key_error')?>");
		getId('ten_key').focus();
		return false;
	}
}
function chinabank_submit(){
	if(getId('chinabank_mch').value.strtrim().length <3){
		alert("<?=__('chinabank_mch_error')?>");
		getId('chinabank_mch').focus();
		return false;
	}
	if(getId('chinabank_key').value.strtrim().length <2){
		alert("<?=__('chinabank_key_error')?>");
		getId('chinabank_key').focus();
		return false;
	}
}
function yeepay_submit(){
	if(getId('yeepay_mch').value.strtrim().length <3){
		alert("<?=__('yeepay_mch_error')?>");
		getId('yeepay_mch').focus();
		return false;
	}
	if(getId('yeepay_key').value.strtrim().length <2){
		alert("<?=__('yeepay_key_error')?>");
		getId('yeepay_key').focus();
		return false;
	}
}
</script>
</div>
</div>
<!--#}#-->
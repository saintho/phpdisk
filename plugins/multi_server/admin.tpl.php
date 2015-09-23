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
<!--#
if($action =='add_server' || $action =='edit_server'){
#-->
<div id="container">
<!--#if($action =='add_server'){#-->
<h1><?=__('add_server_title')?></h1>
<!--#}else{#-->
<h1><?=__('edit_server_title')?></h1>
<!--#}#-->
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('server_list_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=plugins&menu=plugin&app=$app")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="server_id" value="{$server_id}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><span class="bold"><?=__('server_name')?>:</span><br /><span class="txtgray"><?=__('server_name_tips')?></span></td>
	<td><input type="text" name="server_name" value="{$server_name}" maxlength="50" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('server_oid')?>:</span><br /><span class="txtgray"><?=__('server_oid_tips')?></span></td>
	<td><input type="text" name="server_oid" value="{$server_oid}" size="4" maxlength="4" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('server_host')?>:</span><br /><span class="txtgray"><?=__('server_host_tips')?></span></td>
	<td><input type="text" name="server_host" value="{$server_host}" size="40" maxlength="100" /></td>
</tr>
<tr>
	<td valign="top"><span class="bold"><?=__('server_dl_host')?>:</span><br /><span class="txtgray"><?=__('server_dl_host_tips')?></span></td>
	<td><textarea name="server_dl_host" id="server_dl_host" style="width:400px;height:90px">{$server_dl_host}</textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('server_dl_host','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('server_dl_host','sub');">[-]</a></td>
</tr>
<tr>
	<td><span class="bold"><?=__('server_store_path')?>:</span><br /><span class="txtgray"><?=__('server_store_path_tips')?></span></td>
	<td><input type="text" name="server_store_path" value="{$server_store_path}" maxlength="30" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('server_key')?>:</span><br /><span class="txtgray"><?=__('server_key_tips')?></span></td>
	<td><input type="text" name="server_key" id="server_key" value="{$server_key}" maxlength="30" />&nbsp;<input type="button" value="<?=__('make_random')?>" class="btn" onclick="make_code();" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('server_status')?>:</span><br /><span class="txtgray"><?=__('server_status_tips')?></span></td>
	<td><input type="radio" name="server_closed" value="1" {#ifchecked(1,$server_closed)#} /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="server_closed" value="0" {#ifchecked(0,$server_closed)#} /><?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" id="s1" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(o.server_name.value.strtrim().length <2){
		alert("<?=__('server_name_error')?>");
		o.server_name.focus();
		return false;
	}
	if(o.server_host.value.strtrim().length <6){
		alert("<?=__('server_host_error')?>");
		o.server_host.focus();
		return false;
	}
	if(o.server_store_path.value.strtrim() == ''){
		alert("<?=__('server_store_path_error')?>");
		o.server_store_path.focus();
		return false;
	}
	if(o.server_key.value.strtrim() == ''){
		alert("<?=__('server_key_error')?>");
		o.server_key.focus();
	}
	getId('s1').disabled = true;
	getId('s1').value = "<?=__('txt_processing')?>";
}
function make_code(){
   var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   var tmp = "";
   var code = "";
   for(var i=0;i<12;i++){
	   code += chars.charAt(Math.ceil(Math.random()*100000000)%chars.length);
   }
   getId('server_key').value = code;
}
</script>
<!--#
}else{
#-->
<div id="container">
<h1><?=__('server_title')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('server_list_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=plugins&menu=plugin&app=$app")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td width="40%"><span class="bold"><?=__('open_multi_server')?></span>: <br /><span class="txtgray"><?=__('open_multi_server_tips')?></span></td>
	<td><input type="radio" name="setting[open_multi_server]" value="1" {#ifchecked(1,$settings['open_multi_server'])#}/><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_multi_server]" value="0" {#ifchecked(0,$settings['open_multi_server'])#}/><?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
<br />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="10" class="f14 bold"><?=__('server_list')?>:</td>
</tr>
<!--#
if(count($server_arr)){
#-->
<tr>
	<td class="bold" width="200"><?=__('s_name')?></td>
	<td class="bold"><?=__('s_host')?>|下载地址</td>
	<td class="bold" width="100"><?=__('s_path')?></td>
	<td class="bold" width="100"><?=__('s_size')?></td>
	<td class="bold" width="50"><?=__('s_status')?></td>
	<td align="right" class="bold" width="50"><?=__('operation')?></td>
</tr>
<!--#
	foreach($server_arr as $k => $v){
		$color = ($k%2==0) ? 'color1' : 'color4';
#-->
<tr class="{$color}">
	<td>{$v['server_name']}(标识ID：{$v[server_oid]})</td>
	<td><b>上传：</b><Br />{$v['server_host']}&nbsp;{$v['is_default']}<Br /><b>下载:</b><br />{$v['server_dl_host']}</td>
	<td>{$v['server_store_path']}</td>
	<td>{$v['server_size']}</td>
	<td><a href="###" id="p2_{$k}">{$v['server_status']}</a>
	<!--#if($v['server_oid'] >1){#-->
	<div id="c2_{$k}" class="menu_box3 menu_common">
	<li><?=__('client_status')?>:{$v['client_status']}(<a href="###" onclick="open_box('{$v['a_test_server']}',400,200);"><?=__('test')?></a>)</li>
	<li><?=__('client_env_update')?>:<a href="###" onclick="open_box('{$v[a_update_env]}',400,200);"><?=__('update_env')?></a></li>
	</div>
	<script type="text/javascript">on_menu('p2_{$k}','c2_{$k}','-x','');</script>
	<!--#}#-->
	</td>
	<td align="right">
	<!--#if($v['server_id'] ==1){#-->
	--
	<!--#}else{#-->
	<a href="{$v['a_edit_server']}" id="p_{$k}"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>
	<div id="c_{$k}" class="menu_box2 menu_common">
	<a href="{$v['a_default_server']}"><?=__('set_default')?></a>
	<a href="{$v['a_edit_server']}"><?=__('modify')?></a>
	<a href="{$v['a_del_server']}" onclick="return confirm('<?=__('server_del_confirm')?>');"><?=__('delete')?></a>
	</div>
	<script type="text/javascript">on_menu('p_{$k}','c_{$k}','-x','');</script>
	<!--#}#-->
	</td>
</tr>
<!--#
	}
	unset($server_arr);
}else{	
#-->
<tr>
	<td colspan="10" align="center"><?=__('server_not_found')?></td>
</tr>
<!--#
}
#-->
<tr>
	<td colspan="10"><input type="button" class="btn" value="<?=__('add_server')?>" onclick="go('{#urr(ADMINCP,"item=plugins&menu=plugin&app=$app&action=add_server")#}');" /></td>
</tr>
</table>
</form>
</div>
</div>
<!--#
}
#-->

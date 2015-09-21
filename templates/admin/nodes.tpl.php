<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: nodes.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action=='list'){#-->
<div id="container">
<h1><?=__('node_manage')?><!--#sitemap_tag(__('node_manage'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('node_manage_tips')?></span>
</div>
<form name="nodes_form" action="{#urr(ADMINCP,"item=nodes&menu=file")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<!--#
if(count($nodes)){
#-->
<tr>
	<td width="30" align="center" class="bold"><?=__('show_order')?></td>
	<td class="bold" width="20%"><?=__('nodes_subject')?></td>
	<td class="bold" width="10%" align="center"><?=__('nodes_icon')?></td>
	<td class="bold" width="40%"><?=__('nodes_server_oid')?>|<?=__('nodes_host')?></td>
	<td class="bold" width="50" align="center"><?=__('status')?></td>
	<td class="bold" align="right"><?=__('operation')?></td>
</tr>
<!--#
	for($i = 0; $i < count($nodes); $i++) {
		if($nodes[$i]['parent_id'] == 0) {
#-->
<tr>
	<td>
	<input type="text" name="show_order[]" value="{#$nodes[$i]['show_order']#}" style="width:20px; text-align:center" maxlength="2" />
	<input type="hidden" name="node_ids[]" value="{#$nodes[$i]['node_id']#}" />
	</td>
	<td><a href="{#$nodes[$i]['a_edit_node']#}">{#$nodes[$i]['subject']#}</a></td>
	<td align="center">{#$nodes[$i]['icon']#}</td>
	<td>{#$nodes[$i]['server_oid']#}| {#$nodes[$i]['host']#}</td>
	<td align="center"><a href="{#$nodes[$i]['a_change_status']#}">{#$nodes[$i]['status_text']#}</a></td>
	<td align="right"><a href="{#$nodes[$i]['a_edit_node']#}" id="p_{#$nodes[$i][node_id]#}"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>&nbsp;
	<div id="c_{#$nodes[$i][node_id]#}" class="menu_box2 menu_common">
	<a href="{#$nodes[$i]['a_edit_node']#}"><?=__('modify')?></a>
	<a href="{#$nodes[$i]['a_del_node']#}" onclick="return confirm('<?=__('node_delete_confirm')?>');"><?=__('delete')?></a>
	</div>
	</td>
</tr>
<script type="text/javascript">on_menu('p_{#$nodes[$i][node_id]#}','c_{#$nodes[$i][node_id]#}','-x','');</script>
<!--#
		for($j = 0; $j < count($nodes); $j++) {
			if($nodes[$j]['parent_id'] == $nodes[$i]['node_id']) {
#-->
	<tr>
		<td>
		<input type="text" name="show_order[]" value="{#$nodes[$j]['show_order']#}" style="width:20px; text-align:center" maxlength="2" />
		<input type="hidden" name="node_ids[]" value="{#$nodes[$j]['node_id']#}" />
		</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{#$nodes[$j]['a_edit_node']#}">{#$nodes[$j]['subject']#}</a></td>
		<td align="center">{#$nodes[$j]['icon']#}</td>
		<td>{#$nodes[$j]['server_oid']#}| {#$nodes[$j]['host']#}</td>
		<td align="center"><a href="{#$nodes[$j]['a_change_status']#}">{#$nodes[$j]['status_text']#}</a></td>
		<td align="right"><a href="{#$nodes[$j]['a_edit_node']#}" id="p_{#$nodes[$j][node_id]#}"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>&nbsp;
		<div id="c_{#$nodes[$j][node_id]#}" class="menu_box2 menu_common">
		<a href="{#$nodes[$j]['a_edit_node']#}"><?=__('modify')?></a>
		<a href="{#$nodes[$j]['a_del_node']#}" onclick="return confirm('<?=__('node_delete_confirm')?>');"><?=__('delete')?></a>
		</div>
		</td>
	</tr>
	<script type="text/javascript">on_menu('p_{#$nodes[$j][node_id]#}','c_{#$nodes[$j][node_id]#}','-x','');</script>
<!--#	
				}		
			}
		}
	}
	unset($nodes);
}else{	
#-->
<tr>
	<td><?=__('nodes_not_found')?></td>
</tr>
<!--#
}
#-->
<tr>
	<td align="center" colspan="6"><input type="button" class="btn" value="<?=__('add_nodes')?>" onclick="go('{#urr(ADMINCP,"item=nodes&menu=file&action=add")#}');" /> <input type="submit" class="btn" value="<?=__('btn_update')?>" /></td>
</tr>
</table>
</form>
</div>
</div>
<!--#}elseif($action=='add' || $action=='edit'){#-->
<div id="container">
<!--#if($action =='add'){#-->
<h1><?=__('add_nodes')?></h1>
<!--#}else{#-->
<h1><?=__('edit_nodes')?></h1>
<!--#}#-->
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('add_edit_nodes_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=nodes&menu=file")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="node_id" value="{$node_id}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><b><?=__('nodes_subject')?></b>:<br /><span class="txtgray"><?=__('nodes_subject_tips')?></span></td>
	<td><input type="text" name="subject" value="{$pa[subject]}" size="50" maxlength="100" /></td>
</tr>
<tr>
	<td><b><?=__('nodes_parent_id')?></b>:<br /><span class="txtgray"><?=__('nodes_parent_id_tips')?></span></td>
	<td><select name="parent_id">
	<option value="0"><?=__('root_node')?></option>
	<!--#if(count($nd)){
		foreach($nd as $v){
	#-->
	<option value="{$v[node_id]}" {#ifselected($v[node_id],$pa[parent_id])#}>{$v[subject]}</option>
	<!--#
		}
		unset($nd);
	}
	#-->
	</select></td>
</tr>
<tr>
	<td><b><?=__('nodes_server_oid')?></b>:<br /><span class="txtgray"><?=__('nodes_dl_id_tips')?></span></td>
	<td><input type="text" name="server_oid" id="server_oid" value="{$pa[server_oid]}" size="5" maxlength="10" />&nbsp;<input type="button" class="btn" onclick="search_host();" value="<?=__('search_host')?>" /><br /><br /><span id="sloading"></span></td>
</tr>
<tr>
	<td><b><?=__('nodes_host')?></b>:<br /><span class="txtgray"><?=__('nodes_host_tips')?></span></td>
	<td><input type="text" name="host" value="{$pa[host]}" size="50" id="node_host" maxlength="100" readonly onclick="alert('<?=__('pls_click_nodes_dl_id')?>');" />&nbsp;<span class="txtred"><?=__('nodes_host_tips2')?></span></td>
</tr>
<tr>
	<td><b><?=__('nodes_icon')?></b>:<br /><span class="txtgray"><?=__('nodes_icon_tips')?></span></td>
	<td><input type="text" name="icon" value="{$pa[icon]}" size="50" maxlength="100" /></td>
</tr>
<tr>
	<td><b><?=__('nodes_down_type')?></b>:<br /><span class="txtgray"><?=__('nodes_down_type_tips')?></span></td>
	<td><input type="radio" name="down_type" value="0" {#ifchecked($pa[down_type],0)#} /><?=__('no')?>
	<input type="radio" name="down_type" value="1" {#ifchecked($pa[down_type],1)#} /><?=__('thunder_link')?>
	<input type="radio" name="down_type" value="2" {#ifchecked($pa[down_type],2)#} /><?=__('flashget_link')?>
	</td>
</tr>
<tr>
	<td><b><?=__('nodes_hidden')?></b>:<br /><span class="txtgray"><?=__('nodes_hidden_tips')?></span></td>
	<td><input type="radio" name="is_hidden" value="1" {#ifchecked($pa[is_hidden],1)#} /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="is_hidden" value="0" {#ifchecked($pa[is_hidden],0)#} /><?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>	
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;
	<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
function search_host(){
	var val = getId('server_oid').value.strtrim();
	$('#sloading').html('<img src="images/ajax_loading.gif" align="absmiddle" border="0" />loading...');
	$('#sloading').show();
	$.ajax({
		type : 'post',
		url : 'adm_ajax.php',
		data : 'action=search_host&server_oid='+val+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			var arr = msg.split('|');
			if(arr[0] == 'true'){
				$('#sloading').html(arr[1]);
			}else{
				$('#sloading').hide();
				alert(msg);
			}
		},
		error:function(){
		}

	});
}
function sel_host(){
	getId('node_host').value = decodeURIComponent(getId('sh_id').value);
}

function dosubmit(o){
	if(o.subject.value.strtrim().length <2){
		alert("<?=__('nodes_subject_error')?>");
		o.subject.focus();
		return false;
	}
	if(o.parent_id.value>0 && o.host.value.strtrim()==''){
		alert("<?=__('nodes_host_error')?>");
		o.host.focus();
		return false;
	}
}
</script>
<!--#}#-->

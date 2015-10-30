<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: database.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action =='backup' || $action =='optimize'){#-->
<div id="container">
<!--#if($action =='backup'){#-->
<h1><?=__('backup_database')?><!--#sitemap_tag(__('backup_database'));#--></h1>
<div>
<div class="tips_box"><b><?=__('tips')?>: </b><br />
<ul>
	<li><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('backup_database_tips')?></span></li>
	<li><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('backup_database_tips2')?></span></li>
</ul>
</div>
<!--#}else{#-->
<h1><?=__('optimize_database')?><!--#sitemap_tag(__('optimize_database'));#--></h1>
<div>
<div class="tips_box"><b><?=__('tips')?>: </b><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('optimize_database_tips')?></span>
</div>
<!--#}#-->
<form method="post" name="myform" action="{#urr(ADMINCP,"item=database&menu=tool")#}" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="backup" />
<input type="hidden" name="task" value="backup" />
<table align="center" width="100%" cellpadding="0" cellspacing="0" id="db_table" class="td_line">
<tr>
	<td class="bold" width="40%">&nbsp;&nbsp;&nbsp;&nbsp;<?=__('name')?></td>
	<td class="bold" width="100"><?=__('engine')?></td>
	<td class="bold" width="100" align="center"><?=__('rows')?></td>
	<td class="bold" width="100" align="center"><?=__('index_length')?></td>
	<td class="bold" width="100" align="center"><?=__('data_free')?></td>
	<td class="bold" width="100" align="right"><?=__('data_length')?></td>
</tr>
<!--#
if(count($table_arr)){
	foreach($table_arr as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
		$index_size += $v['Index_length'];
		$data_size += $v['Data_length'];
		$table_size += $v['Data_length']+$v['Index_length'];
		$v['Data_free'] = $v['Data_free'] ? "<span class='txtred bold'>".$v['Data_free']."</span>" : $v['Data_free'];
#-->
<tr class="{$color}">
    <td><input type="checkbox" name="tables[]" value="{$v['Name']}" checked />{$v['Name']}</td>
    <td>{$v['Engine']}</td>
    <td align="center">{$v['Rows']}</td>
    <td align="center">{#get_size($v['Index_length'])#}</td>
    <td align="center">{$v['Data_free']}</td>
    <td align="right">{#get_size($v['Data_length'])#}</td>
</tr>
<!--#
	}
}
unset($table_arr);
#-->
<tr>
	<td colspan="6" height="50"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check' checked><label for="chkall"><?=__('sel_all')?></label>&nbsp;&nbsp;
	<span class="txtred">(<?=__('index_size')?>:{#get_size($index_size)#} <?=__('data_size')?>:{#get_size($data_size)#},<?=__('all')?>:{#get_size($table_size)#})</span>&nbsp;&nbsp;
	<!--#if($action =='backup'){#-->
	<?=__('one_sql_file')?><input type="text" name="sizelimit" value="2048" size="5"/> K <input type="submit" class="btn" value="<?=__('btn_run_backup')?>" />&nbsp;&nbsp;
	<!--#}else{#-->
	<input type="button" class="btn" value="<?=__('run_optimize')?>" onClick="go('{#urr(ADMINCP,"item=database&menu=tool&action=$action&task=optimize")#}');"/>
	<!--#}#-->
	</td>
</tr>
</table>
</form>
<script type="text/javascript">
function dosubmit(o){
	if(checkbox_ids("tables[]") != true){
		alert("<?=__('please_select_operation_tables')?>");
		return false;
	}

}
function checkall(form) {
	for(var i = 0;i < form.elements.length; i++) {
		var e = form.elements[i];
		if (e.name != 'chkall' && e.disabled != true) {
			e.checked = form.chkall.checked;
		}
	}
}
</script>
</div>
</div>
<!--#}elseif($action =='restore'){#-->
<div id="container">
<h1><?=__('restore_database')?><!--#sitemap_tag(__('restore_database'));#--></h1>
<div>
<div class="tips_box"><b><?=__('tips')?>: </b>
<ul>
	<li><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('restore_database_tips')?></span></li>
	<li><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('restore_database_tips2')?></span></li>
	<li><img class="img_light" src="images/light.gif" align="absmiddle"> <span class="txtgray"><?=__('restore_database_tips3')?></span></li>
</ul>
</div>
<table align="center" width="100%" cellpadding="0" cellspacing="0" class="td_line">
<!--#
if(count($infos)){
#-->
<tr align="center" class="bold">
	<td width="8%"><?=__('sql_order')?></td>
	<td width="30%" ><?=__('sql_name')?></td>
	<td width="10%"><?=__('sql_size')?></td>
	<td width="20%"><?=__('backup_time')?></td>
	<td width="8%"><?=__('part_number')?></td>
	<td width="20%"><?=__('operation')?></td>
</tr>
<!--#
	foreach($infos as $k => $v){
		$k++;
#-->
  <tr bgcolor="{$v['bgcolor']}"  align="center" onmouseover="this.className='color4'" onmouseout="this.className=''">
    <td>{$k}</td>
    <td>{$v['filename']}</td>
    <td>{$v['filesize']} M</td>
	<td>{$v['maketime']}</td>
    <td>{$v['number']}</td>
    <td>
	<a href="{$v['a_delete']}" onclick="return confirm('<?=__('sql_delete_confirm')?>');"><?=__('sql_file_delete')?></a>&nbsp;&nbsp;
	<a href="{$v['a_restore']}" onclick="return confirm('<?=__('sql_restore_confirm')?>');"><?=__('sql_restore')?></a>
	</td>
</tr>
<!--#
	}
	unset($infos);
}else{
#-->
<tr>
	<td class="f12" colspan="6"><?=__('no_backup_database')?></td>
</tr>
<!--#
}
#-->
</table>
</div>
</div>
<!--#}#-->
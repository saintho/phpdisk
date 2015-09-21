<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: sitemap.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--# if($action =='setting'){#-->
<div id="container">
<h1><?=__('sitemap_setting')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('sitemap_setting_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=$item")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="setting" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<!--#
if(count($cs_menus)){
	foreach($cs_menus as $v){
#-->
<tr>
	<td><input type="checkbox" name="ids[]" value="{$v['id']}" />&nbsp;<a href="{#urr(ADMINCP,"$v[url]")#}">{$v['title']}</a></td>
</tr>
<!--#
	}
	unset($cs_menus);
#-->
<tr>
	<td><input type="submit" class="btn" onclick="return confirm('<?=__('del_menu_confirm')?>');" value="<?=__('btn_del_submit')?>" /></td>
</tr>
<!--#
}else{
#-->
<tr>
	<td align="center"><?=__('none_cp_shortcut')?></td>
</tr>
<!--#
}
#-->
</table>
</form>
</div>
</div>
<!--#}else{#-->
<div id="container">
<h1><?=__('sitemap_manage')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('sitemap_manage_tips')?></span>
</div>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td class="f14"><a href="./" target="_blank"><?=__('menu_site_index')?></a>&nbsp;
	<a href="{#urr(ADMINCP,"item=main")#}"><?=__('menu_admin_index')?></a>&nbsp;
	</td>
</tr>
<!--#
foreach($cp_menus as $v){
	if($v['title']){
#-->
<tr>
	<td class="bold f14">{$v['title']}:</td>
</tr>
<!--#
	}
#-->
<tr>	
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<span class="f14">{$v['sub_title']}</span>&nbsp;
	<!--#foreach($v['data'] as $v2){#-->
	<a href="{$v2['url']}">{$v2['menu']}</a>&nbsp;
	<!--#}#-->
	</td>
</tr>
<!--#
}
unset($cp_menus);
#-->
<tr>
	<td class="f14"><a href="{#urr(ADMINCP,"item=users&action=adminlogout")#}" onClick="return confirm('<?=__('system_logout_confirm')?>');" class="txtred"><?=__('menu_logout')?></a></td>
</tr>
</table>
</div>
</div>
<!--#}#-->

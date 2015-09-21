<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: lang.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('lang_list_title')?><!--#sitemap_tag(__('lang_list_title'));#--></h1>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle"> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('lang_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=lang&menu=lang_tpl")#}" method="post">
<input type="hidden" name="action" value=""/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_switch_langs')?></span>: <br /><span class="txtgray"><?=__('open_switch_langs_tips')?></span></td>
	<td><input type="radio" name="setting[open_switch_langs]" value="1" {#ifchecked(1,$settings['open_switch_langs'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_switch_langs]" value="0" {#ifchecked(0,$settings['open_switch_langs'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></td>
</tr>
</table>
</form>
<br />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td class="bold" width="180"><?=__('lang_title')?></td>
	<td class="bold" width="120"><?=__('lang_name')?></td>
	<td class="bold" width="50%"><?=__('lang_des')?></td>
	<td class="bold" align="right"><?=__('operation')?></td>
</tr>
<!--#
if(count($languages_arr)){
	foreach($languages_arr as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td class="f14">{$v['lang_title']}</td>
	<td>{$v['lang_dir']}</td>
	<td>
	<table>
		<tr>
			<td>{$v['lang_desc']}</td>
		</tr>
		<tr>
			<td>	
				<span class="txtgray"><?=__('lang_author')?>:</span><a href="{$v['lang_site']}" target="_blank">{$v['lang_author']}</a>&nbsp;
				<span class="txtgray"><?=__('lang_version')?>:{$v['lang_version']}</span>&nbsp;
				<span class="txtgray"><?=__('phpdisk_core')?>:{$v['phpdisk_core']}</span>
			</td>
		</tr>
	</table>
	</td>
	<td align="right">
	<!--# if($v['actived']){#-->
	<span class="txtgray"><?=__('is_using')?></span>
	<!--# }else{#-->
	<a href="{#urr(ADMINCP,"item=lang&menu=lang_tpl&lang_name=".$v['lang_dir']."&action=active")#}" class="txtblue"><?=__('set_active_tpl')?></a>
	<!--#}#-->
	</td>
</tr>
<!--#
	}
	unset($languages_arr);
}else{
#-->
<tr>
	<td colspan="5"><?=__('lang_not_found')?></td>
</tr>
<!--#
}
#-->
</table>
</div>

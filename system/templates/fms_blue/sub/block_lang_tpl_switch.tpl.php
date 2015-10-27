<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-27 17:28:22

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_lang_tpl_switch.tpl.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if($settings[open_switch_tpls]){ ?>
<label for="s_tpl"><?=__('tpl_switch')?></label>:<select onchange="chg_tpl();" id="s_tpl">
<?php  
if(count($tpl_sw)){
	foreach($tpl_sw as $v){	
 ?>
<option value="<?=$v['tpl_href']?>" <?=ifselected($v['tpl_name'],$C['tpl_name'],'str')?>><?=$v['tpl_title']?></option>

<?php 
	}
	unset($tpl_sw);
}	
 ?>
</select>
<script type="text/javascript">
function chg_tpl(){
	document.location.href = getId('s_tpl').options[getId('s_tpl').selectedIndex].value;
}
</script>
<?php } ?>
<?php if($settings['open_switch_langs']){ ?>
<label for="s_lang"><?=__('lang_switch')?></label>:<select onchange="chg_lang();" id="s_lang">
<?php  
if(count($langs_sw)){
	foreach($langs_sw as $v){	
 ?>
<option value="<?=$v['lang_href']?>" <?=ifselected($v['lang_name'],$C['lang_type'],'str')?>><?=$v[lang_txt]?></option>

<?php 
	}
	unset($langs_sw);
}	
 ?>
</select>
<script type="text/javascript">
function chg_lang(){
	document.location.href = getId('s_lang').options[getId('s_lang').selectedIndex].value;
}
</script>
<?php } ?>

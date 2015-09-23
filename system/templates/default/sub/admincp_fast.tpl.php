<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2014-04-29 00:30:05

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: admincp_fast.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if($pd_gid==1){ ?>
<?php if($curr_script=='index'){ ?>
<div class="adm_cp_btn" id="r_btn" onclick="cp_btn_click('r_btn','adm_cp');"><img src="images/admin_icon.gif" align="absmiddle" border="0" /><?=__('cp_manage')?></div>
<div class="adm_cp" id="adm_cp" style="display:none">
<fieldset><legend><?=__('diy_index_tips')?></legend>
<form id="frm_index">
<input type="hidden" name="action" value="cp_index" />
<?php if($auth[close_guest_upload] && !$settings['close_guest_upload']){ ?>
<input type="checkbox" name="setting[open_index_fast_upload_box]" value="1" <?=ifchecked($settings[open_index_fast_upload_box],1)?> /><?=__('fast_upload_box')?>&nbsp;
<?php } ?>
<input type="checkbox" name="setting[open_index_site_desc]" value="1" <?=ifchecked($settings[open_index_site_desc],1)?> /><?=__('site_desc')?>&nbsp;
<input type="checkbox" name="setting[open_index_file_list]" value="1" <?=ifchecked($settings[open_index_file_list],1)?> /><?=__('file_list')?>&nbsp;
<input type="button" onclick="cp_index()" id="submit" title="<?=__('submit')?>" value="Go" />
<input type="button" onclick="cp_btn_click('adm_cp','r_btn');" title="<?=__('close')?>" value=" X " />
<span id="callback_msg" class="txtred"></span>
</form>
</fieldset>
</div>
<div class="clear"></div>
<script type="text/javascript">
function cp_index(){
	getId('submit').value='Loading...';
	getId('submit').disabled=true;
	$.post("ajax.php", $("#frm_index").serialize(),
	function(msg){
		getId('callback_msg').innerHTML = msg;
		setTimeout(function(){document.location.reload();},1250);		
	});
}
</script>
<?php }elseif($curr_script=='viewfile'){ ?>
<div class="adm_cp_btn" id="r_btn" onclick="cp_btn_click('r_btn','adm_cp');"><img src="images/admin_icon.gif" align="absmiddle" border="0" /><?=__('cp_manage')?></div>
<div class="adm_cp" id="adm_cp" style="display:none">
<fieldset><legend><?=__('diy_viewfile_tips')?></legend>
<form id="frm_viewfile">
<input type="hidden" name="action" value="cp_viewfile" />
<input type="checkbox" name="setting[open_viewfile_file_list]" value="1" <?=ifchecked($settings[open_viewfile_file_list],1)?> /><?=__('file_list')?>&nbsp;
<input type="button" onclick="cp_viewfile()" id="submit" title="<?=__('submit')?>" value="Go" />
<input type="button" onclick="cp_btn_click('adm_cp','r_btn');" title="<?=__('close')?>" value=" X " />
<span id="callback_msg" class="txtred"></span>
</form>
</fieldset>
</div>
<div class="clear"></div>
<script type="text/javascript">
function cp_viewfile(){
	getId('submit').value='Loading...';
	getId('submit').disabled=true;
	$.post("ajax.php", $("#frm_viewfile").serialize(),
	function(msg){
		getId('callback_msg').innerHTML = msg;
		setTimeout(function(){document.location.reload();},1250);		
	});
}
</script>
<?php } ?>
<script type="text/javascript">
function cp_btn_click(id1,id2){
	getId(id1).style.display='none';
	getId(id2).style.display='';	
}
</script>
<?php } ?>

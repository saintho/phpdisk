<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-28 14:48:26

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_comment.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<?php if(!$action){ ?>
<div class="tit"><?=$title?></div>
<?php } ?>
<div class="layout_box2">
<div class="m" style="padding:10px">
<?php if(!$action){ ?>
<div class="cmt_u_box">
<?php 
if(count($cmts)){
	foreach($cmts as $v){
 ?>
<div class="cmt_cts">
	<div class="cmt_name"><a href="<?=$v['a_space']?>" target="_blank"><img src="images/ico_home.gif" align="absmiddle" border="0" /><?=$v['username']?></a> <span class="f11 txtgray">@ <?=$v['in_time']?></span></div>
	<div class="cmt_content"><?=$v['content']?></div>
</div>
<?php 
	}
	unset($cmts);
}else{
 ?>
<div class="cmt_cts"><?=__('cmt_not_found')?></div>
<?php 
} ?>
</div>
<?php if($page_nav){ ?>
<div><?=$page_nav?></div>
<?php } ?>
<div align="right"><a href="<?=$a_viewfile?>"><?=__('go_back')?></a></div>
<?php if($settings['open_comment']){ ?>
<br />
<div class="f14"><img src="images/ico_cmt.gif" align="absmiddle" border="0" /><?=__('add_cmt')?>:</div>
<div id="cmt_box">
<?php if($pd_uid){ ?>
<form action="<?=urr("comment","")?>" method="post" onsubmit="return docmt(this);">
<input type="hidden" name="action" value="cmt" />
<input type="hidden" name="file_id" value="<?=$file_id?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<li class="txtgray"><?=__('cmt_content')?>:</li>
<li><textarea name="content" style="width:450px; height:150px;"></textarea></li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></li>
</form>
<?php }else{ ?>
<li class="txtred f14"><?=__('login_and_use_it')?></li>
<?php } ?>
</div>
<script type="text/javascript">
function docmt(o){
	if(o.content.value.strtrim().length <2 || o.content.value.strtrim().length >200){
		alert("<?=__('cmt_content_error')?>");
		o.content.focus();
		return false;
	}
}
</script>
<!--end action-->
<?php } ?>
<?php } ?>
</div>
</div>
</div>

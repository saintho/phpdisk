<!--#
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
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<!--#if(!$action){#-->
<div class="tit">{$title}</div>
<!--#}#-->
<div class="layout_box">
<div class="l">
<!--#if(!$action){#-->
<div class="cmt_u_box">
<!--#
if(count($cmts)){
	foreach($cmts as $v){
#-->
<div class="cmt_cts">
	<div class="cmt_name"><a href="{$v['a_space']}" target="_blank"><img src="images/ico_home.gif" align="absmiddle" border="0" />{$v['username']}</a> <span class="f11 txtgray">@ {$v['in_time']}</span></div>
	<div class="cmt_content">{$v['content']}</div>
</div>
<!--#
	}
	unset($cmts);
}else{
#-->
<div class="cmt_cts"><?=__('cmt_not_found']}</div>
<!--#
}#-->
</div>
<!--#if($page_nav){#-->
<div>{$page_nav}</div>
<!--#}#-->
<div align="right"><a href="{$a_viewfile}"><?=__('go_back')?></a></div>
<!--#if($pd_uid){#-->
<br />
<div class="f14"><img src="images/ico_cmt.gif" align="absmiddle" border="0" /><?=__('add_cmt')?>:</div>
<div id="cmt_box">
<form action="{#urr("comment","")#}" method="post" onsubmit="return docmt(this);">
<input type="hidden" name="action" value="cmt" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="file_key" value="{$file_key}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li class="txtgray"><?=__('cmt_content')?>:</li>
<li><textarea name="content" rows="8" cols="60"></textarea></li>
<li><input type="submit" value="<?=__('btn_submit')?>"/></li>
</form>
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
<!--#}#-->
<!--end action-->
<!--#}#-->
</div>
<div class="r">
<!--#
if(count($adv_right)){
	foreach($adv_right as $v){
		echo $v['adv_str'];
	}
	unset($adv_right);
}
#-->
<br />
</div>
<div class="clear"></div>
</div>
</div>

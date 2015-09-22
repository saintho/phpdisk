<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-09-21 18:19:49

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: domain.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('domain_title')?><?php sitemap_tag(__('domain_title')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('domain_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=$item&menu=user")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_domain')?></span>: <br /><span class="txtgray"><?=__('open_domain_tips')?></span></td>
	<td><input type="radio" name="setting[open_domain]" value="1" <?=ifchecked(1,$setting['open_domain'])?>/><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_domain]" value="0" <?=ifchecked(0,$setting['open_domain'])?>/><?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('save_domain')?></span>: <br /><span class="txtgray"><?=__('save_domain_tips')?></span></td>
	<td><textarea name="setting[save_domain]" id="save_domain" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('save_domain','expand');"><?=$setting[save_domain]?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('save_domain','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('save_domain','sub');">[-]</a></td>
</tr>
<tr>
	<td><span class="bold"><?=__('suffix_domain')?></span>: <br /><span class="txtgray"><?=__('suffix_domain_tips')?></span></td>
	<td>
	<input type="text" name="setting[suffix_domain]" value="<?=$setting[suffix_domain]?>" />
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('min_domain_length')?></span>: <br /><span class="txtgray"><?=__('min_domain_length_tips')?></span></td>
	<td>
	<input type="text" name="setting[min_domain_length]" value="<?=$setting[min_domain_length]?>" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;<a href="http://bbs.google.com/thread-4660-1-1.html" target="_blank"><?=__('get_rewrite_rule')?></a></td>
</tr>
</table>
</form>
</div>
</div>

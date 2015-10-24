<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-03 18:45:56

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: seo.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('seo_manage')?><?php sitemap_tag(__('seo_manage')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('seo_manage_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=$item&menu=extend")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="update_setting" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_rewrite')?></span>: <br /><span class="txtgray"><?=__('open_rewrite_tips')?></span></td>
	<td><input type="radio" name="setting[open_rewrite]" value="0" <?=ifchecked(0,$setting['open_rewrite'])?>/>关闭&nbsp;&nbsp;
	<input type="radio" name="setting[open_rewrite]" value="1" <?=ifchecked(1,$setting['open_rewrite'])?> />Apache&nbsp;&nbsp;
	<input type="radio" name="setting[open_rewrite]" value="2" <?=ifchecked(2,$setting['open_rewrite'])?> />IIS&nbsp;&nbsp;
	<input type="radio" name="setting[open_rewrite]" value="3" <?=ifchecked(3,$setting['open_rewrite'])?> />Nginx&nbsp;&nbsp;
	<a href="http://bbs.google.com/thread-4660-1-1.html" target="_blank"><?=__('get_rewrite_rule')?></a></td>
</tr>
<tr>
	<td><span class="bold">首页标题</span>: <br /><span class="txtgray">首页网盘SEO标题</span></td>
	<td><textarea id="meta_title" name="meta_title" style="width:500px;height:60px"><?=$s['title']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_title','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_title','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">首页关键字</span>: <br /><span class="txtgray"><?=__('meta_keywords_tips')?></span></td>
	<td><textarea id="meta_keywords" name="meta_keywords" style="width:500px;height:60px"><?=$s['keywords']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_keywords','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_keywords','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">首页描述</span>: <br /><span class="txtgray"><?=__('meta_description_tips')?></span></td>
	<td><textarea id="meta_description" name="meta_description" style="width:500px;height:60px"><?=$s['description']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_description','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_description','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<?php if($auth[pd_a]){ ?>
<tr>
	<td><span class="bold">热门文件首页SEO标题</span>:</td>
	<td><textarea id="meta_title3" name="meta_title3" style="width:500px;height:60px"><?=$s3['title']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_title3','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_title3','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">热门文件首页SEO关键字</span>:</td>
	<td><textarea id="meta_keywords3" name="meta_keywords3" style="width:500px;height:60px"><?=$s3['keywords']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_keywords3','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_keywords3','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">热门文件首页SEO描述</span>: </td>
	<td><textarea id="meta_description3" name="meta_description3" style="width:500px;height:60px"><?=$s3['description']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_description3','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_description3','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td><span class="bold">共享文件首页SEO标题</span>:</td>
	<td><textarea id="meta_title2" name="meta_title2" style="width:500px;height:60px"><?=$s2['title']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_title2','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_title2','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">共享文件首页SEO关键字</span>:</td>
	<td><textarea id="meta_keywords2" name="meta_keywords2" style="width:500px;height:60px"><?=$s2['keywords']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_keywords2','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_keywords2','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">共享文件首页SEO描述</span>: </td>
	<td><textarea id="meta_description2" name="meta_description2" style="width:500px;height:60px"><?=$s2['description']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_description2','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_description2','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td><span class="bold">个人空间SEO标题</span>:</td>
	<td><textarea id="meta_title_s" name="meta_title_s" style="width:500px;height:60px"><?=$ss['title']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_title_s','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_title_s','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">个人空间SEO关键字</span>:</td>
	<td><textarea id="meta_keywords_s" name="meta_keywords_s" style="width:500px;height:60px"><?=$ss['keywords']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_keywords_s','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_keywords_s','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">个人空间SEO描述</span>: </td>
	<td><textarea id="meta_description_s" name="meta_description_s" style="width:500px;height:60px"><?=$ss['description']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_description_s','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_description_s','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td><span class="bold">文件浏览页SEO标题</span>:</td>
	<td><textarea id="meta_title_v" name="meta_title_v" style="width:500px;height:60px"><?=$sv['title']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_title_v','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_title_v','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">文件浏览页SEO关键字</span>:</td>
	<td><textarea id="meta_keywords_v" name="meta_keywords_v" style="width:500px;height:60px"><?=$sv['keywords']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_keywords_v','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_keywords_v','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">文件浏览页SEO描述</span>: </td>
	<td><textarea id="meta_description_v" name="meta_description_v" style="width:500px;height:60px"><?=$sv['description']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_description_v','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_description_v','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td><span class="bold">最终下载页SEO标题</span>:</td>
	<td><textarea id="meta_title_d" name="meta_title_d" style="width:500px;height:60px"><?=$sd['title']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_title_d','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_title_d','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">最终下载页SEO关键字</span>:</td>
	<td><textarea id="meta_keywords_d" name="meta_keywords_d" style="width:500px;height:60px"><?=$sd['keywords']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_keywords_d','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_keywords_d','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">最终下载页SEO描述</span>: </td>
	<td><textarea id="meta_description_d" name="meta_description_d" style="width:500px;height:60px"><?=$sd['description']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_description_d','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_description_d','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<?php } ?>
<tr>
	<td align="center" colspan="2"><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script type="text/javascript">
function copy_text(id){
	var field = getId(id);
	if (field){
		if (document.all){
			field.createTextRange().execCommand('copy');
			alert("<?=__('copy_success')?>");
		}else{
			alert("<?=__('alert_ie_copytext')?>");
		}	
	}
}

</script>
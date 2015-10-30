<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-28 21:28:51

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK Course Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: course.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if($action =='modify_course' || $action=='add_course'){ ?>
<div id="container">
<div class="box_style">
<form action="<?=urr("mydisk","item=$item")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="course_id" value="<?=$course_id?>" />
<input type="hidden" name="ref" value="<?=$ref?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<li>课程名称:</li>
<li><input type="text" name="course_name" value="<?=$course_edit['course_name']?>" style="width:200px" maxlength="50" /></li>
<li>分类：</li>
<li>
	<?php if($upload_cate){ ?>
	<select name="cate_id" id="cate_id">
		<option value="0">- 请选择分类 -</option>
		<?=get_cate_option(0,$course_edit['cate_id']);?>
	</select>
	<?php } ?>
</li>
<li>描述:</li>
<li><textarea name="description"><?=$course_edit['description']?></textarea></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
</form>
</div>
</div>
<script type="text/javascript">
function dosubmit(o){
	if(o.course_name.value.strtrim()==''){
		alert('课程名称错误');
		o.course_name.focus();
		return false;
	}
}
</script>
<?php 
}elseif($action =='course_delete'){
 ?>
<div id="container">
<div class="box_style">
<form action="<?=urr("mydisk","item=course")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="course_id" value="<?=$course_id?>" />
<input type="hidden" name="ref" value="<?=$ref?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<div class="cfm_info">
<li><img src="images/folder.gif" border="0" align="absmiddle" />&nbsp;<span class="txtgreen"><?=$course_name?></span></li>
<li>确定要删除该课程吗？</li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="top.$.jBox.close(true);" /></li>
</div>
</form>
</div>
</div>
<?php 
}elseif($action =='course_review'){
 ?>
<div id="container">
	<div class="box_style">
		<form action="<?=urr("mydisk","item=course")?>" method="post">
		<input type="hidden" name="action" value="<?=$action?>" />
		<input type="hidden" name="task" value="<?=$action?>" />
		<input type="hidden" name="course_id" value="<?=$course_id?>" />
		<input type="hidden" name="ref" value="<?=$ref?>" />
		<input type="hidden" name="formhash" value="<?=$formhash?>" />
		<div class="cfm_info">
			<li><img src="images/folder.gif" border="0" align="absmiddle" />&nbsp;<span class="txtgreen"><?=$course_name?></span></li>
			<li>确定要提交该课程审核吗？</li>
			<li>&nbsp;</li>
			<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="top.$.jBox.close(true);" /></li>
		</div>
		</form>
	</div>
</div>
<?php 
}elseif($action =='course_review_cancel'){
 ?>
<div id="container">
	<div class="box_style">
		<form action="<?=urr("mydisk","item=course")?>" method="post">
		<input type="hidden" name="action" value="<?=$action?>" />
		<input type="hidden" name="task" value="<?=$action?>" />
		<input type="hidden" name="course_id" value="<?=$course_id?>" />
		<input type="hidden" name="ref" value="<?=$ref?>" />
		<input type="hidden" name="formhash" value="<?=$formhash?>" />
		<div class="cfm_info">
			<li><img src="images/folder.gif" border="0" align="absmiddle" />&nbsp;<span class="txtgreen"><?=$course_name?></span></li>
			<li>确定要取消该课程审核吗？取消后审核通过的课程也会被取消审核通过的状态</li>
			<li>&nbsp;</li>
			<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="top.$.jBox.close(true);" /></li>
		</div>
		</form>
	</div>
</div>
<?php 
}elseif($action =='add_chapter_section' || $action =='modify_chapter_section'){
 ?>
<div id="container">
	<div class="box_style">
		<form action="<?=urr("mydisk","item=$item")?>" method="post" onsubmit="return dosubmit(this);">
		<input type="hidden" name="action" value="<?=$action?>" />
		<input type="hidden" name="task" value="<?=$action?>" />
		<input type="hidden" name="course_id" value="<?=$course_id?>" />
		<input type="hidden" name="cs_id" value="<?=$cs_id?>" />
		<input type="hidden" name="ref" value="<?=$ref?>" />
		<input type="hidden" name="formhash" value="<?=$formhash?>" />
		<li>章节名称:</li>
		<li><input type="text" name="cs_name" value="<?=$cs_edit['cs_name']?>" style="width:200px" maxlength="50" /></li>
		<li>上级章节：</li>
		<li>
			<select name="pid" id="pid">
				<option value="0">- 根章节 -</option>
				<?=get_chapter_section_option($course_id,0,$cs_edit['parent_id']);?>
			</select>
		</li>
		<li>描述:</li>
		<li><textarea name="description"><?=$cs_edit['description']?></textarea></li>
		<li>&nbsp;</li>
		<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
		</form>
	</div>
</div>
<script type="text/javascript">
	function dosubmit(o){
		if(o.cs_name.value.strtrim()==''){
			alert('章节名称错误');
			o.cs_name.focus();
			return false;
		}
	}
</script>
<?php 
}elseif($action =='chapter_section_delete'){
 ?>
<div id="container">
	<div class="box_style">
		<form action="<?=urr("mydisk","item=course")?>" method="post">
		<input type="hidden" name="action" value="<?=$action?>" />
		<input type="hidden" name="task" value="<?=$action?>" />
		<input type="hidden" name="cs_id" value="<?=$cs_id?>" />
		<input type="hidden" name="ref" value="<?=$ref?>" />
		<input type="hidden" name="formhash" value="<?=$formhash?>" />
		<div class="cfm_info">
			<li><img src="images/folder.gif" border="0" align="absmiddle" />&nbsp;<span class="txtgreen"><?=$cs_name?></span></li>
			<li>确定要删除该章节吗？</li>
			<li>&nbsp;</li>
			<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="top.$.jBox.close(true);" /></li>
		</div>
		</form>
	</div>
</div>
<?php 
}elseif($action =='add_file_cs_relation'){
 ?>
<style type="text/css">
	.file_table{
		font-size: 12px;
	}
</style>
<div id="container">
	<div class="box_style">
		<form action="<?=urr("mydisk","item=$item")?>" method="post" onsubmit="return dosubmit(this);">
		<input type="hidden" name="action" value="<?=$action?>" />
		<input type="hidden" name="task" value="<?=$action?>" />
		<input type="hidden" name="cs_id" value="<?=$cs_id?>" />
		<input type="hidden" name="course_id" value="<?=$course_id?>" />
		<input type="hidden" name="ref" value="<?=$ref?>" />
		<input type="hidden" name="formhash" value="<?=$formhash?>" />
		<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="file_table">
			<?php if(count($user_folder_file)){  ?>
			<tr>
				<td width="30%" class="bold">文件(夹)名</td>
				<td align="center" class="bold">浏览数/<?=__('file_downs')?></td>
				<td align="center" class="bold">文件(夹)大小</td>
				<td align="center" width="150" class="bold">创建时间</td>
			</tr>
			<?php 
			}
			if(count($user_folder_file)){
				foreach($user_folder_file as $k => $v){
					$color = ($k%2 ==0) ? 'color1' :'color4';
			 ?>
				<?php if($v['is_folder']){  ?>
				<tr>
					<td width="30%" class="font_size12">
						<?php  echo str_repeat('&nbsp;',$v['level']*2) ?>
						<img src="images/folder.gif" align="absmiddle" border="0" />
						<?=$v['folder_name']?>
					</td>
					<td align="center" class="">-</td>
					<td align="center" class=""><?=$v['folder_size']?></td>
					<td align="center" width="150" class=""><?=$v['in_time']?></td>
				</tr>
				<?php } ?>
				<?php if($v['is_file']){  ?>
				<tr>
					<td width="30%" class="">
						<?php  echo str_repeat('&nbsp;',$v['level']*2) ?>
						<input type="checkbox" name="file_ids[]" id="file_ids" value="<?=$v['file_id']?>" <?php  if(in_array($v['file_id'],$user_select_file)){echo 'checked';}  ?>>
						<?=$v['file_name']?>
					</td>
					<td align="center" class=""><?=$v['file_views']?>/<?=$v['file_downs']?></td>
					<td align="center" class=""><?=$v['file_size']?></td>
					<td align="center" width="150" class=""><?=$v['file_time']?></td>
				</tr>
				<?php } ?>
			<?php 
				}
			}
			 ?>
			<?php 
			if(!count($user_folder_file)){
			 ?>
			<tr>
				<td colspan="6" align="center">此目录暂无文件(夹)记录</td>
			</tr>
			<?php 
            }
             ?>
		</table>
		<li>&nbsp;</li>
		<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
		</form>
	</div>
</div>
<script type="text/javascript">
	/**
	 * 折叠分类列表
	 */
	function rowClicked(obj)
	{
		// 当前图像
		img = obj;
		// 取得上二级tr>td>img对象
		obj = obj.parentNode.parentNode;
		// 整个分类列表表格
		var tbl = document.getElementById("list-table");
		// 当前分类级别
		var lvl = parseInt(obj.className);
		// 是否找到元素
		var fnd = false;
		var sub_display = img.src.indexOf('menu_minus.gif') > 0 ? 'none' : (Browser.isIE) ? 'block' : 'table-row' ;
		// 遍历所有的分类
		for (i = 0; i < tbl.rows.length; i++)
		{
			var row = tbl.rows[i];
			if (row == obj)
			{
				// 找到当前行
				fnd = true;
				//document.getElementById('result').innerHTML += 'Find row at ' + i +"<br/>";
			}
			else
			{
				if (fnd == true)
				{
					var cur = parseInt(row.className);
					var icon = 'icon_' + row.id;
					if (cur > lvl)
					{
						row.style.display = sub_display;
						if (sub_display != 'none')
						{
							var iconimg = document.getElementById(icon);
							iconimg.src = iconimg.src.replace('plus.gif', 'minus.gif');
						}
					}
					else
					{
						fnd = false;
						break;
					}
				}
			}
		}

		for (i = 0; i < obj.cells[0].childNodes.length; i++)
		{
			var imgObj = obj.cells[0].childNodes[i];
			if (imgObj.tagName == "IMG" && imgObj.src != 'images/menu_arrow.gif')
			{
				imgObj.src = (imgObj.src == imgPlus.src) ? 'images/menu_minus.gif' : imgPlus.src;
			}
		}
	}
</script>
<?php 
}elseif($action =='file_cs_relation_delete'){
 ?>
<div id="container">
	<div class="box_style">
		<form action="<?=urr("mydisk","item=course")?>" method="post">
		<input type="hidden" name="action" value="<?=$action?>" />
		<input type="hidden" name="task" value="<?=$action?>" />
		<input type="hidden" name="course_id" value="<?=$course_id?>" />
		<input type="hidden" name="cs_id" value="<?=$cs_id?>" />
		<input type="hidden" name="file_id" value="<?=$file_id?>" />
		<input type="hidden" name="ref" value="<?=$ref?>" />
		<input type="hidden" name="formhash" value="<?=$formhash?>" />
		<div class="cfm_info">
			<li><img src="images/folder.gif" border="0" align="absmiddle" />&nbsp;<span class="txtgreen"><?=$file_name?></span></li>
			<li>确定要删除该文件吗？</li>
			<li>&nbsp;</li>
			<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="top.$.jBox.close(true);" /></li>
		</div>
		</form>
	</div>
</div>
<?php } ?>
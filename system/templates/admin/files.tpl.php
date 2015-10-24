<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-09-27 09:20:28

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: files.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if($action=='filterword'){ ?>
<div id="container">
<h1><?=__('filterword_title')?><?php sitemap_tag(__('filterword_title')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('filterword_title_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=$item&menu=file")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('filterword')?></span>: <br /><span class="txtgray"><?=__('filterword_tips')?></span></td>
	<td>
	<textarea name="setting[filter_word]" id="filter_word" style="width:300px; height:60px"><?=$settings['filter_word']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('filter_word','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('filter_word','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_update')?>"/></td>
</tr>
</table>
</form>
</div>
</div>
<?php 
}elseif($action =='total_del'){
 ?>
<div class="info_box">
<div class="info_box_tit"><img src="images/light.gif" align="absmiddle" border="0" /> <?=__('tips')?></div>
<div class="info_box_msg">
<?=$msg?>
<br />
<a href="javascript:document.location.reload();"><?=__('run_del_tip')?></a>
</div>
<br />

</div>
<?php 
}elseif($action =='index' || $action =='search'){
 ?>
<div id="container">
<h1><?=__('file_list')?><?php sitemap_tag(__('file_list')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('public_title_tips')?></span>
</div>
<form name="search_frm" action="<?=urr(ADMINCP,"")?>" method="get">
<input type="hidden" name="item" value="files" />
<input type="hidden" name="menu" value="file" />
<input type="hidden" name="action" value="search" />
<div class="search_box">
<div class="l"><img src="<?=$admin_tpl_dir?>images/it_nav.gif" align="absbottom" />
<?=__('view_mode')?>: 
<select name="view" id="view" onchange="chg_view();">
<option value="mydisk_file" <?=ifselected('mydisk_file',$view,'str');?>><?=__('mydisk_file')?></option>
<option value="checked_file" <?=ifselected('checked_file',$view,'str');?>>已审核文件</option>
<option value="unchecked_file" <?=ifselected('unchecked_file',$view,'str');?>>未审核文件</option>
<option value="user_del" <?=ifselected('user_del',$view,'str');?> style="color:#FF0000"><?=__('file_recycle')?></option>
</select>
</div>
<div class="r">
日期：<input type="text" name="dd" value="<?=$dd?>" title="日期格式：<?=$dd?>"/>
用户名：<input type="text" name="user" value="<?=$user?>" />
关键字：<input type="text" name="word" value="<?=$word?>" title="<?=__('search_files_tips')?>" />
<select name="sel_type">
<option value="0"<?=ifselected(0,$sel_type);?>>文件名</option>
<option value="1"<?=ifselected(1,$sel_type);?>>文件ID</option>
</select>
<input type="submit" class="btn" value="<?=__('search_files')?>" /></div>
</div>
</form>
<div class="clear"></div>
<script language="javascript">
function chg_view(){
	var view = getId('view').value.strtrim();
	document.location.href = '<?=urr(ADMINCP,"item=files&menu=file&action=index&view='+view+'")?>';
}
function dosearch(o){
	if(o.word.value.strtrim().length <1){
		o.word.focus();
		return false;
	}
}
function load_file_addr(id){
	$('#dl_'+id).html('<img src="images/ajax_loading.gif" align="absmiddle" border="0" />');
	$.ajax({
		type : 'post',
		url : 'ajax.php',
		data : 'action=load_file_addr&file_id='+id+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			var arr = msg.split('|');
			if(arr[0] == 'true'){
				$('#dl_'+id).html(arr[1]);
				$('#tr_'+id).attr('onclick','');
				$('#tr_'+id).attr('title','');
			}else{
				alert(msg);
			}
		},
		error:function(){
		}

	});
}
function down_process2(file_id){
	$.ajax({
		type : 'post',
		url : 'ajax.php',
		data : 'action=down_process&file_id='+file_id+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			if(msg == 'true'){

			}else{
				alert(msg);
			}
		},
		error:function(){
		}

	});
}

function dosubmit(o){
	if(checkbox_ids("file_ids[]") != true){
		alert("<?=__('please_select_operation_files')?>");
		return false;
	}
}
function dis(){
	if(getId('move_to').checked==true){
	getId('dest_sid').disabled=false;
	getId('server_oid').disabled=true;
	}else if(getId('move_oid').checked==true){
	getId('dest_sid').disabled=true;
	getId('server_oid').disabled=false;
	}else{
	getId('dest_sid').disabled=true;
	getId('server_oid').disabled=true;
	}
}

</script>

<form name="public_frm" action="<?=urr(ADMINCP,"item=files&menu=file")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<?php 
if(count($files_array)){
 ?>
<tr>
	<td width="40%" class="bold"><?=__('file_name')?></td>
	<td align="center" class="bold" width="150"><?=__('username')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td align="center" class="bold"><?=__('file_views')?>|<?=__('file_downs')?></td>
	<td align="center" width="150" class="bold"><?=__('file_upload_time')?></td>
	<td align="right" width="120" class="bold">
	<?=__('status')?>/<?=__('operation')?>
	</td>
</tr>
<?php 
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>" id="tr_<?=$v['file_id']?>" onclick="load_file_addr('<?=$v[file_id]?>');" title="点击可加载此文件下载地址，可实现直接下载查看">
	<td><input type="checkbox" name="file_ids[]" id="file_ids" value="<?=$v['file_id']?>" /><?=file_icon($v['file_extension'])?>
	<?php if($v['is_image']){ ?>
	<a href="<?=$v['a_viewfile']?>" id="p_<?=$k?>" target="_blank"><?=$v['file_name']?></a>
<div id="c_<?=$k?>" class="menu_thumb"><img src="<?=$v['file_thumb']?>" /></div>
<script type="text/javascript">on_menu('p_<?=$k?>','c_<?=$k?>','x','');</script>
	<?php }else{ ?>
	<a href="<?=$v['a_viewfile']?>" target="_blank"><?=$v['file_name']?></a>
	<?php } ?>
	&nbsp;<span id="dl_<?=$v[file_id]?>"></span>
	<span class="txtgray" title="服务器标识ID">(ID:<?=$v[server_oid]?> )</span><br />
	<u class="txtgray" title="存储真实地址"><?=$v[file_abs_path]?></u><br />
	<?php if($v['file_description']){ ?>
	<span class="txtgray"><?=$v['file_description']?></span>
	<?php } ?>
	</td>
	<td align="center"><a href="<?=$v['a_user_view']?>"><?=$v['username']?></a></td>
	<td align="center"><?=$v['file_size']?></td>
	<td align="center"><?=$v['file_views']?>,<?=$v['file_downs']?></td>
	<td align="center" width="150" class="txtgray"><?=$v['file_time']?></td>
	<td align="right">
	<?php if($view=='user_del'){ ?> 	
	<a href="<?=urr("admincp","item=files&menu=file&action=total_del&task=safe&file_id=$v[file_id]")?>" class="txtred" target="_blank" title="<?=__('safe_del')?>"><?=__('safe_del_s')?></a> / <a href="<?=urr("admincp","item=files&menu=file&action=total_del&file_id=$v[file_id]")?>" class="txtred" target="_blank" title="<?=__('unsafe_del')?>"><?=__('unsafe_del_s')?></a>
	<?php }else{ ?>
	<?=$v['status_txt']?> / 
	<a href="<?=$v['a_recycle_delete']?>" onclick="return confirm('<?=__('recycle_delete_confirm')?>');"><?=__('delete')?></a>
	<?php } ?>
	<a href="<?=$v['a_edit']?>"><?=__('edit')?></a>
	</td>
</tr>
<?php 		
	}
	unset($files_array);
 ?>
<?php if($page_nav){ ?>
<tr>
	<td colspan="6"><?=$page_nav?></td>
</tr>
<?php } ?>
<tr>
	<td colspan="6"><a href="javascript:void(0);" onclick="reverse_ids(document.public_frm.file_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.public_frm.file_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<?php if($view=='user_del'){ ?>
	<input type="radio" name="task" value="restore_del_file" checked="checked" /><?=__('restore')?>&nbsp;&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/><br /><br />
	<a href="<?=urr("admincp","item=files&menu=file&action=total_del&task=safe")?>" class="f14 bold" target="_blank"><?=__('safe_del')?><i class="txtred"><?=__('safe_del_tips')?></i></a>&nbsp;<br /><br />
	<a href="<?=urr("admincp","item=files&menu=file&action=total_del")?>" class="f14 bold" target="_blank"><?=__('unsafe_del')?><i class="txtred"><?=__('unsafe_del_tips')?></i></a>&nbsp;<br /><br />
	<span class="txtred"><?=__('recycle_del_warning')?></span>&nbsp;
	<?php }else{ ?>
	<input type="radio" name="task" value="check_public" checked="checked" onclick="dis();" /><?=__('check_public')?>&nbsp;&nbsp;
	<!--<input type="radio" name="task" value="file_to_locked" /><?=__('file_to_locked')?>&nbsp;&nbsp;
	<input type="radio" name="task" value="file_to_unlocked" /><?=__('file_to_unlocked')?>&nbsp;&nbsp;-->
	<input type="radio" name="task" value="delete_file_complete" onclick="dis();" /><?=__('delete_complete')?>&nbsp;&nbsp;
	<input type="radio" name="task" value="move_to" onclick="dis();" id="move_to" /><?=__('move_to')?>: 
	<select name="dest_sid" id="dest_sid" disabled="disabled">
	<option value="0"><?=__('uncate_public_file')?></option>
	<option disabled="disabled"><?=__('split_public_line')?></option>
<?=get_cate_option(0);?>
	</select>&nbsp;&nbsp;
  <input type="radio" name="task" value="move_oid" id="move_oid" onclick="dis()" />调整标识ID&nbsp;
  <select name="server_oid" id="server_oid" disabled="disabled" style="width:120px;">
	<option value="0">- 暂无 -</option>
	<?php 
	$srv = get_servers();
	if(count($srv)){
		foreach($srv as $v){
		
	 ?>
	<option value="<?=$v[server_oid]?>"><?=$v[server_name]?>,(ID:<?=$v[server_oid]?>)</option>
	<?php 	
		}
	}
	 ?>
	</select>&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/>
	<?php } ?>
	</td>
</tr>
<?php 		
}else{
 ?>
<tr>
	<td colspan="6"><?=__('file_not_found')?></td>
</tr>
<?php 
}
 ?>
</table>
</form>
</div>
</div>
<?php }elseif($action=='edit'){ ?>
<script charset="utf-8" src="editor/kindeditor-min.js"></script>
<script charset="utf-8" src="editor/lang/zh_CN.js"></script>
<script>
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[name="file_description"]', {
			resizeType : 1,
			allowPreviewEmoticons : false,
			allowImageUpload : false,
			items : [
				'fullscreen','|','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				'insertunorderedlist', '|', 'emoticons', 'image', 'link']
		});
	});
</script>
<div id="container">
<h1><?=__('file_list')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('public_title_tips')?></span>
</div>
<form name="public_frm" action="<?=urr(ADMINCP,"item=files&menu=file")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="<?=$action?>"/>
<input type="hidden" name="file_id" value="<?=$file_id?>"/>
<input type="hidden" name="ref" value="<?=$ref?>"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2"><?=__('curr_file')?>: <span class="txtgreen"><?=$file_name?></span></td>
</tr>
<tr>
	<td><?=__('file_description')?>:</td>
	<td><textarea name="file_description" rows="20" cols="120"><?=$file_description?></textarea></td>
</tr>
<?php if($auth[pd_a]){ ?>
<tr>
	<td><span class="bold">文件浏览页SEO标题</span>:</td>
	<td><textarea id="meta_title" name="meta_title" style="width:500px;height:60px"><?=$s['title']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_title','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_title','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">文件浏览页SEO关键字</span>:</td>
	<td><textarea id="meta_keywords" name="meta_keywords" style="width:500px;height:60px"><?=$s['keywords']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_keywords','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_keywords','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">文件浏览页SEO描述</span>: </td>
	<td><textarea id="meta_description" name="meta_description" style="width:500px;height:60px"><?=$s['description']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_description','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_description','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">文件最终下载页SEO标题</span>:</td>
	<td><textarea id="meta_title2" name="meta_title2" style="width:500px;height:60px"><?=$s2['title']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_title2','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_title2','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">文件最终下载页SEO关键字</span>:</td>
	<td><textarea id="meta_keywords2" name="meta_keywords2" style="width:500px;height:60px"><?=$s2['keywords']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_keywords2','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_keywords2','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">文件最终下载页SEO描述</span>: </td>
	<td><textarea id="meta_description2" name="meta_description2" style="width:500px;height:60px"><?=$s2['description']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_description2','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_description2','sub');">[-]</a>
	</td>
</tr>
<?php } ?>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table></form>
</div>
</div>
<?php } ?>
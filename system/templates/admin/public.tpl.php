<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-09-27 09:20:32

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: public.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php if($action =='category'){ ?>
<div id="container">
<h1><?=__('category_title')?><?php sitemap_tag(__('category_title')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('category_title_tips')?></span>
</div>
<form name="link_form" action="<?=urr(ADMINCP,"item=$item&menu=$menu")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<?php 
if(get_cate_tree()){
 ?>
<tr>
	<td width="40%" class="bold"><?=__('show_order')?>|<?=__('cate_name')?></td>
	<td class="bold" width="180"><?=__('show_cate_position')?></td>
	<td align="center" class="bold"><?=__('file_num')?></td>
	<td align="right" width="100" class="bold"><?=__('operation')?></td>
</tr>
<?=get_cate_tree()?>

<?php 
}else{	
 ?>
<tr>
	<td colspan="6" align="center"><?=__('category_not_found')?></td>
</tr>
<?php 
}
 ?>
<tr>
	<td align="center" colspan="5">
	<input type="button" class="btn" value="<?=__('add_cate')?>" onclick="go('<?=urr(ADMINCP,"item=$item&menu=file&action=add_cate")?>');" />&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_update')?>"/>
	</td>
</tr>
</table>
</form>
</div>
</div>
<?php }elseif($action =='add_cate' || $action =='modify_cate'){ ?>
<div id="container">
<?php if($action =='add_cate'){ ?>
<h1><?=__('add_cate_title')?></h1>
<?php }else{ ?>
<h1><?=__('modify_cate_title')?></h1>
<?php } ?>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('add_cate_title_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=$item&menu=$menu")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="cate_id" value="<?=$cate_id?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><span class="bold"><?=__('pid')?>:</span><br /><span class="txtgray"><?=__('pid_tips')?></span></td>
	<td>
	<select name="pid">
	<option value="0" style="color:#008800"><?=__('top_cate')?></option>
	<?=get_cate_option(0,$pid);?>
	</select>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('cate_name')?>:</span><br /><span class="txtgray"><?=__('cate_name_tips')?></span></td>
	<td><input type="text" name="cate_name" value="<?=$cate_name?>" maxlength="50" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('nav_show')?>:</span><br /><span class="txtgray"><?=__('nav_show_tips')?></span></td>
	<td><input type="radio" name="nav_show" value="1" <?=ifchecked($nav_show,1)?> /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="nav_show" value="0" <?=ifchecked($nav_show,0)?> /><?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('cate_list')?>:</span><br /><span class="txtgray"><?=__('cate_list_tips')?></span></td>
	<td><input type="radio" name="cate_list" value="1" <?=ifchecked($cate_list,1)?> /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="cate_list" value="0" <?=ifchecked($cate_list,0)?> /><?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('share_index')?>:</span><br /><span class="txtgray"><?=__('share_index_tips')?></span></td>
	<td><input type="radio" name="share_index" value="1" <?=ifchecked($share_index,1)?> /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="share_index" value="0" <?=ifchecked($share_index,0)?> /><?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(o.cate_name.value.strtrim().length <1){
		alert("<?=__('cate_name_error')?>");
		o.cate_name.focus();
		return false;
	}
}
</script>
<?php }elseif($action =='viewfile'){ ?>
<div id="container">
<h1><?=__('file_manage')?><?php sitemap_tag(__('file_manage')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('public_setting_tips')?></span>
</div>
<div class="search_box">
<img src="<?=$admin_tpl_dir?>images/it_nav.gif" align="absbottom" />
<?=__('view_mode')?>: 
<select name="view" id="view" onchange="chg_view();">
<option value="0" <?=ifselected(0,$cate_id);?> style="color:#008800"><?=__('uncate_public_file')?></option>
<option value="-1" <?=ifselected('-1',$cate_id,'str');?> style="color:#0000FF"><?=__('uncheck_public_file')?></option>
<option value="-2" <?=ifselected('-2',$cate_id,'str');?>><?=__('commend_file')?></option>
<option disabled="disabled"><?=__('split_public_line')?></option>
<?=get_cate_option(0,$cate_id);?>
</select>
</div>
<form name="file_frm" action="<?=urr(ADMINCP,"item=$item&menu=$menu")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<?php 
if(count($files_array)){
 ?>
<tr>
	<td width="30%" class="bold"><?=__('file_name')?></td>
	<td class="bold" width="120"><?=__('username')?></td>
	<td class="bold" width="120"><?=__('category')?></td>
	<td align="center" width="80" class="bold"><?=__('file_status')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td align="center" width="150" class="bold"><?=__('file_upload_time')?></td>
	<td align="center" width="100" class="bold"><?=__('upload_ip')?></td>
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
	<td><a href="<?=$v[a_user_view]?>"><?=$v[username]?></a></td>
	<td><?=get_cate_path($v['cate_id'])?></td>
	<td align="center"><?=$v['status_txt']?></td>
	<td align="center"><?=$v['file_size']?></td>
	<td align="center" class="txtgray"><?=$v['file_time']?></td>
	<td align="center" class="txtgray"><?=$v['ip']?>&nbsp;</td>
</tr>
<?php 		
	}
	unset($files_array);
 ?>
<tr>
	<td colspan="8"><a href="javascript:void(0);" onclick="reverse_ids(document.file_frm.file_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.file_frm.file_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<input type="radio" name="task" value="check_file" checked="checked" onclick="dis();" /><?=__('check_ok')?> 
	<input type="radio" name="task" value="uncheck_file" onclick="dis();" /><?=__('check_back')?> 
	<input type="radio" name="task" value="delete" onclick="dis();" /><span class="txtred"><?=__('delete')?></span>
	<input type="radio" name="task" value="commend" onclick="dis();" /><span class="txtblue"><?=__('commend')?></span>
	<input type="radio" name="task" value="uncommend" onclick="dis();" /><span class="txtblue"><?=__('uncommend')?></span>
	<input type="radio" name="task" value="move_to" onclick="dis();" id="move_to" /><?=__('move_to')?>: 
	<select name="dest_sid" id="dest_sid" disabled="disabled">
	<option value="0"><?=__('uncate_public_file')?></option>
	<option disabled="disabled"><?=__('split_public_line')?></option>
<?=get_cate_option(0);?>
	</select>
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
<?php 		
}else{
 ?>
<tr>
	<td colspan="8"><?=__('file_not_found')?></td>
</tr>
<?php 
}
 ?>
<?php if($page_nav){ ?>
<tr>
	<td colspan="8"><?=$page_nav?></td>
</tr>
<?php } ?>
</table>
</form>
</div>
</div>
<script language="javascript">
function load_file_addr(id){
	$('#dl_'+id).html('<img src="images/ajax_loading.gif" align="absmiddle" border="0" />');
	$.ajax({
		type : 'post',
		url : 'adm_ajax.php',
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

function dis(){
	if(getId('move_to').checked==true){
	getId('dest_sid').disabled=false;
	}else{
	getId('dest_sid').disabled=true;
	}
}
function chg_view(){
	var view = getId('view').value.strtrim();
	document.location.href = '<?=urr(ADMINCP,"item=$item&menu=file&action=$action&cate_id='+view+'")?>';
}
function dosubmit(o){
	if(checkbox_ids("file_ids[]") != true){
		alert("<?=__('please_select_operation_files')?>");
		return false;
	}
}
</script>
<?php }else{ ?>
<div id="container">
<h1><?=__('public_setting')?><?php sitemap_tag(__('public_setting')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('public_setting_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=$item&menu=$menu")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('check_public_file')?></span>: <br /><span class="txtgray"><?=__('check_public_file_tips')?></span></td>
	<td><input type="radio" name="setting[check_public_file]" value="1" <?=ifchecked(1,$settings['check_public_file'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[check_public_file]" value="0" <?=ifchecked(0,$settings['check_public_file'])?>/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold">上传时可直接指定公共分类</span>: <br /><span class="txtgray">用户可以直接在上传文件时把文件指定在相应的分类中</span></td>
	<td><input type="radio" name="setting[upload_cate]" value="2" <?=ifchecked(2,$settings['upload_cate'])?> />必填
	<input type="radio" name="setting[upload_cate]" value="1" <?=ifchecked(1,$settings['upload_cate'])?> />选填
	<input type="radio" name="setting[upload_cate]" value="0" <?=ifchecked(0,$settings['upload_cate'])?>/>不显示</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_update')?>"/></td>
</tr>
</table>
</form>
</div>
</div>
<?php } ?>


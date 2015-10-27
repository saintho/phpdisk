<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: profile.tpl.php 126 2014-03-17 07:51:04Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action=='files'){#-->
<div class="panel panel-default">
	<div class="panel-heading">文件管理&nbsp;&nbsp;<a href="javascript:;" onclick="abox('{#urr("mydisk","item=folders&action=add_folder&folder_id=$folder_id")#}','创建新目录',350,200);"><img src="images/ico_write.png" align="absmiddle" border="0" />创建新目录</a></div>
	<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line table table-striped">
	<tr>
		<td>当前路径：{$nav_path}</td>
		<td colspan="4" align="right"><form method="get" action="{#urr("mydisk","")#}" onsubmit="return dosearch(this);">
	<input type="hidden" name="action" value="files" />
	<input type="hidden" name="task" value="search" />
	<?=__('search_file')?>:<input type="text" name="word" value="{$word}"/><select name="folder_id" style="width:120px;">
		<option value="0"> - 所有目录 - </option>
	{#get_folder_option(0,$folder_id);#}
		</select>
	<input type="submit" class="btn" value="<?=__('search')?>" />
	</form>
	<script type="text/javascript">
	function dosearch(o){
		if(o.word.value.strtrim()==''){
		o.word.focus();
		return false;
		}
	}
	</script>
		</td>
	</tr>
	<form action="{#urr("mydisk","item=files")#}" name="file_form" method="post" onsubmit="return dosubmit(this);">
	<input type="hidden" name="action" value="op_file" />
	<input type="hidden" name="formhash" value="{$formhash}" />
	<!--#if(count($folders_array) || count($files_array)){#-->
	<tr>
		<td width="50%" class="bold">文件(夹)名</td>
		<td align="center" class="bold">浏览数/<?=__('file_downs')?></td>
		<td align="center" class="bold">文件(夹)大小</td>
		<td align="center" width="150" class="bold">创建时间</td>
		<td align="right" class="bold">
		<?=__('operation')?>|<?=__('sort')?>
		</td>
	</tr>
	<!--#
	}
	if(count($folders_array)){
		foreach($folders_array as $k => $v){
			$color = ($k%2 ==0) ? 'color1' :'color4';
	#-->
	<tr class="">
		<td>
		<input type="checkbox" disabled="disabled"/>
		<img src="images/folder.gif" align="absmiddle" border="0" />
		<a href="{$v['a_folder_view']}">{$v['folder_name']}</a>
		</td>
		<td align="center" class="txtgray">-</td>
		<td align="center" class="txtgray">{$v['folder_size']}</td>
		<td align="center" class="txtgray">{$v['in_time']}</td>
		<td align="right">
		<a href="javascript:;" onclick="abox('{$v[a_edit]}','<?=__('modify_folder')?>',350,200);"><img src="images/ico_write.png" align="absbottom" border="0" /></a>
		<a href="javascript:;" onclick="abox('{$v[a_del]}','<?=__('del_folder')?>',400,200)"><img src="images/delete_icon.gif" align="absmiddle" border="0" /></a>
		</td>
	</tr>
	<!--#
		}
	}

	if(count($files_array)){
		foreach($files_array as $k => $v){
			$color = ($k%2 ==0) ? 'color1' :'color4';
	#-->
	<tr class="">
		<td>
		<input type="checkbox" name="file_ids[]" id="file_ids" value="{$v['file_id']}" />
		{#file_icon($v['file_extension'])#}
		<!--#if($v['is_image']){#-->
		<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" >{$v['file_name']}</a>{$v[file_new]}&nbsp;<span class="txtgray f12">{$v['file_description']}</span><br />
	<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
	<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','');</script>
		<!--#}else{#-->
		<a href="{$v['a_viewfile']}" target="_blank" >{$v['file_name']}</a>{$v[file_new]} <span class="txtgray">{$v['file_description']}</span>
		<!--#}#-->
		</td>
		<td align="center" class="txtgray">{#get_discount($v[userid],$v['file_views'])#}/{#get_discount($v[userid],$v['file_downs'])#}</td>
		<td align="center" class="txtgray">{$v['file_size']}</td>
		<td align="center" class="txtgray">{$v['file_time']}</td>
		<td align="right">
		<a href="javascript:;" onclick="abox('{$v['a_modify']}','<?=__('modify_file')?>',600,400)" title="<?=__('modify')?>"><img src="images/edit_icon.gif" align="absmiddle" border="0" /></a>
		<input type="text" name="show_order[]" style="text-align:center;width:24px" value="{$v[show_order]}" maxlength="2" />
		<input type="hidden" name="file_ids2[]" value="{$v['file_id']}" />
		</td>
	</tr>
	<!--#
		}
	}
	if(count($files_array)){
	#-->
	<tr>
		<td><a href="javascript:void(0);" onclick="reverse_ids(document.file_form.file_ids);"><?=__('select_all')?></a>&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.file_form.file_ids);"><?=__('select_cancel')?></a></td>
		<td colspan="6" style="padding-top:10px;" align="right">{$page_nav}&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6">文件操作： <input type="radio" name="task" value="del_file" onclick="dis()" checked="checked" /><?=__('delete')?>&nbsp;
		<input type="radio" name="task" value="outlink" onclick="dis()" /><?=__('bat_copy_link')?>&nbsp;
		<input type="radio" name="task" value="update_order" onclick="dis()" id="update_order" /><?=__('sort')?>&nbsp;
		<input type="radio" name="task" value="move_file" id="move_file" onclick="dis()" /><?=__('bat_category')?>&nbsp;
		<select name="dest_fid" id="dest_fid" disabled="disabled" style="width:120px;">
		<option value="0"><?=__('root_folder_default')?></option>
	{#get_folder_option(0);#}
		</select>&nbsp;
		<input type="submit" class="btn" value="<?=__('btn_submit')?>"  onclick="return confirm('<?=__('confirm_op')?>');"/></td>
	</tr>
	</form>
	<!--#
	}
	#-->
	<!--#
	if(!count($files_array) && !count($folder_array)){
	#-->
	<tr>
		<td colspan="6" align="center">此目录暂无文件(夹)记录</td>
	</tr>
	<!--#
	}
	#-->
	</table>
</div>
<script language="javascript">
function dis(){
	if(getId('move_file').checked==true){
		getId('dest_fid').disabled =false;
	}else{
		getId('dest_fid').disabled =true;
	}
}

function dosubmit(o){
	if(getId('update_order').checked ==false){
		if(checkbox_ids("file_ids[]") != true){
			alert("<?=__('please_select_operation_files')?>");
			return false;
		}
	}
}
</script>
<!--#}elseif($action=='course_manage'){#-->
<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading">课程管理&nbsp;&nbsp;
		<a href="javascript:;" onclick="abox('{#urr("mydisk","item=course&action=add_course")#}','创建新课程',350,250);"><img src="images/ico_write.png" align="absmiddle" border="0" />创建课程</a></div>

	<div class="breadcrumb-search-div">
		<div class="col-xs-7 nav-path">当前路径：{$nav_path}</div>
		<div class="col-xs-5 pull-right">
			<form class="form-inline" method="get" action="{#urr("mydisk","item=profile")#}" onsubmit="return dosearch(this);" >
			<div class="form-group">
				<label for="inputSearch">搜索课程:</label>
				<input type="hidden" name="item" value="profile" />
				<input type="hidden" name="action" value="course_manage" />
				<input type="hidden" name="task" value="search" id="inputSearch"/>
				<input type="text" name="word" value="{$word}" class="form-control"/>
			</div>
			<button type="submit" class="btn btn-default"><?=__('search')?></button>
			</form>
			<script type="text/javascript">
				function dosearch(o){
					if(o.word.value.strtrim()==''){
						o.word.focus();
						//return false;
					}
				}
			</script>
		</div>
		<div class="clear"></div>
	</div>
	<table align="center" width="100%" class="td_line table table-striped">
		<form action="{#urr("mydisk","item=files")#}" name="file_form" method="post" onsubmit="return dosubmit(this);">
		<input type="hidden" name="action" value="op_file" />
		<input type="hidden" name="formhash" value="{$formhash}" />
		<!--#if(count($course_array)){#-->
		<tr>
			<td width="12%" class="bold">课程名称</td>
			<td width="10%" align="center" class="bold">分类</td>
			<td width="8%" align="center" class="bold">视频数</td>
			<td width="8%" align="center" class="bold"><?=__('file_downs')?></td>
			<td width="8%" align="center" class="bold">浏览数</td>
			<td width="12%" align="center" class="bold">状态</td>
			<td width="17%" align="center" width="150" class="bold">更新时间</td>
			<td width="13%" align="center" class="bold">
				<?=__('operation')?>
			</td>
		</tr>
		<!--#
		}
		if(count($course_array)){
			foreach($course_array as $k => $v){
				$color = ($k%2 ==0) ? 'color1' :'color4';
		#-->
		<tr class="">
			<td>
				<img src="images/folder.gif" align="absmiddle" border="0" />
				<a href="{$v['a_course_view']}">{$v['course_name']}</a>
			</td>
			<td align="center" class="txtgray">{$v['cate_name']}</td>
			<td align="center" class="txtgray">{$v['file_num']}</td>
			<td align="center" class="txtgray">{$v['download_num']}</td>
			<td align="center" class="txtgray">{$v['view_num']}</td>
			<td align="center" class="txtgray">{$v['status']}</td>
			<td align="center" class="txtgray">{$v['update_date']}</td>
			<td align="center">
				<!--#if($v['status_num'] == 1){#-->
				<a href="javascript:;" onclick="abox('{$v[a_course_review]}','提交上线审核',400,250)"><img src="images/upload_file_icon.gif" align="absmiddle" border="0" /></a>
				<!--#}#-->
				<!--#if($v['status_num'] == 2){#-->
				<a href="javascript:;" onclick="abox('{$v[a_course_review_cancel]}','取消上线审核',400,250)"><img src="images/down_file_icon.gif" align="absmiddle" border="0" /></a>
				<!--#}#-->
				<a href="javascript:;" onclick="abox('{$v[a_edit]}','修改课程',350,250);"><img src="images/ico_write.png" align="absbottom" border="0" /></a>
				<a href="javascript:;" onclick="abox('{$v[a_del]}','删除课程',400,250)"><img src="images/delete_icon.gif" align="absmiddle" border="0" /></a>
			</td>
		</tr>
		<!--#
			}
		}
		#-->
		<!--#
		if(!count($course_array) ){
		#-->
		<tr>
			<td colspan="6" align="center">内容为空，还没添加课程</td>
		</tr>
		<!--#
		}
		#-->
	</table>
	<div class="manage-mav  col-md-offset-10">
		{$page_nav}
	</div>
</div>
<!--#}elseif($action=='chapter_section_manage'){#-->
<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading"><img src="images/icon_nav.gif" align="absmiddle" border="0" />章节管理&nbsp;&nbsp;
		<a href="javascript:;" onclick="abox('{#urr("mydisk","item=course&action=add_chapter_section&course_id=$course_id")#}','创建新章节',350,250);"><img src="images/ico_write.png" align="absmiddle" border="0" />创建新章节</a></div>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line table table-striped">
	<tr>
		<td>当前路径：{$nav_path}</td>
		<td colspan="8" align="right"></td>
	</tr>
	<form action="{#urr("mydisk","item=files")#}" name="file_form" method="post" onsubmit="return dosubmit(this);">
	<input type="hidden" name="action" value="op_file" />
	<input type="hidden" name="formhash" value="{$formhash}" />
	<!--#if(count($chapter_section_array)){#-->
	<tr>
		<td width="22%" class="bold">章节／课程名称</td>
		<td width="8%" align="center" class="bold">视频数</td>
		<td width="8%" align="center" class="bold"><?=__('file_downs')?></td>
		<td width="8%" align="center" class="bold">浏览数</td>
		<td width="12%" align="center" class="bold">状态</td>
		<td width="17%" align="center" width="150" class="bold">更新时间</td>
		<td width="13%" align="center" class="bold">
			<?=__('operation')?>
		</td>
	</tr>
	<!--#
    }
    if(count($chapter_section_array)){
        foreach($chapter_section_array as $k => $v){
            $color = ($k%2 ==0) ? 'color1' :'color4';
    #-->
        <!--#if($v['is_cs']){ #-->
        <tr class="">
            <td>
                <!--# echo str_repeat('&nbsp;',$v['level']*2)#-->
                <img src="images/disk.gif" align="absmiddle" border="0" />
                {$v['cs_name']}
                <a href="javascript:;" onclick="abox('{$v[a_add_file]}','添加视频',650,550);"><img src="images/tree/nolines_plus.gif" align="absbottom" border="0" /></a>
            </td>
            <td align="center" class="txtgray">-</td>
            <td align="center" class="txtgray">{$v['download_num']}</td>
            <td align="center" class="txtgray">{$v['view_num']}</td>
            <td align="center" class="txtgray">-</td>
            <td align="center" class="txtgray">{$v['update_date']}</td>
            <td align="center">
                <a href="javascript:;" onclick="abox('{$v[a_edit]}','修改章节',350,250);"><img src="images/ico_write.png" align="absbottom" border="0" /></a>
                <a href="javascript:;" onclick="abox('{$v[a_del]}','删除章节',400,250)"><img src="images/delete_icon.gif" align="absmiddle" border="0" /></a>
            </td>
        </tr>
        <!--#} #-->
        <!--#if($v['is_file']){ #-->
        <tr class="">
            <td>
                <!--# echo str_repeat('&nbsp;',$v['level']*2)#-->
                <img src="images/tree/cd.gif" align="absmiddle" border="0" />
                {$v['file_name']}
            </td>
            <td align="center" class="txtgray">-</td>
            <td align="center" class="txtgray">{$v['file_downs']}</td>
            <td align="center" class="txtgray">{$v['file_views']}</td>
            <td align="center" class="txtgray">{$v['status']}</td>
            <td align="center" class="txtgray">{$v['file_time']}</td>
            <td align="center">
                <a href="javascript:;" onclick="abox('{$v[a_del]}','删除文件',400,250)"><img src="images/delete_icon.gif" align="absmiddle" border="0" /></a>
            </td>
        </tr>
        <!--#} #-->
	<!--#
        }
    }
    #-->
	<!--#
    if(!count($chapter_section_array) ){
    #-->
	<tr>
		<td colspan="6" align="center">内容为空，还没添加章节</td>
	</tr>
	<!--#
    }
    #-->
</table>

</div>
<!--#}elseif($action=='course_review'){#-->
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
    <tr>
        <td colspan="9" class="nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" />课程审核&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td>当前路径：{$nav_path}</td>
        <td colspan="8" align="right">
            <form method="get" action="{#urr("mydisk","")#}" onsubmit="return dosearch(this);">
            <input type="hidden" name="action" value="files" />
            <input type="hidden" name="task" value="search" />
            搜索课程:<input type="text" name="word" value="{$word}"/>
            <input type="submit" class="btn" value="<?=__('search')?>" />
            </form>
            <script type="text/javascript">
                function dosearch(o){
                    if(o.word.value.strtrim()==''){
                        o.word.focus();
                        return false;
                    }
                }
            </script>
        </td>
    </tr>
    <form action="{#urr("mydisk","item=files")#}" name="file_form" method="post" onsubmit="return dosubmit(this);">
    <input type="hidden" name="action" value="op_file" />
    <input type="hidden" name="formhash" value="{$formhash}" />
    <!--#if(count($course_array)){#-->
    <tr>
        <td width="29%" class="bold">课程名称</td>
        <td width="10%" align="center" class="bold">分类</td>
        <td width="8%" align="center" class="bold">视频数</td>
        <td width="8%" align="center" class="bold"><?=__('file_downs')?></td>
        <td width="8%" align="center" class="bold">浏览数</td>
        <td width="17%" align="center" width="150" class="bold">更新时间</td>
        <td width="12%" align="center" class="bold">状态／审核进度</td>
        <td width="13%" align="center" class="bold">
            <?=__('operation')?>
        </td>
    </tr>
    <!--#
    }
    if(count($course_array)){
        foreach($course_array as $k => $v){
            $color = ($k%2 ==0) ? 'color1' :'color4';
    #-->
    <tr class="{$color}">
        <td>
            <img src="images/folder.gif" align="absmiddle" border="0" />
            <a href="{$v['a_course_view']}">{$v['course_name']}</a>
        </td>
        <td align="center" class="txtgray">{$v['cate_name']}</td>
        <td align="center" class="txtgray">{$v['folder_size']}</td>
        <td align="center" class="txtgray">{$v['download_num']}</td>
        <td align="center" class="txtgray">{$v['view_num']}</td>
        <td align="center" class="txtgray">{$v['update_date']}</td>
        <td align="center" class="txtgray">{$v['status']}</td>
        <td align="center">
            <a href="javascript:;" onclick="abox('{$v[a_edit]}','修改课程',350,250);">提交审核</a>
            <a href="javascript:;" onclick="abox('{$v[a_del]}','删除课程',400,250)">取消审核x</a>
        </td>
    </tr>
    <!--#
        }
    }
    #-->
    <!--#
    if(!count($course_array) ){
    #-->
    <tr>
        <td colspan="6" align="center">内容为空，还没添加课程</td>
    </tr>
    <!--#
    }
    #-->
</table>

<!--#}elseif($action=='mod_stat'){#-->
<form action="{#urr("mydisk","item=profile")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('stat_code')?></td>
</tr>
<tr>
	<td class="txtgray"><?=__('stat_code_tips')?></td>
</tr>
<tr>
	<td><textarea name="stat_code" rows="10" cols="80">{$stat_code}</textarea></td>
</tr>
<tr>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<?=__('current_code_status')?><span class="txtred">{$check_txt}</span>&nbsp;&nbsp;<span class="txtgray"><?=__('stat_code_check_tips')?></span></td>
</tr>
</table>
</form>
<!--#}elseif($action=='myannounce'){#-->
<script charset="utf-8" src="editor/kindeditor-min.js"></script>
<script charset="utf-8" src="editor/lang/zh_CN.js"></script>
<script>
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[name="my_announce"]', {
			resizeType : 1,
			allowPreviewEmoticons : false,
			allowImageUpload : false,
			items : [
				'fullscreen','|','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				'insertunorderedlist', '|', 'emoticons', 'image', 'link']
		});
	});
	$(document).ready(function(){
		setTimeout(adjust_edit, 200);
	});
	function adjust_edit(){
		$('.ke-container-default').css('width','100%');
	}
</script>
<form action="{#urr("mydisk","item=profile")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="panel panel-default">
	<div class="panel-heading"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('myannounce')?></div>
		<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line table">
			<tr>
				<td class="txtgray"><?=__('myannounce_tips')?></td>
			</tr>
			<tr>
				<td><textarea name="my_announce" cols="130" rows="28">{$my_announce}</textarea></td>
			</tr>
		</table>
		<div><input type="submit" class="btn btn-default" value="<?=__('btn_submit')?>"/></div>
</div>
</form>
<!--#}elseif($action=='chg_logo'){#-->

<!--#if($auth[open_subdomain] && $settings[open_domain]){#-->
<form action="{#urr("mydisk","item=profile")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="mod_domain"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('user_domain')?></td>
</tr>
<tr>
	<td width="30%"><?=__('domain_title')?>：<br /><span class="txtgray"><?=__('domain_title_tips2')?></span><span class="txtred">{$settings[min_domain_length]}</span></td>
	<td>http://<input type="text" name="domain" value="{$domain}" maxlength="30" />{$settings[suffix_domain]}&nbsp;&nbsp;
	<!--#if($auth[pd_a] && $settings[mod_subdomain]){#-->
	可修改域名量： <span class="f14 txtblue">{#get_profile($pd_uid,'mod_subdomain')#} / {$settings[mod_subdomain]}</span>
	<!--#}#-->
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_modify')?>"/></td>
</tr>
</table>
</form>
<!--#}#-->

<form action="{#urr("mydisk","item=$item")#}" method="post" enctype="multipart/form-data" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('mylogo')?></td>
</tr>
<tr>
	<td colspan="2" class="txtgray"><?=__('mylogo_tips')?></td>
</tr>
<tr>
	<td><?=__('curr_logo')?>：</td>
	<td><img src="{$logo}" align="absmiddle" border="0" /></td>
</tr>
<tr>
	<td width="30%"><?=__('select_image')?>：</td>
	<td><input type="file" name="filedata" size="35"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>

<form action="{#urr("mydisk","item=$item")#}" method="post" onsubmit="return dosubmit2(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="chg_url" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('logo_link')?></td>
</tr>

<tr>
	<td width="30%"><?=__('logo_link')?>：<br /><span class="txtgray"><?=__('logo_link_tips')?></span></td>
	<td><input type="text" name="logo_url" value="{$logo_url}" size="35" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
<script type="text/javascript">
function dosubmit(o){
	var patn = /\.jpg$|\.png$|\.gif$/i;
    if(patn.test(o.filedata.value)){
        return true;
    }else{
        alert("<?=__('js_mylogo_tips')?>");
		return false;
    }
}
function dosubmit2(o){
	if(o.logo_url.value.strtrim() ==''){
		o.logo_url.focus();
        alert("<?=__('mylogo_addr_not_null')?>");
		return false;
	}
}
</script>
<form action="{#urr("mydisk","item=profile")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="mod_pro"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('mydisk_info')?></td>
</tr>
<tr>
	<td width="30%"><?=__('mydisk_title')?>：</td>
	<td><input type="text" name="space_name" value="{$space_name}" size="35" maxlength="30" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_modify')?>"/></td>
</tr>
</table>
</form>
<!--#if($auth[space_pwd]){#-->
<form action="{#urr("mydisk","item=profile")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="space_pwd"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('space_pwd_info')?></td>
</tr>
<tr>
	<td width="30%"><?=__('visit_password')?>：</td>
	<td><input type="text" name="space_pwd" value="{$space_pwd}" size="35" maxlength="30" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
<!--#}#-->

<!--#}elseif($action=='application_teacher'){#-->
<!--#if($task=='application_progress'){#-->
<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading"><img src="images/icon_nav.gif" align="absmiddle" border="0" />审批进度</div>
		<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line table">
			<tbody>
			<tr>
				<td>进度div</td>
			</tr>
			<tr>
				<td>申请结果信息：{$application_log}，申请结果代码：{$application_num}。 </td>
			</tr>
			<!--#if($application_num!=3){#-->
			<tr>
				<td><a href="mydisk.php?item=profile&action=application_teacher&task=application_cancel" class="btn btn-danger"
					   onclick="return confirm('确定要取消你的教师申请吗？取消后无法恢复')">取消申请</a></td>
			</tr>
			<!--#}#-->
			</tbody>
		</table>
	</div>
<script type="text/javascript">

</script>
<!--#}else{#-->
<script type="text/javascript" src="includes/js/dmuploader.min.js"></script>
<form action="{#urr("mydisk","item=profile")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="application_add"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading"><img src="images/icon_nav.gif" align="absmiddle" border="0" />申请教师</div>
	<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line table">
	<tbody>
		<tr>
			<td width="30%">姓名</td>
			<td>
				<div class=""><input type="text" name="user_name"/></div>
			</td>
		</tr>
		<tr>
			<td width="30%">性别</td>
			<td>
				<div class="">
					<label><input type="radio" name="sex" value="1"/>男</label>
					<label><input type="radio" name="sex" value="2"/>女</label>
				</div>
			</td>
		</tr>
		<tr>
			<td width="30%">年龄</td>
			<td>
				<div class=""><input type="text" name="age"/></div>
			</td>
		</tr>
		<tr>
			<td width="30%">个人介绍</td>
			<td>
				<div class=""><textarea type="text" name="introduce"></textarea></div>
			</td>
		</tr>
		<tr>
			<td width="30%">学历证明：</td>
			<td>
				<div id="education_prove" class="uploader">
					<div class="browser">
						<label>
							<input type="file" name="" title='请选择证明的材料上传'>
							<input type="hidden" name="education" value="">
						</label>
					</div>
				</div>
			</td>
		</tr>
		<tr id="education_file_info" style="display: none">
			<td width="30%"></td>
			<td>
				<div class="info"></div>
				<div class="progress"><div></div></div>
			</td>
		</tr>
		<tr>
			<td width="30%">工作证明：</td>
			<td>
				<div id="job_prove" class="uploader">
					<div class="browser">
						<label>
							<input type="file" name="" title='请选择证明的材料上传'>
							<input type="hidden" name="job" value="">
						</label>
					</div>
				</div>
			</td>
		</tr>
		<tr id="job_file_info" style="display: none">
			<td width="30%"></td>
			<td>
				<div class="info"></div>
				<div class="progress"><div></div></div>
			</td>
		</tr>
		<tr>
			<td width="30%">教师资格证明：</td>
			<td>
				<div id="teacher_prove" class="uploader">
					<div class="browser">
						<label>
							<input type="file" name="" title='请选择证明的材料上传'>
							<input type="hidden" name="teacher" value="">
						</label>
					</div>
				</div>
			</td>
		</tr>
		<tr id="teacher_file_info" style="display: none">
			<td width="30%"></td>
			<td>
				<div class="info"></div>
				<div class="progress"><div></div></div>
			</td>
		</tr>
		<tr>
			<td width="30%"></td>
			<td><input type="submit" value="提交申请" class="btn"/></td>
		</tr>
	</tbody>
</table>
</div>
</form>

<style>
	.progress{
		border:solid 1px #C0C0C0;
		height:12px;
		margin-top:5px;
		padding:1px;
		width:290px;
	}
	.progress div{
		width:0%;
		height:12px;
		background-color: #00CCFF;
	}
</style>
<script type="text/javascript">
	url_upload = 'mydisk.php?item=profile&action=application_teacher&task=save_image';
	function update_file_progress(classdiv, percent)
	{
		$('#' + classdiv).find('div.progress div').width(percent);
	}
	function update_file_status(classdiv, message)
	{
		$('#' + classdiv).find('div.info').html(message);
	}
	// 学历证明上传js
	$('#education_prove').dmUploader({
		url: url_upload,
		dataType: 'json',
		allowedTypes: 'image/*',
		/*extFilter: 'jpg;png;gif',*/
		onBeforeUpload: function(id){
			$('#education_file_info').css('display','');
		},
		onUploadProgress: function(id, percent){
			var percentStr = percent + '%';
			update_file_progress("education_file_info", percentStr);
		},
		onUploadSuccess: function(id, data){
			update_file_progress("education_file_info", '100%');
			update_file_status("education_file_info", "上传完成");
			$('input[name="education"]').val(data.data.filename);
		},
		onUploadError: function(id, message){
			update_file_status("education_file_info", "上传错误");
		},
		onFileTypeError: function(file){
			update_file_status("education_file_info", "文件类型错误");
		},
		onFileSizeError: function(file){
			update_file_status("education_file_info", "文件大小错误");
		}
	});
	// 工作证明上传js
	$('#job_prove').dmUploader({
		url: url_upload,
		dataType: 'json',
		allowedTypes: 'image/*',
		/*extFilter: 'jpg;png;gif',*/
		onBeforeUpload: function(id){
			$('#job_file_info').css('display','');
		},
		onUploadProgress: function(id, percent){
			var percentStr = percent + '%';
			update_file_progress("job_file_info", percentStr);
		},
		onUploadSuccess: function(id, data){
			update_file_progress("job_file_info", '100%');
			update_file_status("job_file_info", "上传完成");
			$('input[name="job"]').val(data.data.filename);
		},
		onUploadError: function(id, message){
			update_file_status("job_file_info", "上传错误");
		},
		onFileTypeError: function(file){
			update_file_status("job_file_info", "文件类型错误");
		},
		onFileSizeError: function(file){
			update_file_status("job_file_info", "文件大小错误");
		}
	});
	// 学历证明上传js
	$('#teacher_prove').dmUploader({
		url: url_upload,
		dataType: 'json',
		allowedTypes: 'image/*',
		/*extFilter: 'jpg;png;gif',*/
		onBeforeUpload: function(id){
			$('#teacher_file_info').css('display','');
		},
		onUploadProgress: function(id, percent){
			var percentStr = percent + '%';
			update_file_progress("teacher_file_info", percentStr);
		},
		onUploadSuccess: function(id, data){
			update_file_progress("teacher_file_info", '100%');
			update_file_status("teacher_file_info", "上传完成");
			$('input[name="teacher"]').val(data.data.filename);
		},
		onUploadError: function(id, message){
			update_file_status("teacher_file_info", "上传错误");
		},
		onFileTypeError: function(file){
			update_file_status("teacher_file_info", "文件类型错误");
		},
		onFileSizeError: function(file){
			update_file_status("teacher_file_info", "文件大小错误");
		}
	});
</script>
<!--#}#-->

<!--#}elseif($action=='invite'){#-->
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('invite_user')?></td>
</tr>
<tr>
	<td colspan="2"><?=__('invite_link')?>：<input type="text" size="70" id="invite_url" value="{$invite_url}" readonly onclick="getId('invite_url').select();copy_text('invite_url');"/><input type="button" value="<?=__('copy_link')?>" onclick="getId('invite_url').select();copy_text('invite_url');" class="btn"/></td>
</tr>
<tr>
	<td colspan="2"><?=__('downline_income')?>：<b>{$curr_downline_rate}</b> &nbsp;&nbsp;<?=__('my_invite_user')?>：<b>{$my_downlines}</b></td>
</tr>
<tr>
	<td width="15%"><?=__('my_income')?>： </td>
	<td><?=__('my_credit')?>：<b class="f14">{#get_discount($pd_uid,get_profile($pd_uid,'credit'))#}</b> , <?=__('downline_credit')?>：<b class="f14">{$myinfo['dl_credit']}</b>&nbsp;&nbsp;</td>
</tr>
</table>
<!--#}elseif($action=='income'){#-->
	<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
	<tr>
		<td colspan="2" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('to_income')?>：</td>
	</tr>
	<tr>
		<td width="30%"><?=__('my_income')?>： </td>
		<td><?=__('my_credit')?>：<b class="f14">{#get_discount($pd_uid,$myinfo['credit'])#}</b> , <?=__('downline_credit')?>：<b class="f14">{$myinfo['dl_credit']}</b>&nbsp;&nbsp;
		</td>
	</tr>
	<tr>
		<td><?=__('downline_income')?>： </td>
		<td><?=__('downline_rate')?>：<b>{$curr_downline_rate}</b> &nbsp;&nbsp;<?=__('my_downline_user')?>：<b>{$my_downlines}</b></td>
	</tr>
	<tr>
		<td colspan="2">
<div id="container">
<div class="box_style">
<div class="line">
<fieldset><legend><?=__('exchange_money')?></legend>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="txtgray f14"><?=__('exchange_money_tips')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><?=__('now_money')?>：<b class="f14 txtred">￥{$myinfo['wealth']}</b>&nbsp;&nbsp;<?=__('donwline_rate')?>：<b>{$curr_downline_rate}</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><?=__('my_credit')?>：<b class="f14">{#get_discount($pd_uid,$myinfo['credit'])#}</b> , <?=__('downline_credit')?>：<b class="f14">{$myinfo['dl_credit']}</b>
	<!--#if($curr_credit_rate){#-->
	 , <?=__('exchange_rate')?>：<b class="f14 txtblue">{$curr_credit_rate}</b>
	<input type="button" class="btn" id="chg_btn" value="<?=__('exchange_credit')?>" onclick="conv_credit('credit');" />
	<!--#}else{#-->
	, <span class="txtred"><?=__('rate_not_set')?></span>
	<!--#}#-->
	</td>
</tr>
</table>
</fieldset>
</div>
</div>
</div>
	</td>
	</tr>
	</table>
<form action="{#urr("mydisk","item=$item")#}" name="file_form" method="post" onsubmit="return doincome(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="to_income" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
	<tr>
		<td colspan="2" class="f14" style="background:#EBF0F3"><?=__('to_income')?></td>
	</tr>
	<tr>
		<td><?=__('now_money')?>： </td>
		<td><b>￥{$wealth}</b> {$freeze_money}</td>
	</tr>
	<tr>
		<td><?=__('account_name')?>： </td>
		<td><input type="text" name="income_name" value="{$income_name}" readonly /> <span class="txtgray"><?=__('account_type')?>：{#$income_type_arr[$income_type]#}</span></td>

	</tr>
	<tr>
		<td><?=__('income_account')?>： </td>
		<td><input type="text" name="income_account" value="{$income_account}" readonly /> <a href="{#urr("mydisk","item=profile&action=income_set")#}"><?=__('account_set')?></a></td>
	</tr>
	<tr>
		<td><?=__('input_money')?>：</td>
		<td><input type="text" name="money" value="" /></td>
	</tr>
	<tr>
		<td>提现密码：</td>
		<td><input type="password" name="income_pwd" value="" /> <!--#if($same_pwd){#--><br /><span class="txtred">安全提示：您的提现密码与登录密码相同，为保障您的资金安全，请及时<a href="{#urr("mydisk","item=profile&action=mod_pwd")#}">修改提现密码</a>.</span><!--#}#--></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" class="btn" value="<?=__('app_income')?>" />&nbsp;&nbsp;<span class="txtred"><?=__('min_to_income')?> ￥{$settings['min_to_income']}</span></td>
	</tr>
	</table>
</form>
<script type="text/javascript">
function doincome(o){
	if(o.money.value ==''){
		alert('<?=__('pls_input_income_money')?>');
		o.money.focus();
		return false;
	}
	if(o.income_pwd.value ==''){
		alert('提现密码不能为空');
		o.income_pwd.focus();
		return false;
	}
	if(o.income_account.value=='' || o.incomde_name.value ==''){
		alert('<?=__('pls_set_account')?>');
		return false;
	}

}
function conv_credit(credit_type){
	getId('chg_btn').disabled = true;
	$.ajax({
		type : 'post',
		url : 'ajax.php',
		data : 'action=conv_credit&credit_type='+credit_type+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			if(msg == 'true'){
				alert('<?=__('credit_exchange_success')?>');
				document.location.reload();
			}else{
				alert(msg);
			}
			getId('chg_btn').disabled = false;
		},
		error:function(){
		}

	});
}
<!--#if(!get_profile($pd_uid,'credit') && !get_profile($pd_uid,'dl_credit')){#-->
getId('chg_btn').disabled = true;
<!--#}#-->
</script>
<!--#}elseif($action=='income_log'){#-->

<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="4" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('income_log')?></td>
</tr>

<!--#
if(count($orders)){
#-->
<tr>
	<td width="200" class="bold"><?=__('order_number')?></td>
	<td class="bold"><?=__('income_money')?></td>
	<td class="bold"><?=__('income_date')?></td>
	<td align="right" class="bold" width="10%"><?=__('income_status')?></td>
</tr>
<!--#
	foreach($orders as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td>{$v['order_number']}</td>
	<td>￥{$v['money']}</td>
	<td class="txtgray">{$v['in_time']}</td>
	<td align="right">{$v['o_status']}</td>
</tr>
<!--#
	}
	unset($orders);
#-->
<tr>
	<td style="border-bottom:none;" colspan="6">{$page_nav}</td>
</tr>
<!--#
}else{
#-->
<tr>
	<td colspan="6" align="center"><?=__('income_log_not_found')?></td>
</tr>
<!--#
}
#-->
</table>
<!--#}elseif($action=='credit_log'){#-->

<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="4" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('credit_log')?></td>
</tr>

<!--#
if(count($orders)){
#-->
<tr>
	<td width="50%" class="bold"><?=__('income_file')?></td>
	<td class="bold"><?=__('credit_action')?></td>
	<td class="bold" align="center"><?=__('credit')?></td>
	<td class="bold" width="150" align="right"><?=__('intime')?></td>
</tr>
<!--#
	foreach($orders as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td><a href="{$settings[phpdisk_url]}{#urr("viewfile","file_id=$v[file_id]")#}" target="_blank">{#file_icon($v[file_extension])#}{$v[file_name]}</a></td>
	<td>{$v['action']}</td>
	<td class="txtgreen" align="center">{$v['credit']}</td>
	<td class="txtgray" align="right">{$v['in_time']}</td>
</tr>
<!--#
	}
	unset($orders);
#-->
<tr>
	<td style="border-bottom:none;" colspan="6">{$page_nav}</td>
</tr>
<!--#
}else{
#-->
<tr>
	<td colspan="6" align="center"><?=__('credit_log_not_found')?></td>
</tr>
<!--#
}
#-->
</table>
<!--#}elseif($action=='income_plans'){#-->
<form action="{#urr("mydisk","item=profile")#}" method="post" onSubmit="return chkform(this);">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="5" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('income_plans')?></td>
</tr>
<!--#
if(count($plans)){
#-->
<tr>
	<td class="bold" width="15%"><?=__('plans_subject')?></td>
	<td class="bold" width="40%"><?=__('plans_content')?></td>
	<td class="bold" width="150"><?=__('plans_rate')?></td>
	<!--#if($auth[open_plan_active] && $settings[open_plan_active]){#-->
	<td class="bold"><?=__('plans_down_active_num')?></td>
	<!--#}else{#-->
	<td class="bold"><?=__('plans_memo')?></td>
	<!--#}#-->
	</tr>
<!--#
	foreach($plans as $k => $v){
#-->
<tr
<!--#if(!($auth[open_plan_active] && $settings[open_plan_active])){#-->onclick="hl_plan({$k},{#count($plans)#});"<!--#}#--> style="cursor:pointer" id="tr_{$k}"
<!--#if($v[plan_id]==get_profile($pd_uid,'plan_id')){#-->class="color4 txtblue"<!--#}#-->>
	<td>
	<!--#if(get_profile($pd_uid,'open_plan') && !$settings[open_plan_active]){#-->
	<input type="radio" name="plan_id" value="{$v[plan_id]}" {#ifchecked($v[plan_id],get_profile($pd_uid,'plan_id'))#} id="p_sel_{$k}" />
	<!--#}#-->
	{$v['subject']}</td>
	<td>{$v['content']}&nbsp;</td>
	<td>{$v['plans_rate']}</td>
	<!--#if($auth[open_plan_active] && $settings[open_plan_active]){#-->
	<td>{$v[down_active_num_min]} <= <?=__('file_downs_num')?> < {$v[down_active_num_max]}</td>
	<!--#}else{#-->
	<td>{$v['memo']}&nbsp;</td>
	<!--#}#-->
</tr>
<!--#
	}
	unset($plans);
}else{
#-->
<tr>
	<td colspan="7" align="center"><?=__('plans_not_found')?></td>
</tr>
<!--#
}
#-->
<!--#if(!($auth[open_plan_active] && $settings[open_plan_active])){#-->
<tr>
	<td>&nbsp;</td>
	<td>
	<!--#if(get_profile($pd_uid,'open_plan')){#-->
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/>
	<a href="{#urr("mydisk","item=profile&action=income_plans&task=close_plan")#}" onclick="return confirm('<?=__('confirm_close_plan')?>');"><span class="txtred f14">【<?=__('close_plan')?>】</span></a>

	<!--#}else{#-->
	<a href="{#urr("mydisk","item=profile&action=income_plans&task=open_plan")#}" onclick="return confirm('<?=__('confirm_open_plan')?>');"><span class="txtblue f14">【<?=__('open_plan')?>】</span></a>
	<!--#}#-->
	</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<!--#}#-->
</table>
</form>
<script type="text/javascript">
function hl_plan(id,count){
	for(var i=0;i<count;i++){
		getId('tr_'+i).className='';
		getId('p_sel_'+i).checked = false;
	}
	getId('tr_'+id).className='color4 txtblue';
	getId('p_sel_'+id).checked = true;
}
</script>
<!--#}elseif($action=='mod_pwd'){#-->
<form action="{#urr("mydisk","item=profile")#}" method="post" onSubmit="return chkform(this);">
<input type="hidden" name="action" value="mod_pwd"/>
<input type="hidden" name="task" value="mod_pwd"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="panel panel-default">
	<div class="panel-heading"><img src="images/icon_nav.gif" align="absmiddle" border="0" />修改登录密码</div>
	<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line table">
		<tr>
			<td width="30%" align="right">当前登录密码: </td>
			<td><input type="password" name="old_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
		</tr>
		<tr>
			<td align="right"><?=__('new_password')?>: </td>
			<td><input type="password" name="new_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
		</tr>
		<tr>
			<td align="right"><?=__('confirm_password')?>: </td>
			<td><input type="password" name="cfm_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" class="btn btn-danger" value="<?=__('btn_modify')?>"/></td>
		</tr>
	</table>
</div>
</form>
<!--#if($pd_gid==5 || $pd_gid==1){#-->
<form action="{#urr("mydisk","item=profile")#}" method="post" onSubmit="return chkform2(this); class="form-horizontal"">
<input type="hidden" name="action" value="mod_pwd"/>
<input type="hidden" name="task" value="mod_pwd2"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="panel panel-default">
	<div class="panel-heading"><img src="images/icon_nav.gif" align="absmiddle" border="0" />修改教师密码</div>
	<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line table">
		<tr>
			<td width="30%" align="right">当前教师密码: </td>
			<td><input type="password" name="old_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
		</tr>
		<tr>
			<td align="right"><?=__('new_password')?>: </td>
			<td><input type="password" name="new_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
		</tr>
		<tr>
			<td align="right"><?=__('confirm_password')?>: </td>
			<td><input type="password" name="cfm_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" class="btn btn-danger" value="<?=__('btn_modify')?>"/></td>
		</tr>
	</table>
</div>
</form>
<!--#}#-->
</div>
</div>
<script language="javascript">
function chkform(o){
	if(o.old_pwd.value.strtrim().length <6){
		alert("当前登录密码不正确");
		o.old_pwd.focus();
		return false;
	}
	if(o.new_pwd.value.strtrim().length <6){
		alert("<?=__('password_too_short')?>");
		o.new_pwd.focus();
		return false;
	}
	if(o.new_pwd.value != o.cfm_pwd.value){
		alert("确认登录密码不正确");
		o.cfm_pwd.focus();
		return false;
	}
}
function chkform2(o){
	if(o.old_pwd.value.strtrim().length <6){
		alert("当前提现密码不正确");
		o.old_pwd.focus();
		return false;
	}
	if(o.new_pwd.value.strtrim().length <6){
		alert("提现密码过短");
		o.new_pwd.focus();
		return false;
	}
	if(o.new_pwd.value != o.cfm_pwd.value){
		alert("确认提现密码不正确");
		o.cfm_pwd.focus();
		return false;
	}
}
</script>
<!--#}elseif($action=='income_set'){#-->
<form action="{#urr("mydisk","item=profile")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('income_set')?></td>
</tr>
<tr>
	<td align="right" width="20%"><?=__('account_type')?>：</td>
	<td width="100%"><input type="radio" name="income_type" value="alipay" id="a1" {#ifchecked('alipay',$income_type,'str')#} /><label for="a1"><?=__('alipay')?></label>
	<input type="radio" name="income_type" value="tenpay" id="a2" {#ifchecked('tenpay',$income_type,'str')#} /><label for="a2"><?=__('tenpay')?></label> </td>
</tr>
<tr>
	<td align="right"><?=__('account_name')?>：</td>
	<td><input type="text" name="income_name" value="{$income_name}" size="30" maxlength="50" /></td>
</tr>
<tr>
	<td align="right"><?=__('income_account')?>：</td>
	<td><input type="text" name="income_account" value="{$income_account}" size="30" maxlength="50" /> </td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_modify')?>"/></td>
</tr>
</table>
</form>
<!--#}elseif($action=='multi_upload'){#-->
<!--#if($settings['yun_store']){#-->
<link rel="stylesheet" type="text/css" href="http://yun.google.com/api/yunapi.css">
<script type="text/javascript">var my_folder_list='<select id="my_folder_id" style="padding:6px 3px;"><option value="0"><?=__('root_folder_default')?></option><!--#echo str_replace(array("\r","\n"),'',get_folder_option(0));#--></select>';</script>
<script type="text/javascript" src="http://yun.google.com/api/yunjs.php?v={#rawurlencode(PHPDISK_VERSION)#}&c=zcore&unid={$settings[yun_site_key]}&yun_store={$settings['yun_store']}"></script>
<!--#}#-->
<div class="panel panel-default">
	<div class="panel-heading"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('multi_upload')?></div>
		<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line table">
			<!--#if($settings['yun_store']){#-->
			<tr>
				<td colspan="2" class="txtgray"><?=__('multi_upload_tips')?></td>
			</tr>
			<tr>
				<td width="100%" colspan="2" valign="top">
					<input type="button" class="btn" value="文件上传" onclick="get_yun_site();" style="cursor:pointer" />
					<script type="text/javascript">get_yun_site();</script>
				</td>
			</tr>
			<!--#}else{#-->
			<tr>
				<td colspan="2" class="txtgray"><?=__('multi_upload_tips')?></td>
			</tr>
			<tr>
				<td width="600" colspan="2" valign="top">
					<iframe scrolling="no" src="{$upload_url}" width="500" height="350" frameborder="0"></iframe>
				</td>
			</tr>
			<!--#}#-->
		</table>
</div>

<!--#}elseif($action =='forum_upload'){#-->
<form action="{#urr("mydisk","item=profile")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="forum_upload_min"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('forum_upload')?></td>
</tr>
<tr>
	<td colspan="2" class="txtgray"><?=__('forum_upload_tips')?></td>
</tr>
<tr>
	<td colspan="2" class="f14"><?=__('plugin_code1')?></td>
</tr>
<tr>
	<td width="30%"><?=__('store_folder')?>：</td>
	<td><select name="folder_id">
	{#get_folder_option(0);#}
	</select></td>
</tr>
<tr>
	<td><?=__('bbs_type')?>：</td>
	<td><select name="plugin_type">
	<option value="dx2" {#ifselected('dx2',$plugin_type,'str')#}>DiscuzX v2.0 v2.5</option>
	<option value="pw87" {#ifselected('pw87',$plugin_type,'str')#}>PHPWind v8.7 v8.5</option>
	</select></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_make_code')?>"/></td>
</tr>
<!--#if($task =='forum_upload_min'){#-->
<tr>
	<td><?=__('add_code_is')?></td>
	<td><textarea cols="80" rows="10" id="ta_code" readonly="readonly" onclick="getId('ta_code').select();copy_text('ta_code');">{$code}</textarea><input type="button" class="btn" value="<?=__('copy_code')?>" onclick="getId('ta_code').select();copy_text('ta_code');" /></td>
</tr>
<!--#}#-->
</table>
</form>

<form action="{#urr("mydisk","item=profile")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="forum_upload_super"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14"><?=__('plugin_code2')?></td>
</tr>
<tr>
	<td width="30%"><?=__('store_folder')?>：</td>
	<td><select name="folder_id">
	{#get_folder_option(0);#}
	</select></td>
</tr>
<tr>
	<td><?=__('bbs_type')?>：</td>
	<td><select name="plugin_type">
	<option value="dx2" {#ifselected('dx2',$plugin_type,'str')#}>DiscuzX v2.0 v2.5</option>
	<option value="pw87" {#ifselected('pw87',$plugin_type,'str')#}>PHPWind v8.7 v8.5</option>
	</select></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_make_code')?>"/>&nbsp;&nbsp;&nbsp;&nbsp;<a href="plugins/phpdisk_plugin.zip" class="txtred"><?=__('phpdisk_plugin_download_install')?></a></td>
</tr>
<!--#if($task =='forum_upload_super'){#-->
<tr>
	<td><?=__('add_code_is')?></td>
	<td><textarea cols="80" rows="10" id="ta_code2" readonly="readonly" onclick="getId('ta_code2').select();copy_text('ta_code2');">{$code}</textarea><input type="button" class="btn" value="<?=__('copy_code')?>" onclick="getId('ta_code2').select();copy_text('ta_code2');" /></td>
</tr>
<!--#}#-->
</table>
</form>
<!--#}elseif($action=='outlink'){#-->
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('file_outlink')?></td>
</tr>
<tr>
	<td colspan="2" class="txtgray"><?=__('file_outlink_tips')?></td>
</tr>
<tr>
	<td><div id="container">
<div><?=__('outlink_mode')?>: <a href="javascript:void(0);" onclick="get_mode('ubb');">[UBB]</a> - <a href="javascript:void(0);" onclick="get_mode('html');">[HTML]</a> - <a href="javascript:void(0);" onclick="get_mode('url');">[URL]</a></div>
<textarea id="link_area" readonly="readonly" style="width:98%; height:250px"></textarea><br />
<input type="button" class="btn" value="<?=__('copy_outlink')?>" onclick="getId('link_area').select();copy_text('link_area');" />
</div></td>
</tr>
</table>
<script language="javascript">
document.title='<?=__('file_outlink')?>';
var upl_array = new Array();
<!--#
if(count($upl_array)){
	foreach($upl_array as $k => $v){
#-->
upl_array[{$k}] = {"file_name":"{$v['file_name_all']}","file_link":"{$v['file_link']}","file_link_img":"{$v['file_link_img']}"};
<!--#
	}
	unset($upl_array);
}
#-->
function get_mode(type){
	var str = '';
	for(var i=0;i<upl_array.length;i++){
		var file = upl_array[i];
		switch(type){
			case 'ubb':
				var line = '[url=' + file['file_link'] + ']'+file['file_name']+'[/url]';
			break;
			case 'html':
				var line = '<a href="' + file['file_link'] + '" target="_blank">'+file['file_name']+'</a>';
			break;
			case 'url':
				var line = file['file_link'];
			break;
		}
		str += line + "\n";
	}
	if(document.all){
		getId('link_area').innerText = str;
	}else{
		getId('link_area').innerHTML = str;
	}
}
get_mode('ubb');
</script>
<!--#}elseif($action=='dl_users' || $action=='dl_users2'){#-->
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="7" class="f14 nav_tit"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('my_dl_users')?></td>
</tr>
<!--#if($auth[open_downline2]){#-->
<tr>
	<td class="f14" colspan="3"><a href="{#urr("mydisk","item=profile&action=dl_users")#}">下线用户</a>&nbsp;&nbsp;<a href="{#urr("mydisk","item=profile&action=dl_users2")#}">二级下线用户</a></td>
</tr>
<!--#}#-->
<!--#
if(count($buddys)){
#-->
<tr>
	<td class="bold" width="50%"><?=__('username')?></td>
	<td class="bold" align="center">下线来源</td>
	<td class="bold" align="center" width="18%"><?=__('curr_credit')?></td>
</tr>
<!--#
	foreach($buddys as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td><a href="{$v[a_space]}" target="_blank">{$v[username]}</a> {$v[qq]}</td>
	<td align="center">{$v[is_system]}</td>
	<td align="center">{$v[credit]}</td>
</tr>
<!--#
	}
	unset($buddys);
#-->
<tr>
	<td colspan="7">{$page_nav}</td>
</tr>
<!--#
}else{
#-->
<tr>
	<td colspan="7" align="center"><?=__('downline_users_not_found')?></td>
</tr>
<!--#
}
#-->
</table>
<!--#}elseif($action=='guest' && menu_guest_reg()){#-->
<div id="container">
<div class="box_style">
<!--#if($can_edit){#-->
<form action="{#urr("mydisk","item=$item")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('username')?>:</li>
<li><input type="text" name="username" maxlength="50" size="30"/>&nbsp;<span class="txtred">*</span></li>
<li><?=__('new_password')?>: </li>
<li><input type="password" name="password" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></li>
<li><?=__('confirm_password')?>: </li>
<li><input type="password" name="confirm_password" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></li>
<li><?=__('contact_qq')?>: </li>
<li><input type="text" name="email" maxlength="50" size="30"/>&nbsp;<span class="txtred">*</span></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
</form>
<!--#}else{#-->
<li class="txtred" style="margin-top:50px;"><img src="images/light.gif" align="absmiddle" border="0" /><?=__('no_power_to_edit')?></li>
<!--#}#-->
</div>
</div>
<!--#}else{#-->

<div class="panel panel-default">
	<div class="panel-heading"><img src="images/icon_nav.gif" align="absmiddle" border="0" /><?=__('my_info')?></div>
		<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line table">
			<tr>
				<td valign="top" width="50%">
					<table width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
						<tr>
							<td width="30%"><?=__('username')?>：</td>
							<td>{$pd_username}{#get_vip_icon()#}</td>
						</tr>
						<!--#if($settings[open_vip] && ($auth[buy_vip_a]|| $auth[buy_vip_p])){#-->
						<tr>
							<td><?=__('vip_end_time')?>：</td>
							<td>{$vip_end_time_txt}&nbsp;&nbsp;<a href="{#urr("vip","")#}"><?=__('buy_or_renew_vip')?></a></td>
						</tr>
						<!--#}#-->
						<!--#if(is_vip($pd_uid) && $auth[open_downline2]){#-->
						<tr>
							<td>系统指定下线数量：</td>
							<td>{$downline_num} / {#get_vip(get_profile($pd_uid,'vip_id'),'downline_num')#}</td>
						</tr>
						<!--#}#-->
						<tr>
							<td><?=__('contact_qq')?>：</td>
							<td>{$pd_email}</td>
						</tr>
						<tr>
							<td>我的QQ：</td>
							<td>{$myinfo[qq]}</td>
						</tr>
						<tr>
							<td><?=__('income_item')?>：</td>
							<td><?=__('now_money')?>：<b class="f14 txtred">￥{$myinfo['wealth']}</b>&nbsp;&nbsp;<a href="{#urr("mydisk","item=profile&action=income")#}">【<?=__('app_income')?>】</a>&nbsp;&nbsp;</td>
						</tr>
						<tbody id="cb">
						<tr>
							<td>&nbsp;</td>
							<td><?=__('my_credit')?>：<b class="f14">
									<!--#if($auth[view_credit]){#-->
									{#get_discount($pd_uid,$myinfo['credit'],'asc',1)#}
									<!--#}else{#-->
									{#get_discount($pd_uid,$myinfo['credit'],'asc')#}
									<!--#}#-->
								</b> , <?=__('downline_credit')?>：<b class="f14">{$myinfo['dl_credit']}</b>  , <!--#if($auth[open_downline2]){#-->二级下线积分：<b class="f14">{$myinfo['dl_credit2']}</b><!--#}#--> </td>
						</tr>
						<tr>
							<td style="border-bottom:none;">&nbsp;</td>
							<td style="border-bottom:none;"><?=__('today_credit')?>：<b class="f14">{#get_discount($pd_uid,$today_credit)#}</b> , <?=__('yesterday_credit')?>：<b class="f14">{#get_discount($pd_uid,$yesterday_credit)#}</b> </td>
						</tr>
						</tbody>
					</table></td>
					<td valign="top" style="border-left:1px #CCCCCC solid;">
						<table width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
							<tr>
								<td colspan="2" class="f14"><img src="images/ann_icon.gif" align="absmiddle" border="0" />网站公告</td>
							</tr>
							<!--#show_announces()#-->
						</table>
					</td>
			</tr>
		</table>
</div>


<!--#}#-->
<script type="text/javascript">
	var menu = $(getId('n_{$action}'));
	var classvalue = menu.prop('class');
	menu.prop('class',classvalue+' active');
</script>
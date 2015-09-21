<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: admincp.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<script type=text/javascript>
function expand_menu(){
	if(getId('admincp_left_frame').style.display =='none'){
		getId('admincp_left_frame').style.display = '';
		getId('menu_img').src = "{$admin_tpl_dir}images/menu_left.gif";
		setCookie('admincp_left_frame_status',1,30);
		getId('menu_img').alt = "<?=__('close_menu')?>";
	}else{
		getId('admincp_left_frame').style.display = 'none';
		getId('menu_img').src = "{$admin_tpl_dir}images/menu_right.gif";
		setCookie('admincp_left_frame_status',0,30);
		getId('menu_img').alt = "<?=__('open_menu')?>";
	}
}
</script>
<div class="admin_header">
	<div class="admin_nav">
	<div class="logo"><a href="{#urr(ADMINCP,"item=main")#}"><img src="{$admin_tpl_dir}images/logo_cp.gif" align="absmiddle" border="0" alt="PHPDisk网盘系统 后台管理面板" /></a></div>
	<div class="menu">
  	    <ul>
		  <li id="my_settings"><a href="{#urr(ADMINCP,"item=main&menu=base")#}"><?=__('menu_site_setting')?></a></li>
		  <li id="my_users"><a href="{#urr(ADMINCP,"item=users&menu=user&action=index")#}"><?=__('menu_user_setting')?></a></li>
		  <li id="my_files"><a href="{#urr(ADMINCP,"item=files&menu=file&action=index")#}"><?=__('menu_files_manage')?></a></li>
		  <!--#if(super_admin()){#-->
		  <li id="my_plugins"><a href="{#urr(ADMINCP,"item=plugins&menu=plugin")#}"><?=__('menu_plugins_manage')?></a></li>
		  <!--#}#-->
		  <li id="my_templates"><a href="{#urr(ADMINCP,"item=templates&menu=lang_tpl")#}"><?=__('menu_template_language')?></a></li>
		  <li id="my_advertisement"><a href="{#urr(ADMINCP,"item=advertisement&menu=extend")#}"><?=__('menu_extend_tools')?></a></li>
		  <!--#if(super_admin()){#-->
		  <li id="my_database"><a href="{#urr(ADMINCP,"item=database&menu=tool&action=optimize")#}"><?=__('menu_system_tools')?></a></li>
		  <!--#}#-->
        </ul>
      </div>
	<div id="sitemap">
	<?=__('current_admin')?>: <span class="txtred">{$pd_username}</span>[<!--#if(super_admin()){#--><?=__('super_admin')?><!--#}else{#--><?=__('common_admin')?><!--#}#-->]&nbsp;
	<a href="javascript:;" onclick="open_box('{#remote_server_url();#}',400,200);"><?=__('update_remote_config')?></a>&nbsp;
	<!--#if(super_admin()){#-->
	<a href="{#urr(ADMINCP,"item=sitemap")#}" title="<?=__('sitemap_tips')?>">【SiteMap】</a>&nbsp;&nbsp;
	<!--#}#--></div>
</div>
</div>
<script type="text/javascript">
<!--#if(in_array($item,array('main','settings'))){#-->
$('#my_settings').addClass('admin_nav_sel');
<!--#}elseif(in_array($item,array('users','plans','vip','domain','email','verycode'))){#-->
$('#my_users').addClass('admin_nav_sel');
<!--#}elseif(in_array($item,array('files','public','report'))){#-->
$('#my_files').addClass('admin_nav_sel');
<!--#}elseif(in_array($item,array('plugins'))){#-->
$('#my_plugins').addClass('admin_nav_sel');
<!--#}elseif(in_array($item,array('templates','lang'))){#-->
$('#my_templates').addClass('admin_nav_sel');
<!--#}elseif(in_array($item,array('advertisement','link','announce','navigation','credit','comment','seo'))){#-->
$('#my_advertisement').addClass('admin_nav_sel');
<!--#}elseif(in_array($item,array('database','cache'))){#-->
$('#my_database').addClass('admin_nav_sel');
<!--#}#-->
</script>

<div class="wrap_frame">
<table height="100%" cellspacing="0" cellpadding="0" width="100%" border="0" style="background:#FCFCFC;">
  <tr>
    <td valign="top" width="150" id="admincp_left_frame" >
	  <!--#require_once template_echo('menu',$admin_tpl_dir);#-->
	  </td>
	  <td class="expand_menu" valign="top" onClick="expand_menu();">
	  <div style="padding:200px 0;"><img id="menu_img" align="absmiddle" src="images/menu_left.gif" border="0"></div>
	  </td>
		<td valign="top" width="100%" id="admincp_main_frame">
			<!--#require_once $action_module;#-->
		</td>
		</tr>
	</table>
</div>	
<script type="text/javascript">
if(getCookie('admincp_left_frame_status')=='0'){
	getId('admincp_left_frame').style.display = 'none';
	getId('menu_img').src = "{$admin_tpl_dir}images/menu_right.gif";
	getId('menu_img').alt = "<?=__('open_menu')?>";
}else{
	getId('admincp_left_frame').style.display = '';
	getId('menu_img').src = "{$admin_tpl_dir}images/menu_left.gif";
	getId('menu_img').alt = "<?=__('close_menu')?>";
}
</script>

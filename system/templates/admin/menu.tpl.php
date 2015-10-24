<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-14 10:24:20

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: menu.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<script lanuage="javascript">
function expand(id){
	if(getId('box_'+id).style.display == ''){
		getId('box_'+id).style.display = 'none';
		getId('img_'+id).src = "<?=$admin_tpl_dir?>images/menu_close.gif";
		setCookie('admincp_menu_'+id,1,30);
	}else{
		getId('box_'+id).style.display = '';
		getId('img_'+id).src = "<?=$admin_tpl_dir?>images/menu_open.gif";
		setCookie('admincp_menu_'+id,0,30);
	}
}
$(document).ready(function(){
	$("#menu_container li").mouseover(function(){
		$(this).addClass("m_over");
	}).mouseout(function(){
		$(this).removeClass("m_over");
	});
});
</script>

<div id="menu_container">
	<div class="menu_box">
	<div class="title"><img align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><a href="./" target="_blank"><?=__('menu_site_index')?></a> | <a href="<?=urr(ADMINCP,"")?>" target="_top"><?=__('menu_admin_index')?></a></div>
	</div>
	<br/>
<?php  if($menu =='base'){ ?>
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_site_setting')?></div>
	<div id="box_1">
	<li id="am_1"><a href="<?=urr(ADMINCP,"item=settings&menu=$menu&action=base")?>"><?=__('menu_base_setting')?></a></li>
	<li id="am_2"><a href="<?=urr(ADMINCP,"item=settings&menu=$menu&action=advanced")?>"><?=__('menu_advanced_setting')?></a></li>
	<?php if(super_admin()){ ?>
	<li><a href="<?=urr(ADMINCP,"item=settings&menu=$menu&action=admins_list")?>"><?=__('menu_admins')?></a></li>
	 <?php } ?>
	<li id="am_40"><a href="<?=urr(ADMINCP,"item=settings&menu=$menu&action=back_pwd")?>"><?=__('menu_back_pwd')?></a></li>
	</div>
	</div>
	<br/>
<?php }elseif($menu =='user'){ ?>	
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_user_setting')?></div>
	<div id="box_1">
	<li id="am_3"><a href="<?=urr(ADMINCP,"item=users&menu=$menu&action=add_user")?>"><?=__('menu_add_user')?></a></li>
	<?php if($auth[open_downline2]){ ?>
	<li><a href="<?=urr(ADMINCP,"item=users&menu=$menu&action=nodownline")?>">系统独立用户</a></li>
	<?php } ?>
	<li id="am_4"><a href="<?=urr(ADMINCP,"item=groups&menu=$menu&action=index")?>"><?=__('menu_user_group')?></a></li>
	<li id="am_5"><a href="<?=urr(ADMINCP,"item=users&menu=$menu&action=fastlogin")?>"><?=__('menu_user_fastlogin')?></a></li>
	<li id="am_6"><a href="<?=urr(ADMINCP,"item=users&menu=$menu&action=index")?>"><?=__('menu_user_manage')?></a></li>
		<li id="am_6"><a href="<?=urr(ADMINCP,"item=users&menu=$menu&action=review_application_teacher")?>">教师审核</a></li>
	<li id="am_7"><a href="<?=urr(ADMINCP,"item=users&menu=$menu&action=orders")?>"><?=__('menu_order_process')?></a></li>
	<li id="am_8"><a href="<?=urr(ADMINCP,"item=plans&menu=$menu&action=list")?>"><?=__('menu_earn_plans')?></a></li>
	<?php if($auth[pd_p] || $auth[pd_a]){ ?>
	<li id="am_10"><a href="<?=urr(ADMINCP,"item=vip&menu=$menu&action=list")?>"><?=__('menu_vip')?></a></li>
	<li><a href="<?=urr(ADMINCP,"item=users&menu=$menu&action=credit_log")?>">收入日志</a></li>
	<?php } ?>
	<?php if($auth[pd_a]){ ?>
	<li><a href="<?=urr(ADMINCP,"item=credit&menu=user&action=stat_day")?>">收入统计</a></li>
	<?php } ?>
	<li></li>
	</div>
	</div>
	<br/>
	<div class="menu_box">
	<div class="title" onClick="expand(2);"><img id="img_2" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_email')?></div>
	<div id="box_2">
	<li id="am_11"><a href="<?=urr(ADMINCP,"item=email&menu=$menu&action=setting")?>"><?=__('menu_email_setting')?></a></li>
	<li id="am_12"><a href="<?=urr(ADMINCP,"item=email&menu=$menu&action=mail_test")?>"><?=__('menu_email_test')?></a></li>
	</div>
	</div>
	<br/>
	<div class="menu_box">
	<div class="title" onClick="expand(3);"><img id="img_3" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_other')?></div>
	<div id="box_3">
	<?php if($auth[pd_p] || $auth[pd_a]){ ?>
	<li id="am_9"><a href="<?=urr(ADMINCP,"item=domain&menu=user")?>"><?=__('menu_domain')?></a></li>
	<?php } ?>
	<li id="am_13"><a href="<?=urr(ADMINCP,"item=verycode&menu=$menu")?>"><?=__('menu_verycode')?></a></li>
	</div>
	</div>
	<br/>
	<?php if(!super_admin()){ ?>
	<script>$('#am_9').hide();$('#am_10').hide();</script>
	<?php } ?>
	<?php }elseif($menu =='file'){ ?>
	<div class="menu_box">
		<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_files')?></div>
		<div id="box_1">
			<!--<li id="am_14"><a href="<?=urr(ADMINCP,"item=files&menu=$menu&action=index")?>"><?=__('menu_files_list')?></a></li>-->
			<li id="am_41"><a href="<?=urr(ADMINCP,"item=tag&menu=$menu")?>"><?=__('menu_tag')?></a></li>
			<li id="am_15"><a href="<?=urr(ADMINCP,"item=nodes&menu=$menu&action=list")?>"><?=__('menu_files_node')?></a></li>
			<!--<li><a href="<?=urr(ADMINCP,"item=files&menu=$menu&action=index&view=user_del")?>"><?=__('file_recycle')?></a></li>-->
			<li><a href="<?=urr(ADMINCP,"item=files&menu=$menu&action=filterword")?>"><?=__('file_filter_word')?></a></li>
		</div>
	</div>
	<br/>

	<div class="menu_box">
		<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0>课程管理</div>
		<div id="box_1">
			<li id="am_14"><a href="<?=urr(ADMINCP,"item=course&menu=$menu&action=index")?>">课程审核</a></li>
		</div>
	</div>
	<br/>
	<?php if($auth[pd_a]){ ?>
	<div class="menu_box">
	<div class="title" onClick="expand(2);"><img id="img_2" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_public')?></div>
	<div id="box_2">
	<li id="am_16"><a href="<?=urr(ADMINCP,"item=public&menu=$menu")?>"><?=__('menu_public_setting')?></a></li>
	<li id="am_17"><a href="<?=urr(ADMINCP,"item=public&menu=$menu&action=category")?>"><?=__('menu_public_category')?></a></li>
	<li id="am_18"><a href="<?=urr(ADMINCP,"item=public&menu=$menu&action=viewfile")?>"><?=__('menu_public_viewfile')?></a></li>
	<li id="am_19"><a href="<?=urr(ADMINCP,"item=public&menu=$menu&action=viewfile&cate_id=-2")?>"><?=__('menu_commend_file')?></a></li>
	</div>
	</div>
	<br/>
	<?php if(!super_admin()){ ?>
	<script>$('#box_2').hide();</script>
	<?php } ?>
	<?php } ?>
	<div class="menu_box">
	<div class="title" onClick="expand(3);"><img id="img_3" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_report')?></div>
	<div id="box_3">
	<li id="am_20"><a href="<?=urr(ADMINCP,"item=report&menu=$menu")?>"><?=__('menu_report_setting')?></a></li>
	<li id="am_21"><a href="<?=urr(ADMINCP,"item=report&menu=$menu&action=user")?>"><?=__('menu_report_user')?></a></li>
	<li id="am_22"><a href="<?=urr(ADMINCP,"item=report&menu=$menu&action=system")?>"><?=__('menu_report_system')?></a></li>
	<li id="am_23"><a href="<?=urr(ADMINCP,"item=report&menu=$menu&action=file_unlocked")?>"><?=__('menu_report_file_unlocked')?></a></li>
	</div>
	</div>
	<br/>
<?php }elseif($menu =='plugin' && super_admin()){ ?>
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_plugins_cp')?></div>
	<div id="box_1">
	<li id="am_24"><a href="<?=urr(ADMINCP,"item=plugins&menu=$menu")?>"><?=__('menu_plugins_index')?></a></li>
	<li id="am_25"><a href="<?=urr(ADMINCP,"item=plugins&menu=$menu&action=shortcut")?>"><?=__('menu_plugins_cp_setting')?></a></li>
	</div>
	</div>
	<br/>
	<?php if($settings['open_plugins_cp']){ ?>
	<div class="menu_box">
	<div class="title" onClick="expand(2);"><img id="img_2" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_plugins_shortcut')?></div>
	<div id="box_2">
	<?php 
	if(count($s_plugins_arr)){
		foreach($s_plugins_arr as $v){
	 ?>
		<li><?=get_name($v['plugin_name'],$v['admin_url'],$v['actived'],'mainframe')?></li>
	<?php 
		}
		unset($s_plugins_arr);
	}else{
	 ?>
		<li><?=__('cp_plugin_not_found')?></li>
	<?php 
	}
	 ?>
	</div>
	</div>
	<br/>
	<?php } ?>
	<?php if($settings['open_plugins_last']){ ?>
	<div class="menu_box">
	<div class="title" onClick="expand(3);"><img id="img_3" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_plugins_last_actived')?></div>
	<div id="box_3">
	<?php 
	if(count($plugins_arr)){
		foreach($plugins_arr as $v){
	 ?>
		<li><?=get_name($v['plugin_name'],$v['admin_url'],$v['actived'],'_self')?></li>
	<?php 
		}
		unset($plugins_arr);
	}
	 ?>
	</div>
	</div>
	<br/>
	<?php } ?>
<?php }elseif($menu =='lang_tpl'){ ?>	
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_template_language')?></div>
	<div id="box_1">
	<li id="am_26"><a href="<?=urr(ADMINCP,"item=lang&menu=$menu")?>"><?=__('menu_lang_manage')?></a></li>
	<li id="am_27"><a href="<?=urr(ADMINCP,"item=templates&menu=$menu")?>"><?=__('menu_template_manage')?></a></li>
	</div>
	</div>
	<br/>
<?php }elseif($menu =='extend'){ ?>	
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_extend')?></div>
	<div id="box_1">
	<li id="am_28"><a href="<?=urr(ADMINCP,"item=advertisement&menu=$menu")?>"><?=__('menu_adv_manage')?></a></li>
	<li id="am_29"><a href="<?=urr(ADMINCP,"item=announce&menu=$menu")?>"><?=__('menu_announce_manage')?></a></li>
	<li id="am_30"><a href="<?=urr(ADMINCP,"item=navigation&menu=$menu")?>"><?=__('menu_navigation_manage')?></a></li>
	<li id="am_42"><a href="<?=urr(ADMINCP,"item=link&menu=$menu")?>"><?=__('menu_link_manage')?></a></li>
	<li id="am_31"><a href="<?=urr(ADMINCP,"item=seo&menu=$menu")?>"><?=__('menu_seo_manage')?></a></li>
	<li id="am_32"><a href="<?=urr(ADMINCP,"item=union&menu=$menu")?>"><?=__('menu_union_manage')?></a></li>
	<li id="am_33"><a href="<?=urr(ADMINCP,"item=comment&menu=$menu")?>"><?=__('menu_comment_manage')?></a></li>
	</div>
	</div>
	<br/>
<?php }elseif($menu =='tool'){ ?>	
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_database_manage')?></div>
	<div id="box_1">
	<li id="am_34"><a href="<?=urr(ADMINCP,"item=database&menu=$menu&action=optimize")?>"><?=__('menu_database_optimize')?></a></li>
	<li id="am_35"><a href="<?=urr(ADMINCP,"item=database&menu=$menu&action=backup")?>"><?=__('menu_database_backup')?></a></li>
	<li id="am_36"><a href="<?=urr(ADMINCP,"item=database&menu=$menu&action=restore")?>"><?=__('menu_database_restore')?></a></li>
	</div>
	</div>
	<br/>
	<div class="menu_box">
	<div class="title" onClick="expand(2);"><img id="img_2" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_system_setting')?></div>
	<div id="box_2">
	<li id="am_37"><a href="<?=urr(ADMINCP,"item=cache&menu=$menu&action=search_index")?>"><?=__('menu_search_index')?></a></li>
	<li id="am_38"><a href="<?=urr(ADMINCP,"item=cache&menu=$menu&action=update")?>"><?=__('menu_cache_manage')?></a></li>
	</div>
	</div>
	<br/>
<?php }else{ ?>	
	<div class="menu_box">
	<div class="title" onClick="expand(1);"><img id="img_1" align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><?=__('menu_system_common')?></div>
	<div id="box_1">
	<?php 
	if(count($cs_menus)){
		foreach($cs_menus as $v){
	 ?>
	<li><a href="<?=urr(ADMINCP,"$v[url]")?>"><?=$v['title']?></a></li>
	<?php 
		}
		unset($cs_menus);
	 ?>	
	<li><a href="<?=urr(ADMINCP,"item=sitemap&menu=$menu&action=setting")?>" class="txtblue"><?=__('menu_system_common_setting')?></a></li>
	<?php 
	}else{
	 ?>
	<li><?=__('none_common_menu')?></li>
	<?php 
	}
	 ?>
	</div>
	</div>
	<br/>
<?php } ?>	
	<div class="menu_box">
	<div class="title"><img align="absmiddle" src="<?=$admin_tpl_dir?>images/menu_open.gif" border=0><a href="<?=urr(ADMINCP,"item=users&action=adminlogout")?>" onClick="return confirm('<?=__('system_logout_confirm')?>');"><?=__('menu_logout')?></a></div>
	</div>
	<br/>
</div>
<?php
if(!super_admin()){
	$menu_ids = array(
	'base'=>array(1,2,40),
	'user'=>array(3,4,5,6,7,8,11,12,13),
	'file'=>array(14,15,41,16,17,18,19,20,21,22,23),
	'lang_tpl'=>array(26,27),
	'extend'=>array(28,29,30,31,32,33),
	);
	$script = '<script>';
	foreach(get_admins_power(2) as $k=>$v){

		foreach($menu_ids as $k2 => $v2){
			if(in_array($k,$menu_ids[$k2])){
				if($v>0){
					$script .= '$("#am_'.$k.'").show();';
				}else{
					$script .= '$("#am_'.$k.'").hide();';
				}
			}

		}
	}
	$script .= '</script>';
	echo $script;
}
?>

<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_public.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">

<!--#include sub/block_adv_middle#-->

<div class="div-breadcrumb">
	<ol class="breadcrumb">
		<li><a href="{#urr("index","")#}">首页</a></li>
		<!--#if(count($breadcrumb)){#-->
			<!--#foreach($breadcrumb as $item){#-->
				<!--#if(!empty($item['url'])){#-->
					<li><a href="{$item['url']}">{$item['name']}</a></li>
				<!--#}else{#-->
					<li class="active">{$item['name']}</li>
				<!--#}#-->
			<!--#}#-->
		<!--#}#-->
	</ol>
</div>

<!--#if($cate_id){#-->
<div class="layout_box">
	<div class="l col-md-3">
	<!--#include sub/block_public_cate_list#-->

	<!--#show_adv_data('adv_right');#-->

	<!--#include sub/block_cate_hot_file#-->

	<!--#include sub/block_now_week_down_file#-->
	</div>
	<div class="r col-md-9">
		<div>
			<!--#
			if(count($course_data)){
				foreach($course_data as $k => $v){
					$rowH = ($k%3 ==0) ? '<div class="row">' :'';
					$rowF = ($k%3 ==2) ? '</div>' :'';
			#-->
				{$rowH}
					<div class="col-sm-6 col-md-4">
						<div class="thumbnail">
							<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTUwOWY2ZjUwYzcgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMnB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNTA5ZjZmNTBjNyI+PHJlY3Qgd2lkdGg9IjI0MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI4OS44NTkzNzUiIHk9IjEwNS40Ij4yNDJ4MjAwPC90ZXh0PjwvZz48L2c+PC9zdmc+" alt="">
							<div class="caption">
								<h3><a href="{$v['a_viewcourse']}" >{$v['course_name']}</a></h3>
								<p>{$v['description']}</p>
							</div>
						</div>
					</div>
				{$rowF}
			<!--#
				}
				unset($course_data);
			}else{
			#-->
			<div class="col-md-3 col-md-push-5">没有对应的课程</div>
			<!--#
			}
			#-->
			<div class="clearfix"></div>
			<!--#if($page_nav){#-->
			<div class="head_nav">{$page_nav}</div>
			<!--#}#-->
		</div>
	</div>
</div>
<!--#}else{#-->

<br />
<div class="layout_box">
<!--#
if(count($cate_list)){
	foreach($cate_list as $k => $v){
	$style = ($k+1)%3==0 ? 'r_box' : 'l_box';
#-->
<div class="pub_box {$style}">
<div class="tit2"><span style="float:right;"><a href="{#urr("public","cate_id=$v[cate_id]")#}" title="<?=__('more')?>" target="_blank"><img src="images/more.gif" align="absmiddle" border="0"></a></span><a href="{#urr("public","cate_id=$v[cate_id]")#}">{$v[cate_name]}</a></div>
	<!--#
	$file_list = get_cate_file($v[cate_id]);
	if(count($file_list)){
	#-->
	<ul>
	<!--#
		foreach($file_list as $v2){
	#-->
	<li>{$v2['file_time']}<a href="{$v2['a_viewfile']}" target="_blank">{$v2[file_icon]} {$v2['file_name']}</a></li>
	<!--#
		}
		unset($file_list);
	#-->
	</ul>
	<!--#
	}	
	#-->
</div>
<!--#
	if(($k+1)%3==0){ echo '<div class="clear"></div>';}
	}
	unset($cate_list);
}else{	
#-->

<div class="layout_box2">
	<div class="m">
		<div align="center"><?=__('file_not_found')?></div>
	</div>
</div>
<!--#}#-->
<div class="clear"></div>
</div>

<!--#}#-->
<div class="clearfix"></div>

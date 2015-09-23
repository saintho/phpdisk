<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: phpdisk.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($settings[open_index_fast_upload_box] && !$settings['close_guest_upload']){#-->
<!--#if($upload_remote){#-->
<div style="margin-left:160px; margin-top:10px">
<iframe scrolling="no" src="{$remote_url}{$upload_url2}" width="660" height="50" frameborder="0"></iframe>
</div>
<br /><br />
<!--#}#-->
<!--#}#-->
<!--#if($settings[open_index_site_desc]){#-->
<div class="idx_tips_box">
<ul>
	<li>·国内领先赚钱网盘,1万下载==40-90块钱! </li>
	<li>·即日起发展下线,立即获取10%,永久收入提成! </li>
	<li class="txtred">·上传文件,分享文件链接,用户下载您就获得人民币!</li>
</ul>
</div>
<!--#}#-->
<!--#if($settings[open_index_file_list]){#-->
<Br />
<div class="idx_tips_box_file_index">
<!--#include sub/block_hot_last_file#-->
</div>
<!--#}#-->
<div class="clear"></div>
<br /><br /><br /><br />
<!--#if($settings[open_index_fast_upload_box] && !$settings['close_guest_upload']){#-->
<!--#if($show_multi && $pd_uid){#-->
<script type="text/javascript">$("#multi_box").myBox({title:'<?=__('multi_upload')?>',boxType:"iframe",iframe:{width:500,height:350},show:true,target:'{$upload_url}'});</script>
<!--#}#-->
<!--#}#-->


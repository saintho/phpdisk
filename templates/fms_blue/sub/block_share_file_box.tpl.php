<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_share_file_box.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="share_box_wrap"> 
<div class="share_box_tit" align="center"><?=__('share_file_tit')?></div>
<div class="share_box" align="center">
 <span class="f18 bold" style="color:#E87301">{$stats['all_files_count']}</span>&nbsp;<span style="color:#666"><?=__('file_shareing')?></span><br />
<!--#if($pd_uid){#-->
<a href="{#urr("mydisk","item=profile&action=multi_upload")#}" class="share_file_btn"></a>
<!--#}else{#-->
<a href="javascript:;" onclick="document.location='{#urr("account","action=login")#}';" class="share_file_btn"></a>
<!--#}#-->
</div>
</div>

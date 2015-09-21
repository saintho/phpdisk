<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: front_msg.tpl.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##
#-->
<!--#require_once template_echo('circle_box_header',$user_tpl_dir); #-->
<div class="cboxcontent">
<div class="alert_msg">
<h1><?=__('system_message')?></h1>
<!--#
if(count($sysmsg)){
	for($i=0;$i<count($sysmsg);$i++){
#-->
<li>* {#$sysmsg[$i]#}</li>
<!--#
	}
}
unset($sysmsg);
#-->
<br><br>
<li>&raquo; <a href="javascript:history.back();"><?=__('go_back')?></a></li>
<li>&raquo; <a href="{$settings['phpdisk_url']}"><?=__('go_index')?></a></li>
<br><br>
</div>
</div>
<!--#require_once template_echo('circle_box_footer',$user_tpl_dir); #-->

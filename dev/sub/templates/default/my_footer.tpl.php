<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: my_footer.tpl.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##
#-->
<!--#if($inner_box){#-->
</body>
</html>
<!--#}else{#-->
<br/><br/>
<div style="border-bottom:1px #ccc solid">&nbsp;</div>
<br/>
<div align="center" class="f10 txtgray" style="display:{$debug_info}">{$pageinfo}</div>
<div align="center" class="f10 txtgray">Powered by <a href="http://www.phpdisk.com/" target="_blank">PHPDisk Team</a> <!--#if($settings['version_info']){#-->{PHPDISK_EDITION} {PHPDISK_VERSION}<!--#}#--> &copy; 2008-{NOW_YEAR} All Rights Reserved. {$site_stat}</div>
<br/><br/><br/>	
</body>
</html>
<!--#}#-->

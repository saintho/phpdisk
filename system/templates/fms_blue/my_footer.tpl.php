<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-27 21:31:28

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: my_footer.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if($inner_box){ ?>
</body>
</html>
<?php }else{ ?>
<br/><br/>
<div style="border-bottom:1px #ccc solid">&nbsp;</div>
<br/>
<div align="center" class="f10 txtgray" style="display:<?=$debug_info?>"><?=$pageinfo?></div>
<div align="center" class="f10 txtgray">Powered by <a href="http://www.google.com/" target="_blank">google.com</a> <?php if($settings['version_info']){ ?><?=PHPDISK_EDITION?> <?=PHPDISK_VERSION?><?php } ?> &copy; 2008-<?=NOW_YEAR?> All Rights Reserved. <?=$site_stat?></div>
<br/><br/><br/>	
</body>
</html>
<?php } ?>

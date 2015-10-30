<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-09-21 18:25:13

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
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
 ?>
<?php if($inner_box){ ?>
</body>
</html>
<?php }else{ ?>
<br/><br/>
<div style="border-bottom:1px #ccc solid">&nbsp;</div>
<br/>
<div align="center" class="f10 txtgray" style="display:<?=$debug_info?>"><?=$pageinfo?></div>
<div align="center" class="f10 txtgray">Powered by <a href="http://www.phpdisk.com/" target="_blank">PHPDisk Team</a> <?php if($settings['version_info']){ ?><?=PHPDISK_EDITION?> <?=PHPDISK_VERSION?><?php } ?> &copy; 2008-<?=NOW_YEAR?> All Rights Reserved. <?=$site_stat?></div>
<br/><br/><br/>	
</body>
</html>
<?php } ?>

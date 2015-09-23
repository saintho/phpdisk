<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2014-04-29 00:30:05

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_footer.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>

<?php show_adv_data('adv_bottom'); ?>
</div>

<div class="foot_box">
<div align="center"><?=$site_index?>
<a href="sitemap.xml" target="_blank"><?=__('baidu_google_sitemap')?></a> - 
<a href="<?=urr("rss","")?>" target="_blank"><?=__('rss_reader')?></a> - 
<?php require_once template_echo('sub/block_navigation_bottom','templates/default/'); ?>
<?=$contact_us?><?=$miibeian?><?=$site_stat?>
<?php require_once template_echo('sub/block_lang_tpl_switch','templates/default/'); ?>
</div>
<br>
<div class="debug_info" style="display:none"><?=$pageinfo?></div>
<div class="clear"></div>

<div class="foot_info" align="center">
Powered by <a href="http://www.google.com/" target="_blank">google.com</a>
<?=PHPDISK_EDITION?> v<?=PHPDISK_VERSION?> 2008-<?=NOW_YEAR?> &copy; All Rights Reserved.<?php require_once template_echo('sub/block_license','templates/default/'); ?></div>
</div>

</body>
</html>

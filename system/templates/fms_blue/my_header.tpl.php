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
#	$Id: my_header.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>" />
<title>google.com</title>
<script type="text/javascript">var tpl_dir = '<?=$user_tpl_dir?>';</script>
<script type="text/javascript" src="includes/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="includes/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="images/js/jquery.jBox-2.3.min.js"></script>
<script type="text/javascript" src="images/js/jquery.jBox-zh-CN.js"></script>
<link type="text/css" rel="stylesheet" href="images/js/skins/blue/jbox.css"/>
<script type="text/javascript" src="includes/js/common.js"></script>
<meta name="copyright" content="Powered by PHPDisk Team, <?=PHPDISK_EDITION?> <?=PHPDISK_VERSION?> build<?=PHPDISK_RELEASE?>" />
<meta name="generator" content="PHPDisk <?=PHPDISK_VERSION?>" />
<script type="text/javascript">
var deny_extension = '<?=$settings['deny_extension']?>';
<?php if($settings['cookie_domain']){ ?>
document.domain = "<?=$settings['cookie_domain']?>";
<?php } ?>
</script>

<link href="<?=$user_tpl_dir?>images/style.css" rel="stylesheet" type="text/css">
</head>

<?php if($inner_box){ ?>
<body style="background:#FFFFFF">
<?php }else{ ?>
<body>
<?php } ?>

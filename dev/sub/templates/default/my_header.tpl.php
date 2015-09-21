<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: my_header.tpl.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##
#-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$charset}" />
<title>phpdisk.com</title>
<script type="text/javascript">var tpl_dir = '{$user_tpl_dir}';</script>
<script type=text/javascript src="includes/js/jquery.js"></script>
<script type="text/javascript" src="includes/js/common.js"></script>
<meta name="copyright" content="Powered by PHPDisk Team, {PHPDISK_EDITION} {PHPDISK_VERSION} build{PHPDISK_RELEASE}" />
<meta name="generator" content="PHPDisk {PHPDISK_VERSION}" />
<script type="text/javascript" src="includes/js/jquery.mybox.js"></script>
<link rel="stylesheet" type="text/css" href="images/mybox.css" />

<script type="text/javascript">
var deny_extension = '{$settings['deny_extension']}';
<!--#if($settings['cookie_domain']){#-->
document.domain = "{$settings['cookie_domain']}";
<!--#}#-->
var up_go = "{$settings[phpdisk_url]}{#urr("space","username=".rawurlencode($pd_username))#}";
</script>

<link href="{$user_tpl_dir}images/style.css" rel="stylesheet" type="text/css">
</head>

<!--#if($inner_box){#-->
<body style="margin:0; padding:0">
<!--#}else{#-->
<body>
<!--#}#-->

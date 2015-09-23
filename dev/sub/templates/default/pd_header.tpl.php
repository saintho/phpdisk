<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: pd_header.tpl.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##
#-->
<!--#if(!$inner_box){#-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--#}#-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$charset}" />
<title>up.phpdisk.com</title>
<!--#if($settings['open_seo']){#-->
<meta name="keywords" content="{$file_keywords}{$settings['meta_keywords']}" />
<meta name="description" content="{$file_description}{$settings['meta_description']}" />
<!--#}#-->
<link rel="shortcut icon" href="favicon.ico">
<meta name="generator" content="PHPDisk {PHPDISK_VERSION}" />
<script type="text/javascript" src="includes/js/jquery.js"></script>
<script type="text/javascript" src="includes/js/common.js"></script>
<script type="text/javascript" src="includes/js/tree.js"></script>
<script type="text/javascript" src="includes/js/jquery.mybox.js"></script>
<script type="text/javascript" src="includes/js/jquery.mybox.js"></script>
<link rel="stylesheet" type="text/css" href="images/mybox.css" />
<script type="text/javascript">
var deny_extension = '{$settings['deny_extension']}';
<!--#if($settings['cookie_domain']){#-->
document.domain = "{$settings['cookie_domain']}";
<!--#}#-->
</script>
<link href="{$user_tpl_dir}images/style.css" rel="stylesheet" type="text/css">
</head>

<body>

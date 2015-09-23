<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: announce.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$inner_box = true;
$aid = (int)gpc('aid','G',0);
include PHPDISK_ROOT.'includes/header.inc.php';

$content = $db->result_first("select content from {$tpf}announces where annid='$aid'");
$str = '<div class="in_announce">'.$content.'</div>';
$str .= "<br><div align=\"center\"><input type=\"button\" class=\"btn\" value=\"".__('btn_close')."\" onclick=\"top.$.jBox.close(true);\"/></div>";
$str .= '</body></html>';
echo $str;

include PHPDISK_ROOT.'includes/footer.inc.php';


?>
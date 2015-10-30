<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: ann_list.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$in_front = true;

$aid = (int)gpc('aid','G',0);

$nav_title = @$db->result_first("select subject from {$tpf}announces where annid='$aid'");
$nav_title = $nav_title ? $nav_title : __('all_ann_list');
$title = $nav_title.' - '.$settings['site_title'];
$file_keywords = $nav_title.',';

include PHPDISK_ROOT."./includes/header.inc.php";

$ann_list_sub = get_announces(10);
$perpage=5;
$sql_ext = $aid ? " and annid='$aid'" : '';
$sql_do = "{$tpf}announces where is_hidden=0 $sql_ext";
$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
$total_num = $rs['total_num'];
$start_num = ($pg-1) * $perpage;

$q = $db->query("select * from {$sql_do} order by show_order asc,annid desc limit $start_num,$perpage");
$ann_list = array();
while($rs = $db->fetch_array($q)){
	$rs[a_ann_href] = urr("ann_list","aid={$rs[annid]}");
	$rs[in_time] = date('Y-m-d H:i',$rs[in_time]);
	$ann_list[] = $rs;
}
$db->free($q);
unset($rs);
$page_nav = multi($total_num, $perpage, $pg, "ann_list.php?aid=$aid");

require_once template_echo('pd_ann_list',$user_tpl_dir);

include PHPDISK_ROOT."./includes/footer.inc.php";
?>
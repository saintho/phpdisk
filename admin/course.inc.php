<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: files.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,14,$pd_uid);
function get_servers(){
	global $db,$tpf;
	$q = $db->query("select server_name,server_oid from {$tpf}servers where server_oid>1 order by server_id asc");
	while ($rs = $db->fetch_array($q)) {
		$arr[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $arr;
}
switch($action){
	case 'index':
		$uid = (int)gpc('uid','GP',0);
		$status = (int)gpc('status','GP',0);
		if(in_array($task,array('search'))){

		}else{
			$course_array = get_course_list();
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=file&action=$action&view=$view&uid=$uid"));
			$dd = date('Y-m-d');
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'course_view':
		if($task){
			switch($task){
				case 'course_view':
					$file_id = gpc('file_ids','GP',0);
					$review_status = gpc('review_status','GP',0);
					$cs_id = gpc('cs_id','GP',0);
					$course_id = gpc('course_id','GP',0);
					foreach($file_id as $k => $v){
						$sql = "UPDATE {$tpf}file_cs_relation
								SET (cs_id, course_id, status)
								VALUE ($cs_id, $course_id, $review_status)
								WHERE cs_id = {$cs_id} AND course_id={$course_id}";
						$db->query_unbuffered($sql);
					}

					break;
			}
		}else{
			$course_id = gpc('course_id','GP','');
			$chapter_section_array = get_chapter_section_list($course_id);
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'search':
		$condition = '';
		$status = (int)gpc('status','GP',0);
		if($status){
			switch($status){
				case 1:
					$condition = 'AND fcr.status = 1 AND c.status = 1';
					break;
				case 2:
					$condition = 'AND fcr.status = 2 AND c.status = 2';
					break;
			}
		}

		$current_status = $status;
		$course_array = get_course_list($condition);
		$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=file&action=$action&view=$view&uid=$uid"));
		$dd = date('Y-m-d');
		require_once template_echo($item,$admin_tpl_dir,'',1);
		break;
}

?>
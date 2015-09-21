<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: extract.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";
!$auth[is_fms] && exit(msg::umsg('Not_FMS',__('zcore_no_power')));
$in_front = true;

$title = __('extract_file').' - '.$settings['site_title'];
include PHPDISK_ROOT."./includes/header.inc.php";

switch($action){
	case 'file_extract':
		form_auth(gpc('formhash','P',''),formhash());
		$extract_code = trim(gpc('extract_code','P',''));

		if(strlen($extract_code)==8){
			$rs = $db->fetch_one_array("select fl.*,u.username from {$tpf}files fl,{$tpf}users u where u.userid=fl.userid and file_key='$extract_code'");
			if($rs){
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				$rs[a_space] = urr("space","username=".rawurlencode($rs[username]));
				$rs['file_thumb'] = get_file_thumb($rs);
				$rs['file_name_all'] = filter_word($rs['file_name'].$tmp_ext);
				$rs['file_name'] = cutstr(filter_word($rs['file_name'].$tmp_ext),35);
				$rs['file_size'] = get_size($rs['file_size']);
				$rs['file_time'] = date("Y-m-d H:i",$rs['file_time']);
				$rs['a_viewfile'] = urr("viewfile","file_id={$rs[file_id]}");
				$rs[file_description] = clear_html(filter_word($rs[file_description]),50);
				$files_array[] = $rs;
			}else{
				$sysmsg[] = __('extract_code_not_found');
			}
			unset($rs);
		}

		require_once template_echo('pd_extract',$user_tpl_dir);

		break;

	default:
		require_once template_echo('pd_extract',$user_tpl_dir);
}
include PHPDISK_ROOT."./includes/footer.inc.php";

?>
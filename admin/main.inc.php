<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: main.inc.php 126 2014-03-17 07:51:04Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}

switch($action){
	default:
		$install_dir_exists = is_dir(PHPDISK_ROOT.'install/') ? true : false;
		
		$q = $db->query("select * from {$tpf}stats ");
		while($rs = $db->fetch_array($q)){
			$set[$rs['vars']] = trim($rs['value']);
		}
		$db->free($q);
		unset($rs);

		if(!$set['stat_time'] || $timestamp-$set['stat_time'] >3600){

			$stats['user_folders_count'] = (int)@$db->result_first("select count(*) from {$tpf}folders");

			$stats['user_files_count'] = (int)@$db->result_first("select count(*) from {$tpf}files");

			$stats['users_count'] = (int)@$db->result_first("select count(*) from {$tpf}users ");

			$stats['users_locked_count'] = (int)@$db->result_first("select count(*) from {$tpf}users where is_locked=1");

			$stats['all_files_count'] = (int)@$db->result_first("select count(*) from {$tpf}files");

			$storage_count_tmp = (float)@$db->result_first("select sum(file_size) from {$tpf}files");

			$stats['user_storage_count'] = get_size($storage_count_tmp);
			$stats['total_storage_count'] = get_size($storage_count_tmp);
			$stats['users_open_count'] = $stats['users_count']-$stats['users_locked_count'];
			$stats['stat_time'] = $timestamp;

			stats_cache($stats);
		}
		$stats[a_report_href] = urr(ADMINCP,"item=report&menu=file&action=user");
		$stats[report_count] = (int)@$db->result_first("select count(*) from {$tpf}files where report_status=1 and is_del=0");
		$stats[a_comment_href] = urr(ADMINCP,"item=comment&menu=extend");
		$stats[comment_count] = (int)@$db->result_first("select count(*) from {$tpf}comments where is_checked=0");
		$stats[a_public_href] = urr(ADMINCP,"item=public&menu=file&action=viewfile&cate_id=-1");
		$stats[cate_public_count] = (int)@$db->result_first("select count(*) from {$tpf}files where cate_id>0 and is_checked=0");

		$iconv_support = function_exists('iconv') ? '<span class="txtblue">'.__('yes').'</span>' : '<span class="txtred">'.__('no').'</span>';
		$mbstring_support = function_exists('mb_convert_encoding') ? '<span class="txtblue">'.__('yes').'</span>' : '<span class="txtred">'.__('no').'</span>';
		$post_max_size = ini_get('post_max_size');
		$file_max_size = ini_get('upload_max_filesize');
		$mysql_info = mysql_get_client_info();
		$gd_support = function_exists('gd_info') ? '<span class="txtblue">'.__('yes').'</span>' : '<span class="txtred">'.__('no').'</span>';
		$gd_info_arr = gd_info();
		$gd_info = $gd_info_arr['GD Version'];
		$charset_info = strtoupper($charset);

		require_once template_echo('main',$admin_tpl_dir,'',1);
}
function get_web_link($url){
	if(function_exists('curl_init')){
		$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER         => false,
		CURLOPT_ENCODING       => "",
		CURLOPT_USERAGENT      => "spider",
		CURLOPT_AUTOREFERER    => true,
		CURLOPT_CONNECTTIMEOUT => 120,
		CURLOPT_TIMEOUT        => 2,
		CURLOPT_MAXREDIRS      => 10,
		CURLOPT_NOBODY => 1,
		);
		$ch = curl_init($url);
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		$err = curl_errno($ch);
		$errmsg = curl_error($ch);
		$header = curl_getinfo($ch);
		curl_close($ch);

		$header['errno'] = $err;
		$header['errmsg'] = $errmsg;
		$header['content'] = $content;

		return $header;
	}
}
?>
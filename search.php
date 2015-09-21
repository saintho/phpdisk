<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: search.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
include "includes/commons.inc.php";

$in_front = true;

$word = trim(gpc('word','G',''));

$nav_title = $word ? $word.'|' : '';
$nav_title = $nav_title.__('search_file');
$title = $nav_title.' - '.$settings['site_title'];
$file_keywords = $nav_title.',';
include PHPDISK_ROOT."./includes/header.inc.php";

switch($action){
	case 'search':
		$n = trim(gpc('n','G',''));
		$u = trim(gpc('u','G',''));
		$s = trim(gpc('s','G',''));
		$t = trim(gpc('t','G',''));
		$o_arr = array('asc','desc');
		if($n){
			$sql_order = in_array($n,$o_arr) ? " file_name $n" : " file_name asc";
		}elseif($u){
			$sql_order = in_array($u,$o_arr) ? " username $u" : " username asc";
		}elseif($s){
			$sql_order = in_array($s,$o_arr) ? " file_size $s" : " file_size asc";
		}elseif($t){
			$sql_order = in_array($t,$o_arr) ? " file_time $t" : " file_time asc";
		}else{
			$sql_order = " file_id desc";
		}

		$scope = trim(gpc('scope','G',''));
		$word_str = $word = str_replace('　',' ',replace_inject_str($word));

		if(strpos($word_str,'.') ===true){
			$arr = explode('.',$word_str);
		}else{
			$arr = explode(' ',$word_str);
		}
		$str = '';
		if(count($arr)>1){
			for($i=0;$i<count($arr);$i++){
				if(trim($arr[$i]) <> ''){
					$str .= " (file_name like '%{$arr[$i]}%' or file_extension like '%{$arr[$i]}%') and";
				}
			}
			$str = substr($str,0,-3);
			$sql_keyword = " (".$str.")";

		}else{
			$sql_keyword = " (file_name like '%{$word_str}%' or file_extension like '%{$word_str}%')";
		}
		$insert_index = false;

		switch($scope){
			case 'mydisk':
				$sql_do = " {$tpf}files fl,{$tpf}users u where fl.userid=u.userid and fl.userid='$pd_uid' and is_del=0 and {$sql_keyword}";
				break;
			case 'all':
			default:
				$sql_do = " {$tpf}files fl,{$tpf}users u where fl.userid=u.userid and is_checked=1 and in_share=1 and is_del=0 and {$sql_keyword}";
				$rs = $db->fetch_one_array("select * from {$tpf}search_index where scope='$scope' and word='$word'");
				if($rs){
					$db->query_unbuffered("update {$tpf}search_index set search_time='$timestamp',total_count=total_count+1 where searchid='{$rs['searchid']}'");
				}else{
					$ins = array(
					'scope' => $scope,
					'word' => $word,
					'search_time' => $timestamp,
					'total_count' => 1,
					'file_ids' => '',
					'ip' => $onlineip,
					);
					$db->query("insert into {$tpf}search_index set ".$db->sql_array($ins).";");
				}
				break;
		}
		$perpage = 20;
		$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;

		$q = $db->query("select fl.userid,file_id,file_key,file_name,file_extension,file_size,file_time,server_oid,file_store_path,file_real_name,is_image,file_downs,file_views,u.username from {$sql_do} order by {$sql_order} limit $start_num,$perpage");
		$files_array = array();
		while($rs = $db->fetch_array($q)){
			$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
			$rs['file_thumb'] = get_file_thumb($rs);			
			$rs['file_name_all'] = str_ireplace($word,'<span class=txtred>'.$word.'</span>',filter_word($rs['file_name'].$tmp_ext));
			$rs[file_name] = filter_word($rs['file_name'].$tmp_ext);
			$rs['file_size'] = get_size($rs['file_size']);
			$rs['file_time'] = date("Y-m-d",$rs['file_time']);
			$rs['a_downfile'] = urr("downfile","file_id={$rs['file_id']}&file_key={$rs['file_key']}");
			$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
			$rs[file_description] = clear_html($rs[file_description],50);
			$rs['a_space'] = urr("space","username=".rawurlencode($rs['username']));
			//$file_ids .= $rs['file_id'].',';
			$files_array[] = $rs;
		}
		$db->free($q);
		unset($rs);

		$n_t = ($n=='asc') ? 'desc' : 'asc';
		$u_t = ($u=='asc') ? 'desc' : 'asc';
		$s_t = ($s=='asc') ? 'desc' : 'asc';
		$t_t = ($t=='asc') ? 'desc' : 'asc';
		$n_order = $n ? $L['o_'.$n_t] : '';
		$u_order = $u ? $L['o_'.$u_t] : '';
		$s_order = $s ? $L['o_'.$s_t] : '';
		$t_order = $t ? $L['o_'.$t_t] : '';
		$n_url = urr("search","action=search&word=".rawurlencode($word)."&scope=$scope&n=$n_t");
		$u_url = urr("search","action=search&word=".rawurlencode($word)."&scope=$scope&u=$u_t");
		$s_url = urr("search","action=search&word=".rawurlencode($word)."&scope=$scope&s=$s_t");
		$t_url = urr("search","action=search&word=".rawurlencode($word)."&scope=$scope&t=$t_t");
		$arr = explode('&',$_SERVER['QUERY_STRING']);
		$page_nav = multi($total_num, $perpage, $pg, urr("search","action=search&word=".rawurlencode($word)."&scope=$scope&{$arr[3]}"));

		require_once template_echo('pd_search',$user_tpl_dir);

		break;

	default:
		require_once template_echo('pd_search',$user_tpl_dir);
}

include PHPDISK_ROOT."./includes/footer.inc.php";

?>

<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: adm_ajax.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";
phpdisk_core::admin_login();

switch($action){	
	case 'search_host':
		$server_oid = (int)gpc('server_oid','P',0);
		if($pd_gid<>1){
			exit(__('not_admin_error'));
		}
		if($server_oid<2){
			exit(__('multi_server_not_set'));
		}
		$rs = $db->fetch_one_array("select * from {$tpf}servers where server_oid='$server_oid'");
		if($rs){
			$str = '<select id="sh_id" onchange="sel_host();">'.LF;
			$str .= '<option value="">'.__('please_select_dl_host').'</option>'.LF;
			if($rs[server_dl_host]){
				$arr = explode(LF,$rs[server_dl_host]);
				for($i=0;$i<count($arr);$i++){
					$str .= '<option value='.rawurlencode($arr[$i]).'>'.$arr[$i].'</option>'.LF;
				}
			}else{
				$str .= '<option value='.rawurlencode($rs[server_host]).'>'.$rs[server_host].'</option>'.LF;
			}
			$str .= '</select>'.LF;
			echo 'true|'.$str;
		}else{
			echo __('multi_server_not_set');
		}
		break;
	case 'adm_del_log':
		$log_day = (int)gpc('log_day','P',0);
		if($pd_gid<>1){
			exit(__('not_admin_error'));
		}
		if(!$log_day){
			exit(__('log_day_error'));
		}
		$tmp = $log_day*86400;
		$db->query_unbuffered("delete from ".get_table_credit_log()." where in_time<$timestamp-$tmp");
		exit('true|'.__('adm_del_log_success'));
		break;
	case 'dostat':
		$act = gpc('act','P','');
		$dd = gpc('dd','P','');

		if($act && $dd){
			if(in_array($act,array('views','downs','money'))){
				//$all = (float)@$db->result_first("select sum($act) from {$tpf}stat_user where dd='$dd'");
				$all = 0;
				$q = $db->query("select views,downs,money,userid from {$tpf}stat_user where dd='$dd'");
				while ($rs = $db->fetch_array($q)) {
					$all += get_discount($rs[userid],$rs[$act]);
				}
				$db->free($q);
				unset($rs);
				echo 'true|'.round($all,4);
			}else{
				echo 'Error Act';
			}
		}else{
			echo 'Error action!';
		}
		break;
	case 'vip_count':
		$vip_id = (int)gpc('vip_id','P',0);
		$num = (int)@$db->result_first("select count(*) from {$tpf}users where vip_id='$vip_id'");
		echo 'true|'.$num;
		break;	

}
?>
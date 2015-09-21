<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: credit.inc.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2012 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
if(!$auth[pd_a]){
	exit(msg::umsg('no_power',__('zcore_no_power')));
}
$action = $action ? $action : 'set';
switch($action){

	case 'stat_day':
	case 'stat_hour':
	case 'stat_user':
		if(!$auth[pd_a]){
			exit(msg::umsg('Not',__('zcore_no_power')));
		}
		$pp = gpc('pp','G','');
		$v_ob = gpc('v_ob','G','');
		$d_ob = gpc('d_ob','G','');
		$v_ob = in_array($v_ob,array('asc','desc')) ? $v_ob : '';
		$d_ob = in_array($d_ob,array('asc','desc')) ? $d_ob : '';
		$v_order_by = $v_ob ? " views $v_ob" : '';
		$d_order_by = $d_ob ? " downs $d_ob" : '';

		$perpage = $pp ? (int)$pp : 50;

		if($v_order_by){
			$order_by = ' order by ' .$v_order_by;
		}elseif($d_order_by){
			$order_by = ' order by ' . $d_order_by;
		}else{
			$order_by = 'order by id desc';
		}
		if($task=='search'){
			$user = gpc('user','G','');
			$s_time = gpc('s_time','G','');
			$e_time = gpc('e_time','G','');
			if(!$s_time || !$e_time){
				exit('<script>alert("起始时间、结束时间不能为空");window.history.back();</script>');
			}
			$u_sql = '';
			if($action=='stat_user'){
				if($user){
					$userid = @$db->result_first("select userid from {$tpf}users where username='$user' ");
					if(!$userid){
						exit('<script>alert("用户名不存在");window.history.back();</script>');
					}
					$u_sql = $userid ? " and s.userid='$userid'" : '';
				}
				$sql_do = " {$tpf}{$action} s,{$tpf}users u where u.userid=s.userid $u_sql and (dd>='$s_time' and  dd<='$e_time')";
			}elseif($action=='stat_hour'){
				$sql_do = " {$tpf}{$action} where (dh>='$s_time' and  dh<='$e_time')";
			}else{
				$sql_do = " {$tpf}{$action} where (dd>='$s_time' and  dd<='$e_time')";
			}
		}else{

			if($action=='stat_hour'){
				$s_time = date('YmdH',$timestamp-30*86400);
				$e_time = date('YmdH');
			}else{
				$s_time = date('Ymd',$timestamp-30*86400);
				$e_time = date('Ymd');
			}
			if($action=='stat_user'){
				$sql_do = " {$tpf}{$action} s,{$tpf}users u where u.userid=s.userid";
			}else{
				$sql_do = " {$tpf}{$action}";
			}
		}

		$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;
		if($action=='stat_user'){
			$q = $db->query("select s.*,u.username from {$sql_do} $order_by limit $start_num,$perpage");
		}else{
			$q = $db->query("select * from {$sql_do} $order_by limit $start_num,$perpage");
		}
		$stat_log = array();
		while($rs = $db->fetch_array($q)){
			if($action=='stat_hour'){
				$rs[stat_time] = $rs[dh].'时';
			}else{
				$rs[stat_time] = $rs[dd].'日';
			}
			$stat_log[] = $rs;
		}
		$db->free($q);
		unset($rs);
		$v_ob = $v_ob=='asc' ? 'desc' : 'asc';
		$d_ob = $d_ob=='asc' ? 'desc' : 'asc';
		$v_add = $v_ob=='asc' ? '↑' : '↓';
		$d_add = $d_ob=='asc' ? '↑' : '↓';
		$v_url = urr(ADMINCP,"item=$item&menu=user&action=$action&task=$task&user=$user&s_time=$s_time&e_time=$e_time&v_ob=$v_ob&d_ob=");
		$d_url = urr(ADMINCP,"item=$item&menu=user&action=$action&task=$task&user=$user&s_time=$s_time&e_time=$e_time&v_ob=&d_ob=$d_ob");
		$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=user&action=$action&task=$task&user=$user&s_time=$s_time&e_time=$e_time&v_ob=$v_ob&d_ob=$d_ob&pp=$pp"));
		require_once template_echo($item,$admin_tpl_dir,'',1);
		break;

}

?>
<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: users.inc.php 126 2014-03-17 07:51:04Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}

switch($action){
	case 'nodownline':
		if($task =='change'){
			form_auth(gpc('formhash','P',''),formhash());
			$dist_name = trim(gpc('dist_name','P',''));
			$userids = gpc('userids','P',array(''));

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$dist_name){
				$error = true;
				$sysmsg[] = '请填写指定下线的目标用户';
			}else{
				$userid = @$db->result_first("select userid from {$tpf}users where username='$dist_name'");
				if(!$userid){
					$error = true;
					$sysmsg[] = '指定下线的目标用户不存在';
				}
			}
			if(!count($userids)){
				$error = true;
				$sysmsg[] = '请选择要操作的用户';
			}elseif(in_array($userid,$userids)){
				$error = true;
				$sysmsg[] = '不能指定自己为下线';
			}else{

			}
			if(is_vip($userid)){
				$num = (int)@$db->result_first("select count(*) from {$tpf}buddys where userid='$userid' and is_system=1");
				if(($num+count($userids))>get_vip(get_profile($pd_uid,'vip_id'),'downline_num')){
					$error = true;
					$sysmsg[] = '此用户的VIP下线数不足 '.($num+count($userids));
				}
			}
			if(!$error){
				$ins_s = '';
				for ($i=0;$i<count($userids);$i++){
					$ins_s .= "('$userid','{$userids[$i]}','1','$timestamp'),";
				}
				if($ins_s){
					$ins_s = substr($ins_s,0,-1);
					$db->query_unbuffered("insert into {$tpf}buddys (userid,touserid,is_system,in_time) values $ins_s;");
				}
				$sysmsg[] = '用户下线指定成功';
				redirect(urr(ADMINCP,"item=users&menu=user&action=$action"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$q = $db->query("select userid,touserid from {$tpf}buddys");
			$busers = array();
			while($rs = $db->fetch_array($q)){
				$busers[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$buser_str = '';
			if(count($busers)){
				foreach ($busers as $v){
					$buser_str .= $v[userid].','.$v[touserid].',';
				}
			}
			$sql_ext = $buser_str ? "userid not in (".substr($buser_str,0,-1).")" : '1';

			$sql_do = " {$tpf}users where $sql_ext";// no downline

			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select * from {$sql_do} order by userid desc limit $start_num ,$perpage");
			$users = array();
			while($rs = $db->fetch_array($q)){
				$rs['reg_time'] = date("Y-m-d H:i:s",$rs['reg_time']);
				$rs['a_user_edit'] = urr(ADMINCP,"item=users&menu=user&action=user_edit&uid={$rs['userid']}");
				$users[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=users&menu=user&action=$action"));

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'fastlogin':
		admin_no_power($task,5,$pd_uid);
		if($task =='fastlogin'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'open_qq_fl' => 0,
			'fl_qq_appid' => '',
			'fl_qq_appkey' => '',
			'open_weibo_fl' => 0,
			'fl_weibo_appid' => '',
			'fl_weibo_appkey' => '',
			);
			$online_demo = $settings['online_demo'];
			$settings = gpc('setting','P',$setting);

			if($online_demo){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('fastlogin_update_success');
				redirect(urr(ADMINCP,"item=users&menu=user&action=$action"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'index':
		admin_no_power($task,6,$pd_uid);
		if($task =='move'){
			form_auth(gpc('formhash','P',''),formhash());

			$userids = gpc('userids','P',array(''));
			$dest_gid = (int)gpc('dest_gid','P','');

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$dest_gid){
				$error = true;
				$sysmsg[] = __('please_select_dest_gid');
			}

			$ids_arr = get_ids_arr($userids,__('please_select_move_users'),1);
			if($ids_arr[0]){
				$error = true;
				$sysmsg[] = $ids_arr[1];
			}else{
				$user_str = $ids_arr[1];
			}

			if(!$error){
				$db->query_unbuffered("update {$tpf}users set gid='$dest_gid' where userid in ($user_str)");
				$sysmsg[] = __('move_user_success');
				redirect(urr(ADMINCP,"item=users&menu=user&action=index"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$perpage = 30;
			$gid = (int)gpc('gid','G',0);
			$orderby = gpc('orderby','G','');
			$sql_str = "";
			switch($orderby){
				case 'time_desc':
					$sql_orderby = " order by userid desc";
					break;
				case 'time_asc':
					$sql_orderby = " order by reg_time asc";
					break;
				case 'is_locked':
					$sql_orderby = $sql_str = " and u.is_locked=1";
					break;
				default:
					if(substr($orderby,0,6)=='credit' || substr($orderby,0,7)=='mydowns'){
						$arr = explode('_',$orderby);
						$sql_orderby = " order by $arr[0] $arr[1]";
					}elseif(substr($orderby,0,10)=='used_space'){
						$arr = explode('_',$orderby);
						$sql_orderby = " order by $arr[0]_$arr[1] $arr[2]";
					}else{
						$sql_orderby = " order by userid asc";
					}
					//echo $sql_orderby;
			}
			$sql_ext = $gid ? " and u.gid='$gid'" : "";
			$sql_do = " {$tpf}users u,{$tpf}groups g where u.gid=g.gid {$sql_ext}";

			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do} {$sql_str}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select u.*,g.gid,g.group_name from {$sql_do} {$sql_orderby} limit $start_num ,$perpage");
			$users = array();
			while($rs = $db->fetch_array($q)){
				$rs['is_admin'] = ($rs['gid']==1) ? 1 : 0;
				$rs['reg_time'] = date("Y-m-d H:i:s",$rs['reg_time']);
				$rs['status_text'] = $rs['is_locked'] ? '<span class="txtred">'.__('user_open').'</span>' : __('user_locked');
				$rs['a_user_edit'] = urr(ADMINCP,"item=users&menu=user&action=user_edit&uid={$rs['userid']}");
				$rs['a_user_lock'] = urr(ADMINCP,"item=users&menu=user&action=user_lock&uid={$rs['userid']}");
				$rs['a_user_delete'] = urr(ADMINCP,"item=users&menu=user&action=user_delete&uid={$rs['userid']}");
				$rs['a_user_viewfile'] = urr(ADMINCP,"item=files&action=index&view=user&uid={$rs['userid']}");
				$rs['wealth'] = $rs['wealth'] ? "(￥{$rs['wealth']})" : "";
				//$rs['my_downlines'] = @$db->result_first("select count(*) from {$tpf}buddys where userid='{$rs['userid']}'");
				$rs[curr_discount_rate] = $rs[discount_rate] ? $rs[discount_rate].'%' : ($settings[discount_rate] ? $settings[discount_rate].'%' : '');
				if($auth[open_discount]){
					$rs[credit_dis] = $rs[curr_discount_rate] ? '/<span class="txtred">'.get_discount($rs[userid],$rs[credit]).'</span>' : '';
				}
				$users[] = $rs;
			}
			$db->free($q);
			unset($rs);

			$q = $db->query("select gid,group_name,group_type from {$tpf}groups order by gid asc");
			$groups = array();
			while($rs = $db->fetch_array($q)){
				$rs['txtcolor'] = $rs['group_type'] ? 'txtblue' : '';
				$groups[] = $rs;
			}
			$db->free($q);
			unset($rs);

			$q = $db->query("select gid,group_name,group_type from {$tpf}groups where gid<>1 order by gid asc");
			$mini_groups = array();
			while($rs = $db->fetch_array($q)){
				$rs['txtcolor'] = $rs['group_type'] ? 'txtblue' : '';
				$mini_groups[] = $rs;
			}
			$db->free($q);
			unset($rs);

			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=users&menu=user&action=index&gid=$gid&orderby=$orderby"));

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'search':
		admin_no_power($task,6,$pd_uid);
		$perpage = 50;
		$word = trim(gpc('word','G',''));
		$o_type = trim(gpc('o_type','G',''));
		$word_str = str_replace('　',' ',replace_inject_str($word));
		$arr = explode(' ',$word_str);
		if(count($arr)>1){
			for($i=0;$i<count($arr);$i++){
				if(trim($arr[$i]) <> ''){
					$str .= " u.{$o_type} like '%{$arr[$i]}%' and";
				}
			}
			$str = substr($str,0,-3);
			$sql_keyword = " and (".$str.")";

		}else{
			$sql_keyword = " and u.{$o_type} like '%{$word_str}%'";
		}
		$sql_do = " {$tpf}users u,{$tpf}groups g where u.gid=g.gid {$sql_keyword}";

		$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;

		$q = $db->query("select u.*,g.gid,g.group_type,g.group_name from {$sql_do} limit $start_num,$perpage");
		$users = array();
		while($rs = $db->fetch_array($q)){
			$rs['reg_time'] = date("Y-m-d H:i:s",$rs['reg_time']);
			$rs['is_admin'] = ($rs['gid']==1) ? 1 : 0;
			$rs['status_text'] = $rs['is_locked'] ? '<span class="txtred">'.__('user_open').'</span>' : __('user_locked');
			$rs['a_user_edit'] = urr(ADMINCP,"item=users&menu=user&action=user_edit&uid={$rs['userid']}");
			$rs['a_user_lock'] = urr(ADMINCP,"item=users&menu=user&action=user_lock&uid={$rs['userid']}");
			$rs['a_user_delete'] = urr(ADMINCP,"item=users&menu=user&action=user_delete&uid={$rs['userid']}");
			$rs['a_user_viewfile'] = urr(ADMINCP,"item=files&menu=user&action=index&view=user&uid={$rs['userid']}");
			$rs['credit'] = $rs['credit'] ? "({$rs['credit']})" : "";
			$users[] = $rs;
		}
		$db->free($q);
		unset($rs);

		$q = $db->query("select gid,group_name,group_type from {$tpf}groups order by gid asc");
		$groups = array();
		while($rs = $db->fetch_array($q)){
			$rs['txtcolor'] = $rs['group_type'] ? 'txtblue' : '';
			$groups[] = $rs;
		}
		$db->free($q);
		unset($rs);

		$q = $db->query("select gid,group_name,group_type from {$tpf}groups where gid<>1 order by gid asc");
		$mini_groups = array();
		while($rs = $db->fetch_array($q)){
			$rs['txtcolor'] = $rs['group_type'] ? 'txtblue' : '';
			$mini_groups[] = $rs;
		}
		$db->free($q);
		unset($rs);

		$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=users&menu=user&action=search&o_type=$o_type&word=".rawurlencode($word).""));

		require_once template_echo($item,$admin_tpl_dir,'',1);
		break;

	case 'user_lock':
		admin_no_power($task,6,$pd_uid);
		if($settings['online_demo']){
			$error = true;
			$sysmsg[] = __('online_demo_deny');
		}
		if(!$error){
			$uid = (int)gpc('uid','G',0);
			$rs = $db->fetch_one_array("select is_locked from {$tpf}users where userid='$uid'");
			$is_locked = $rs['is_locked'] ? 0 : 1;
			unset($rs);
			$db->query_unbuffered("update {$tpf}users set is_locked='$is_locked' where userid='$uid' limit 1");
			redirect($_SERVER['HTTP_REFERER'],'',0);
		}else{
			redirect('back',$sysmsg);
		}
		break;

	case 'user_delete':
		admin_no_power($task,6,$pd_uid);
		if($settings['online_demo']){
			$error = true;
			$sysmsg[] = __('online_demo_deny');
		}
		$num = $db->result_first("select count(*) from {$tpf}files where userid='$uid'");
		if($num){
			$error = true;
			$sysmsg[] = '此用户帐号或回收站中还存在文件，请删除文件后再操作';
		}
		if(!$error){
			$uid = (int)gpc('uid','G',0);
			$db->query_unbuffered("delete from {$tpf}folders where userid='$uid'");
			$db->query_unbuffered("delete from {$tpf}users where userid='$uid'");
			$db->query_unbuffered("update {$tpf}files set is_del=1 where userid='$uid'");
			$db->query_unbuffered("delete from {$tpf}buddys where userid='$uid' or touserid='$uid'");
			$db->query_unbuffered("delete from {$tpf}messages where userid='$uid' or touserid='$uid'");
			if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				$username = @$db->result_first("select username from {$tpf}users where userid='$uid' limit 1");
				if($settings['connect_uc_type']=='phpwind'){
					$arr = uc_user_get($username,1);
					uc_user_delete($arr['uid']);
				}else{
					$result = uc_user_delete($username);
					if(!$result){
						$sysmsg[] = "UC:".__('delete_user_error');
					}
				}
			}
			$sysmsg[] = __('delete_user_success');
			redirect(urr(ADMINCP,"item=users&menu=user&action=index"),$sysmsg);
		}else{
			redirect('back',$sysmsg);
		}
		break;

	case 'add_user':
		admin_no_power($task,3,$pd_uid);
		if($task =='add_user'){
			form_auth(gpc('formhash','P',''),formhash());

			$username = trim(gpc('username','P',''));
			$password = trim(gpc('password','P',''));
			$confirm_password = trim(gpc('confirm_password','P',''));
			$email = trim(gpc('email','P',''));
			$qq = trim(gpc('qq','P',''));
			$gid = (int)gpc('gid','P','');
			$is_locked = (int)gpc('is_locked','P','');
			$credit = (int)gpc('credit','P','');
			$wealth = (float)gpc('wealth','P','');
			$rank = (int)gpc('rank','P','');
			$exp = (int)gpc('exp','P','');
			/*$user_store_space = (int)gpc('user_store_space','P','');
			$user_file_types = trim(gpc('user_file_types','P',''));
			$down_flow_count = (int)gpc('down_flow_count','P','');
			$view_flow_count = (int)gpc('view_flow_count','P','');*/
			$how_downs = (int)gpc('how_downs','P','');
			$how_money = (int)gpc('how_money','P','');

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(checklength($username,2,60)){
				$error = true;
				$sysmsg[] = __('username_error');
			}elseif(is_bad_chars($username)){
				$error = true;
				$sysmsg[] = __('username_has_bad_chars');
			}else{
				$rs = $db->fetch_one_array("select username from {$tpf}users where username='$username' limit 1");
				if($rs){
					if(strcasecmp($username,$rs['username']) ==0){
						$error = true;
						$sysmsg[] = __('username_already_exists');
					}
				}
				unset($rs);
			}
			if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				if($settings['connect_uc_type']=='phpwind'){
					$checkuser = uc_check_username($username);
					if($checkuser<>1){
						$error = true;
						$sysmsg[] = 'UC:'.__('username_already_exists');
					}
				}else{
					$ucresult = uc_user_checkname($username);
					if($ucresult < 0) {
						$error = true;
						$sysmsg[] = 'UC:'.__('username_already_exists');
					}
				}
			}
			if(checklength($password,6,20)){
				$error = true;
				$sysmsg[] = __('password_error');
			}else{
				if($password == $confirm_password){
					$md5_pwd = md5($password);
				}else{
					$error = true;
					$sysmsg[] = __('confirm_password_invalid');
				}
			}
			if(!checkemail($email)){
				$error = true;
				$sysmsg[] = __('invalid_email');
			}else{
				$rs = $db->fetch_one_array("select email from {$tpf}users where email='$email' limit 1");
				if($rs){
					if(strcasecmp($email,$rs['email']) ==0){
						$error = true;
						$sysmsg[] = __('email_already_exists');
					}
					unset($rs);
				}
			}
			if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				if($settings['connect_uc_type']=='phpwind'){
					$ucresult = uc_check_email($email);
					if($ucresult <>1){
						$error = true;
						$sysmsg[] = 'UC:'.__('email_already_exists');
					}
				}else{
					$ucresult = uc_user_checkemail($email);
					if($ucresult < 0) {
						$error = true;
						$sysmsg[] = 'UC:'.__('email_already_exists');
					}
				}
			}

			if(!$error && display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				$uid = uc_user_register($username , $password , $email);
				if($uid <= 0){
					$error = true;
					$sysmsg[] = 'UC: '.__('add_user_error');
				}
			}

			if(!$error){
				$ins = array(
				'username' => $username,
				'password' => $md5_pwd,
				'email' => $email,
				'qq' => $qq,
				'gid' => $gid,
				'credit' => $credit,
				'wealth' => $wealth,
				'rank' => $rank,
				'exp' => $exp,
				'is_locked' => $is_locked,
				/*'user_store_space' => $user_store_space,
				'user_file_types' => $user_file_types,
				'down_flow_count' => $down_flow_count,
				'view_flow_count' => $view_flow_count,*/
				'reg_time' => $timestamp,
				'reg_ip' => $onlineip,
				);

				$db->query("insert into {$tpf}users set ".$db->sql_array($ins).";");
				$rs = $db->fetch_one_array("select count(*) as total from {$tpf}users ");
				if($rs['total']){
					$stats['users_count'] = (int)$rs['total'];
					stats_cache($stats);
				}
				unset($rs);
				$sysmsg[] = __('add_user_success');
				redirect(urr(ADMINCP,"item=users&menu=user&action=index"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$q = $db->query("select gid,group_name,group_type from {$tpf}groups order by gid asc");
			$groups = array();
			while($rs = $db->fetch_array($q)){
				$rs['txtcolor'] = $rs['group_type'] ? 'txtblue' : '';
				$groups[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$default_gid = 4;
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'user_edit':
		admin_no_power($task,6,$pd_uid);
		$uid = (int)gpc('uid','GP',0);
		if($task =='user_edit'){
			form_auth(gpc('formhash','P',''),formhash());

			$password = trim(gpc('password','P',''));
			$income_pwd = trim(gpc('income_pwd','P',''));
			$email = trim(gpc('email','P',''));
			$qq = trim(gpc('qq','P',''));
			$is_locked = (int)gpc('is_locked','P',0);
			$gid = (int)gpc('gid','P',0);
			$credit = (int)gpc('credit','P','');
			$dl_credit = (int)gpc('dl_credit','P','');
			$dl_credit2 = (int)gpc('dl_credit2','P','');
			$wealth = (float)gpc('wealth','P','');

			$mydowns = (int)gpc('mydowns','P','');
			$dl_mydowns = (int)gpc('dl_mydowns','P','');
			$how_downs_credit = trim(gpc('how_downs_credit','P',''));
			$how_money_credit = trim(gpc('how_money_credit','P',''));
			$downline_income = trim(gpc('downline_income','P',''));
			$downline_income2 = trim(gpc('downline_income2','P',''));
			$discount_rate = trim(gpc('discount_rate','P',''));
			$open_custom_stats = (int)gpc('open_custom_stats','P',0);
			$stat_code = trim(gpc('stat_code','P',''));
			$space_pwd = trim(gpc('space_pwd','P',''));
			$check_custom_stats = (int)gpc('check_custom_stats','P',0);
			$meta_title = trim(gpc('meta_title','P',''));
			$meta_keywords = trim(gpc('meta_keywords','P',''));
			$meta_description = trim(gpc('meta_description','P',''));
			if($auth[open_user_select]){
				$plan_id = (int)gpc('plan_id','P',0);
			}else{
				$plan_id = (int)@$db->result_first("select plan_id from {$tpf}users where userid='$uid' limit 1");
			}
			if($auth[buy_vip_a] || $auth[buy_vip_p]){
				$vip_id = (int)gpc('vip_id','P',0);
			}

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if($password){
				if(checklength($password,6,20)){
					$error = true;
					$sysmsg[] = __('invalid_password');
				}else{
					$md5_pwd = md5($password);
				}
			}else{
				$rs = $db->fetch_one_array("select password from {$tpf}users where userid='$uid'");
				$md5_pwd = $rs['password'];
			}
			if($income_pwd){
				if(checklength($income_pwd,6,20)){
					$error = true;
					$sysmsg[] = __('invalid_password');
				}else{
					$income_pwd = md5($income_pwd);
				}
			}else{
				$income_pwd = @$db->result_first("select income_pwd from {$tpf}users where userid='$uid'");
			}
			if($gid>1){
				$rs = $db->fetch_one_array("select count(*) as total from {$tpf}users where gid=1 and userid<>'$uid'");
				if(!$rs['total']){
					$error = true;
					$sysmsg[] = __('only_one_admin');
				}
				unset($rs);
			}
			if(!checkemail($email)){
				$error = true;
				$sysmsg[] = __('invalid_email');
			}else{
				$rs = $db->fetch_one_array("select email from {$tpf}users where email='$email' and userid<>'$uid'");
				if($rs){
					if(strcasecmp($email,$rs['email']) ==0){
						$error = true;
						$sysmsg[] = __('email_already_exists');
					}
					unset($rs);
				}
			}
			$user_store_space = $user_store_space ? $user_store_space : 0;
			if($user_file_types && substr($user_file_types,strlen($user_file_types)-1,1) ==','){
				$user_file_types = substr($user_file_types,0,-1);
			}
			if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				$old_pwd = $db->result_first("select password from {$tpf}users where userid='$uid'");
				if($settings['connect_uc_type']=='phpwind'){
					uc_user_edit($pd_uid, $pd_username, $pd_username, $password, $email);
				}else{
					$ucresult = uc_user_edit($username, $old_pwd, $password,$email,1);
					if($ucresult < 0) {
						$error = true;
						$sysmsg[] = 'UC:'.__('update_password_error');
					}
				}
			}

			if(!$error){
				if($auth[pd_a]){
					update_seo('space',$uid,$meta_title,$meta_keywords,$meta_description);
				}
				$curr_plan_id = get_profile($uid,'plan_id');
				$ins = array(
				'password' => $md5_pwd,
				'email' => $email,
				'qq' => $qq,
				'is_locked' => $is_locked,
				'gid' => $gid,
				'credit' => $credit,
				'dl_credit' => (int)$dl_credit,
				'dl_credit2' => (int)$dl_credit2,
				'wealth' => $wealth,
				'credit_rate' => merge_rate($how_downs_credit,$how_money_credit),
				'downline_income' => $downline_income,
				'discount_rate'=>$discount_rate,
				'open_custom_stats' => $open_custom_stats,
				'stat_code' => $stat_code ? base64_encode($stat_code) : '',
				'check_custom_stats' => $check_custom_stats,
				'space_pwd' => $space_pwd,
				'income_pwd' => $income_pwd,
				'plan_id'=>(int)$plan_id,
				//'credit_rate'=>get_plans($plan_id,'income_rate'),
				'vip_id'=>(int)$vip_id,
				'vip_end_time'=>$timestamp+get_vip($vip_id,'days')*86400,
				);
				$db->query_unbuffered("update {$tpf}users set ".$db->sql_array($ins)." where userid='$uid';");
				if($plan_id && $curr_plan_id!=$plan_id){
					conv_credit($uid);
					$db->query_unbuffered("update {$tpf}users set credit_rate='".get_plans($plan_id,'income_rate')."' where userid='$uid' limit 1");
				}
				$sysmsg[] = __('user_edit_success');
				redirect(urr(ADMINCP,"item=users&menu=user&action=user_edit&uid=$uid"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$q = $db->query("select gid,group_name,group_type from {$tpf}groups order by gid asc");
			$groups = array();
			while($rs = $db->fetch_array($q)){
				$rs['txtcolor'] = $rs['group_type'] ? 'txtblue' : '';
				$groups[] = $rs;
			}
			$db->free($q);
			unset($rs);

			$q = $db->query("select subject,plan_id from {$tpf}plans order by plan_id asc");
			$plans = array();
			while ($rs = $db->fetch_array($q)) {
				$plans[] = $rs;
			}
			$db->free($q);
			unset($rs);

			$q = $db->query("select subject,vip_id from {$tpf}vips order by vip_id asc");
			$vips = array();
			while ($rs = $db->fetch_array($q)) {
				$vips[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$vip_end_time = get_profile($uid,'vip_end_time');
			$vip_end_time_txt = $vip_end_time ? date('Y-m-d H:i:s',$vip_end_time) : '';

			$myinfo = get_profile($uid);
			$user = $db->fetch_one_array("select * from {$tpf}users where userid='$uid' limit 1");
			if($user){
				$user[stat_code] = $user[stat_code] ? stripslashes(base64_decode($user[stat_code])) : '';
				if($user[plan_id]){
					$user[plan_subject] = $db->result_first("select subject from {$tpf}plans where plan_id='$user[plan_id]'");
					$user[readonly] = 'readonly';
				}else{
					$user[plan_subject] = __('not_set');
					$user[readonly] = '';
				}
				$q = $db->query("select u.username,u.userid from {$tpf}buddys b,{$tpf}users u where b.touserid=u.userid and b.userid='{$user['userid']}'");
				$buddy_list = array();
				while ($rs = $db->fetch_array($q)) {
					$rs['a_user_edit'] = urr(ADMINCP,"item=users&menu=user&action=user_edit&uid={$rs['userid']}");
					$buddy_list[] = $rs;
				}
				$db->free($q);
				unset($rs);
			}
			$curr_credit_rate = $myinfo[credit_rate] ? exp_credit_rate($myinfo[credit_rate]) : (($settings[how_downs_credit] && $settings[how_money_credit]) ? $settings[how_downs_credit].'=='.$settings[how_money_credit] : __('not_set'));
			$curr_downline_rate = $myinfo[downline_income] ? $myinfo[downline_income].'%' : ($settings[downline_income] ? $settings[downline_income].'%' : __('not_set'));
			$curr_downline_rate2 = $myinfo[downline_income2] ? $myinfo[downline_income2].'%' : ($settings[downline_income2] ? $settings[downline_income2].'%' : __('not_set'));
			$curr_discount_rate = $myinfo[discount_rate] ? $myinfo[discount_rate].'%' : ($settings[discount_rate] ? $settings[discount_rate].'%' : __('not_set'));

			$add_discount = get_discount($uid,$myinfo[credit],'desc');
			if($auth[pd_a]){
				$s = get_seo('space',$uid);
			}

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'adminlogout':
		$db->query_unbuffered("update {$tpf}adminsession set hashcode='' where userid='$pd_uid'");
		$sysmsg[] = __('system_logout_success');
		redirect('javascript:self.parent.close();',$sysmsg);
		break;

	case 'orders':
		admin_no_power($task,7,$pd_uid);
		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());
			$order_ids = gpc('order_ids','P',array());
			$o_status = gpc('o_status','P',array());

			if(!$error){
				for($i =0;$i<count($order_ids);$i++){
					$tmp = $db->escape($o_status[$i]);
					if($tmp){
						$db->query_unbuffered("update {$tpf}income_orders set o_status='$tmp' where order_id='".(int)$order_ids[$i]."'");
						if($tmp =='fail'){
							$rs = $db->fetch_one_array("select money,userid from {$tpf}income_orders where order_id='".(int)$order_ids[$i]."'");
							if($rs){
								$wealth = (int)$rs['money'];
								$userid = $rs['userid'];
							}
							unset($rs);
							$db->query_unbuffered("update {$tpf}users set wealth=wealth+$wealth where userid='$userid'");
						}
					}
				}
				$sysmsg[] = __('order_status_update_success');
				redirect(urr(ADMINCP,"item=$item&menu=user&action=$action"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$word = gpc('word','G','');
			$view = trim(gpc('view','G',''));
			$sql_ext = (!$view || $view=='all') ? '' : " and uo.o_status='$view' ";
			if($word){
				$userid = @$db->result_first("select userid from {$tpf}users where username='$word'");
				if(!$userid){
					echo '<script>alert("'.__('username').'['.$word.']'.__('not_found').');</script>';
				}else{
					$sql_ext = $sql_ext ? $sql_ext." and uo.userid='$userid' " : '';
				}
			}
			$perpage = 50;
			$sql_do = "{$tpf}income_orders uo,{$tpf}users u where u.userid=uo.userid $sql_ext";
			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select uo.*,u.username,u.userid from {$sql_do} order by order_id desc limit $start_num,$perpage");
			$logs = array();
			while($rs = $db->fetch_array($q)){
				$rs['status_txt'] = ($rs['o_status']=='success' || $rs['o_status']=='fail') ? get_income_status($rs['o_status']) : '';
				$rs['a_view'] = urr(ADMINCP,"item=users&menu=user&action=user_edit&uid={$rs['userid']}");
				$rs['in_time'] = date("Y-m-d H:i:s",$rs['in_time']);
				$logs[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=user&action=$action"));

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'credit_log':
		if($task=='update'){
			form_auth(gpc('formhash','P',''),formhash());
			$setting = array(
			'show_credit_log' => 0,
			'close_credit_log' => 0,
			);
			$settings = gpc('setting','P',$setting);
			if(!$error){
				settings_cache($settings);
				$sysmsg[] = '积分配置管理更新成功';
				redirect(urr(ADMINCP,"item=$item&menu=$menu&action=$action"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$log_count = @$db->result_first("select count(*) from ".get_table_credit_log()."");
			$perpage = 50;
			$userid = (int)gpc('userid','G',0);
			$task_sql = in_array($task,array('download','ref')) ? " p.action='$task' and" : '';
			$uid_sql = $userid ? " p.userid='$userid' and" : '';
			$sql_do = get_table_credit_log()." p,{$tpf}files f,{$tpf}users u where $task_sql $uid_sql p.userid=u.userid and p.file_id=f.file_id";
			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select p.*,f.file_name,f.file_extension,u.username from {$sql_do} order by p.in_time desc limit $start_num,$perpage");
			$orders = array();
			while($rs = $db->fetch_array($q)){
				$rs[a_view] = urr(ADMINCP,"item=$item&menu=$menu&action=$action&userid={$rs[userid]}");
				$rs[action] = $ca_arr[$rs[action]];
				$tmp_ext = $rs[file_extension] ? '.'.$rs[file_extension] : '';
				$rs[file_name] = $rs[file_name].$tmp_ext;
				$rs['in_time'] = date('Y-m-d H:i:s',$rs['in_time']);
				$orders[] = $rs;
			}
			$db->free($q);
			unset($rs);

			$page_nav = multi($total_num, $perpage, $pg, urr(ADMINCP,"item=$item&menu=$menu&action=$action&task=$task&userid=$userid"));
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	default:
		redirect(urr(ADMINCP,"item=users&menu=user&action=index"),'',0);
}
function merge_rate($downs,$money){
	return ($downs && $money) ? $downs.','.$money : '';
}


?>
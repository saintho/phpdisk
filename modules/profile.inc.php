<?php
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: profile.inc.php 126 2014-03-17 07:51:04Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

$myinfo = get_profile($pd_uid);
$curr_downline_rate = $myinfo[downline_income] ? $myinfo[downline_income].'%' : ($settings[downline_income] ? $settings[downline_income].'%' : 0);

switch($action){
	case 'files':
		$folder_id = (int)gpc('folder_id','GP',0);

		$nav_path = '<a href="'.urr("mydisk","item=profile&action=files").'">文件管理</a>&raquo; '.nav_path($folder_id,$pd_uid,0,1);

		if($task=='search'){
			$word = trim(gpc('word','G',''));
			$sql_tmp = $word ? " and (file_name like '%$word%' or file_extension like '%$word%')" : '';
			if($folder_id){
				$sql_do = "{$tpf}files where userid='$pd_uid' and is_del=0 and folder_id='$folder_id' $sql_tmp";
			}else{
				$sql_do = "{$tpf}files where userid='$pd_uid' and is_del=0 and folder_id='0' $sql_tmp";
			}
		}else{
			if($folder_id){
				$sql_do = "{$tpf}files where userid='$pd_uid' and is_del=0 and folder_id='$folder_id'";
			}else{
				$sql_do = "{$tpf}files where userid='$pd_uid' and is_del=0 and folder_id='0'";
			}
		}
		if($task!='search' && $pg==1){
			$q = $db->query("select fd.*,u.username from {$tpf}folders fd,{$tpf}users u where fd.parent_id='$folder_id' and fd.userid='$pd_uid' and fd.userid=u.userid order by folder_order asc,folder_id desc");
			$folders_array = array();
			while ($rs = $db->fetch_array($q)) {
				$rs[a_folder_view] = urr("mydisk","item=profile&action=files&folder_id={$rs[folder_id]}");
				$rs[a_folder] = urr("space","username=".rawurlencode($rs[username])."&folder_id={$rs[folder_id]}");
				$rs[a_edit] = urr("mydisk","item=folders&action=modify_folder&folder_id={$rs[folder_id]}");
				$rs[a_del] = urr("mydisk","item=folders&action=folder_delete&folder_id={$rs[folder_id]}");
				$rs[folder_size] = get_size($rs[folder_size]);
				$rs[in_time] = date('Y-m-d H:i:s',$rs[in_time]);
				$folders_array[] = $rs;
			}
			$db->free($q);
			unset($rs);
		}

		$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;

		$q = $db->query("select * from {$sql_do} order by show_order asc, file_id desc limit $start_num,$perpage");
		$files_array = array();
		while($rs = $db->fetch_array($q)){
			$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
			$rs['file_thumb'] = get_file_thumb($rs);
			$rs['file_name_all'] = $rs['file_name'].$tmp_ext;
			$rs['file_name'] = cutstr($rs['file_name'].$tmp_ext,80);
			$rs['file_new'] = ($timestamp-$rs['file_time']<86400) ? '<img src="images/new.png" align="absmiddle" border="0"/>' : '';
			$rs['file_time'] = date('Y-m-d H:i:s',$rs[file_time]);
			$rs['file_size'] = get_size($rs['file_size']);
			$rs[file_description] = clear_html(filter_word($rs['file_description']),80);
			$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
			$rs['a_modify'] = urr("mydisk","item=files&action=modify_file&file_id={$rs['file_id']}");
			$files_array[] = $rs;
		}
		$db->free($q);
		unset($rs);

		$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=$item&action=$action&folder_id=$folder_id"));
		if($task=='search'){
			$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=$item&action=$action&task=$task&folder_id=$folder_id&word=".rawurlencode($word)));
		}else{
			$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=$item&action=$action&folder_id=$folder_id"));
		}
		require_once template_echo('profile',$user_tpl_dir);
		break;
	case 'course_manage':
		if($task == 'search'){

		}else{
			$course_array = get_course_list();
		}
		$nav_path = '<a href="'.urr("mydisk","item=profile&action=course_manage").'">课程管理</a>&raquo; ';
		require_once template_echo('profile',$user_tpl_dir);
		break;
	case 'chapter_section_manage':
		$course_id = gpc('course_id','G','');
		$chapter_section_array = get_chapter_section_list($course_id);
		$nav_path = '<a href="'.urr("mydisk","item=profile&action=course_manage").'">课程管理</a>&raquo; '.nav_path_course($course_id,$pd_uid,0,1);
		require_once template_echo('profile',$user_tpl_dir);
		break;
	case 'course_review':
		$perpage = 20;
		$start_num = ($pg-1) * $perpage;
		$sql = "SELECT c.*, cg.cate_name FROM {$tpf}course c LEFT JOIN {$tpf}categories cg ON c.cate_id = cg.cate_id WHERE user_id = {$pd_uid} limit $start_num,$perpage";
		$q = $db->query($sql);
		$course_array = array();
		while($rs = $db->fetch_array($q)) {
			$rs['create_date'] = date('Y-m-d H:i:s',$rs[create_date]);
			$rs['update_date'] = date('Y-m-d H:i:s',$rs[update_date]);
			$rs['status'] = $defineCouser[$rs['status']]?$defineCouser[$rs['status']]:'未定义状态';
			$rs['a_edit'] = urr("mydisk","item=course&action=modify_course&course_id={$rs['courseid']}");
			$rs['a_del'] = urr("mydisk","item=course&action=course_delete&course_id={$rs['courseid']}");
			$rs['a_online_review'] = urr("mydisk", "item=profile&action=chapter_section_manage&course_id={$rs['courseid']}");
			$course_array[] = $rs;
		}
		require_once template_echo('profile',$user_tpl_dir);
		break;
	case 'mod_pwd':
		if($task =='mod_pwd'){
			form_auth(gpc('formhash','P',''),formhash());

			$old_pwd = trim(gpc('old_pwd','P',''));
			$new_pwd = trim(gpc('new_pwd','P',''));
			$cfm_pwd = trim(gpc('cfm_pwd','P',''));

			$rs = $db->fetch_one_array("select userid from {$tpf}users where password='".md5($old_pwd)."' and userid='$pd_uid'");
			if(!$rs){
				$error = true;
				$sysmsg[] = __('invalid_password');
			}
			unset($rs);
			if(checklength($new_pwd,6,20)){
				$error = true;
				$sysmsg[] = __('password_max_min');
			}elseif($new_pwd != $cfm_pwd){
				$error = true;
				$sysmsg[] = __('confirm_password_invalid');
			}else{
				$md5_pwd = md5($new_pwd);
			}
			if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				$ucresult = uc_user_edit($pd_username, $old_pwd, $new_pwd,'');
				if($ucresult < 0) {
					$error = true;
					$sysmsg[] = 'UC:'.__('invalid_password');
				}
			}
			if(!$error){
				$sql = "update {$tpf}users set password='$md5_pwd' where userid='$pd_uid'";
				$db->query_unbuffered($sql);
				pd_setcookie('phpdisk_zcore_info','');
				$sysmsg[] = __('password_modify_success');
				redirect(urr("account","action=login"),$sysmsg,2000,'top');
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task=='mod_pwd2'){
			form_auth(gpc('formhash','P',''),formhash());

			$old_pwd = trim(gpc('old_pwd','P',''));
			$new_pwd = trim(gpc('new_pwd','P',''));
			$cfm_pwd = trim(gpc('cfm_pwd','P',''));

			$rs = $db->fetch_one_array("select userid from {$tpf}users where income_pwd='".md5($old_pwd)."' and userid='$pd_uid'");
			if(!$rs){
				$error = true;
				$sysmsg[] = '当前提现密码不正确';
			}
			unset($rs);
			if(checklength($new_pwd,6,20)){
				$error = true;
				$sysmsg[] = __('password_max_min');
			}elseif($new_pwd != $cfm_pwd){
				$error = true;
				$sysmsg[] = '确认提现密码不正确';
			}else{
				$md5_pwd = md5($new_pwd);
			}
			if(!$error){
				$sql = "update {$tpf}users set income_pwd='$md5_pwd' where userid='$pd_uid'";
				$db->query_unbuffered($sql);
				$sysmsg[] = '提现密码修改成功';
				redirect(urr("mydisk","item=profile&action=$action"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			require_once template_echo('profile',$user_tpl_dir);
		}
		break;
	case 'mod_stat':
		if($settings[global_open_custom_stats] && get_profile($pd_uid,'open_custom_stats')){
			if($task=='mod_stat'){
				auth_task($task);
			}else{
				$arr = auth_action($action);
				$stat_code = stripslashes(base64_decode($arr[stat_code]));
				$check_txt = $arr[check_custom_stats] ? __('checked_txt') : __('unchecked_txt');
				require_once template_echo('profile',$user_tpl_dir);
			}
		}else{
			$sysmsg[] = __('custom_stats_not_open');
			redirect('back',$sysmsg);
		}
		break;
	case 'myannounce':
		if($task=='my announce'){
			auth_task($task);
		}else{
			$my_announce = auth_action($action);
			require_once template_echo('profile',$user_tpl_dir);
		}
		break;
	case 'income':
		$same_pwd = @$db->result_first("select count(*) from {$tpf}users where password=income_pwd and userid='$pd_uid'");
		$rs = $db->fetch_one_array("select * from {$tpf}users where userid='$pd_uid'");
		if($rs){
			$wealth_lost = $rs['wealth_lost'] ? (int)$rs['wealth_lost'] : ($settings['wealth_lost'] ? (int)$settings['wealth_lost'] : 0);
			$wealth = $rs['wealth'];
			$income_account = $rs['income_account'];
			$income_name = $rs['income_name'];
			$income_type = $rs['income_type'];
			$income_type_txt = $arr[$income_type];
			$mydowns = $rs['mydowns'];
			$dl_mydowns = $rs['dl_mydowns'];

			$tmp = unserialize($rs['money_rate']);
			if($tmp['how_downs'] && $tmp['how_money']){
				$how_downs = $tmp['how_downs'];
				$how_money = $tmp['how_money'];
			}else{
				$how_downs = $settings['how_downs'];
				$how_money = $settings['how_money'];
			}
		}
		unset($rs);

		if($task =='to_income'){
			form_auth(gpc('formhash','P',''),formhash());
			$money = trim(gpc('money','P',''));
			$income_pwd = gpc('income_pwd','P','');

			if(!is_numeric($money)){
				$error = true;
				$sysmsg[] = __('money_not_numeric');
			}else{
				$money = (int)$money;
			}
			if(!$income_pwd || md5($income_pwd)!=$myinfo[income_pwd]){
				$error = true;
				$sysmsg[] = '提现密码不正确';
			}
			if((int)$settings['min_to_income'] > $money){
				$error = true;
				$sysmsg[] = __('min_to_income').$settings['min_to_income'];
			}
			if($wealth <$money){
				$error = true;
				$sysmsg[] = __('your_input_too_big');
			}else{
				$now_wealth = $wealth-$money;
			}
			if(!$income_account || !$income_name){
				$error = true;
				$sysmsg[] = __('income_account_not_set');
			}

			if(!$error){
				$ins = array(
				'order_number' => get_order_number(),
				'income_account' => $income_account,
				'income_name' => $income_name,
				'income_type' => $income_type,
				'o_status' => 'pendding',
				'userid' => $pd_uid,
				'money' => $money,
				'ip' => $onlineip,
				'in_time' => $timestamp,
				);
				$db->query_unbuffered("insert into {$tpf}income_orders set ".$db->sql_array($ins)."");
				$db->query_unbuffered("update {$tpf}users set wealth=$now_wealth where userid='$pd_uid'");
				$sysmsg[] = __('add_income_order_success');
				redirect('back',$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$curr_credit_rate = $myinfo[credit_rate] ? exp_credit_rate($myinfo[credit_rate]) : (($settings[how_downs_credit] && $settings[how_money_credit]) ? $settings[how_downs_credit].'==￥'.$settings[how_money_credit] : '');

			$freeze_money = @$db->result_first("select sum(money) from {$tpf}income_orders where userid='$pd_uid' and o_status='pendding'");
			$freeze_money = $freeze_money ? '<span class="txtgray">（'.__('incoming').':￥'.$freeze_money.'）</span>' : '';
			$my_downlines = @$db->result_first("select count(*) from {$tpf}buddys where userid='$pd_uid'");
			require_once template_echo('profile',$user_tpl_dir);
		}
		break;
	case 'income_log':
		$sql_do = " {$tpf}income_orders io,{$tpf}users u where io.userid=u.userid and io.userid='$pd_uid'";
		$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;

		$q = $db->query("select * from {$sql_do} order by order_id desc limit $start_num,$perpage");
		$orders = array();
		while($rs = $db->fetch_array($q)){
			$rs['o_status'] = get_income_status($rs['o_status']);
			$rs['in_time'] = date('Y-m-d H:i:s',$rs['in_time']);
			$orders[] = $rs;
		}
		$db->free($q);
		unset($rs);

		$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=profile&action=income_log"));
		require_once template_echo('profile',$user_tpl_dir);
		break;
	case 'credit_log':
		if($auth[view_credit]){
			$sql_do = "(p.action='download' or p.action='view')";
		}else{
			$sql_do = "p.action='download'";
		}
		$sql_do = get_table_credit_log()." p,{$tpf}files f where $sql_do and p.userid='$pd_uid' and p.file_id=f.file_id";
		$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;

		$q = $db->query("select p.*,f.file_name,file_extension from {$sql_do} order by p.in_time desc limit $start_num,$perpage");
		$orders = array();
		while($rs = $db->fetch_array($q)){
			$tmp_ext = $rs[file_extension] ? '.'.$rs[file_extension] : '';
			$rs[file_name] = $rs[file_name].$tmp_ext;
			$rs[action] = $ca_arr[$rs[action]];
			$rs['in_time'] = date('Y-m-d',$rs['in_time']);
			$orders[] = $rs;
		}
		$db->free($q);
		unset($rs);

		$page_nav = multi($total_num, $perpage, $pg, urr("mydisk","item=profile&action=$action"));
		require_once template_echo('profile',$user_tpl_dir);
		break;
	case 'invite':
		$invite_url = $settings['invite_register_encode'] ? $settings['phpdisk_url'].urr("account","action=register&".pd_encode('uid='.$pd_uid)) : $settings['phpdisk_url'].urr("account",'action=register&uid='.$pd_uid);
		// my downlines
		$my_downlines = @$db->result_first("select count(*) from {$tpf}buddys where userid='$pd_uid'");
		require_once template_echo('profile',$user_tpl_dir);
		break;
	case 'application_teacher':
		if($task == 'save_image'){
			//清除显示
			ob_end_clean();
			//增加保存图片的代码
			require(PHPDISK_ROOT.'includes/class/upload.class.php');
			$upload=new upload('file',APPLICATION_MATERIALS_DIR);
			$fileName=$upload->uploadFile();
			echo json_encode(array('status' => 'ok', 'data'=>array('filename'=>basename($fileName)), 'msg'=>'成功上传文件'));
			exit;
		}
		elseif($task == 'application_add'){
			//检查是否存在提交的信息
			$application_one = get_application_teacher_status();
			if($application_one){
				$sysmsg = array('不能重复申请,请先取消当前教师申请');
				redirect('back',$sysmsg);
				exit;
			}
			//申请提交的代码
			form_auth(gpc('formhash','P',''),formhash());
			$user_name = gpc('user_name');
			$sex = gpc('sex');
			$age = gpc('age');
			$introduce = gpc('introduce');
			$education_pic = gpc('education');
			$job_pic = gpc('job');
			$teacher_pic = gpc('teacher');
			$user_id = $myinfo['userid'];
			$status = 1;
			$cur_date = time();
			if(empty($user_name) || empty($sex) || empty($age) || empty($introduce) || empty($education_pic) ||
				empty($job_pic) || empty($teacher_pic) ){
				$sysmsg = array('输入信息不完整');
				redirect('back',$sysmsg);
				exit;
			}
			$sql = "INSERT INTO {$tpf}application_teacher (
					user_id, status, create_date, last_update, check_num, user_name, sex, age, introduce,
					education_pic, job_pic, teacher_pic
					) VALUES (
					$user_id, $status, '$cur_date', '$cur_date', 1, '$user_name', $sex, $age, '$introduce',
					'$education_pic', '$job_pic', '$teacher_pic'
					)";
			$result_add = $db->query($sql);
			if($result_add){
				//添加成功
				$sysmsg = array('提交申请成功,请静候佳音');
				redirect('mydisk.php?item=profile&action=application_teacher&task=application_progress',$sysmsg);
				exit;
			}else{
				//添加失败
				$sysmsg = array('系统出错,添加失败');
				redirect('back',$sysmsg);
				exit;
			}
		}
		elseif($task == 'application_cancel'){
			//申请取消的代码
			$user_id = $myinfo['userid'];
			$sql = "DELETE FROM {$tpf}application_teacher WHERE user_id = {$user_id}";
			$result_del = $db->query($sql);
			if($result_del){
				$sysmsg = array('取消申请成功');
				redirect('back',$sysmsg);
				exit;
			}else{
				$sysmsg = array('系统错误,取消申请失败');
				redirect('back',$sysmsg);
				exit;
			}
		}
		elseif($task == 'application_progress'){
			//查看申请进度的代码
			//检查是否提交过申请
			$application_one = get_application_teacher_status();
			if(!$application_one){
				$sysmsg = array('申请还没提交,正在进入申请页面');
				redirect('mydisk.php?item=profile&action=application_teacher',$sysmsg);
				exit;
			}else{
				require_once template_echo('profile',$user_tpl_dir);
			}
		}
		else{
			//界面的显示代码
			//检查是否提交过申请
			$application_one = get_application_teacher_status();
			if($application_one){
				$sysmsg = array('申请已提交,正在查看你的审核进度');
				redirect('mydisk.php?item=profile&action=application_teacher&task=application_progress',$sysmsg);
				exit;
			}
			require_once template_echo('profile',$user_tpl_dir);
		}
		break;
	case 'chg_logo':
		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());
			$file = $_FILES['filedata'];

			//$tmp_username = convert_str('utf-8','gbk',$pd_username);
			//$file_real_path = PHPDISK_ROOT.$settings['file_path'].'/'.$tmp_username.'/';
			$file_real_path = PHPDISK_ROOT.$settings['file_path'].'/';
			$file_store_path = date('Y/m/d/');

			//$file_name = convert_str('utf-8','gbk',$file['name']);
			$file_extension = get_extension($file['name']);
			$file_name = md5(uniqid().$timestamp.$pd_uid).'.'.$file_extension;
			$dest_file = $file_real_path.$file_store_path.$file_name;
			make_dir($file_real_path.$file_store_path);


			if(!in_array($file_extension,array('png','jpg','gif')) || $file['size']>200*1024){
				$error = true;
				$sysmsg[] = __('logo_img_error');
			}
			$img_arr = @getimagesize($file['tmp_name']);
			if($img_arr[0] >480 || $img_arr[1] >150){
				$error = true;
				$sysmsg[] = __('logo_size_error');
			}
			if(!$img_arr[2]){
				$error = true;
				$sysmsg[] = __('please_use_img_file');
			}

			if(!$error){
				if(upload_file($file['tmp_name'],$dest_file)){
					$logo = @$db->result_first("select logo from {$tpf}users where userid='$pd_uid'");
					if($logo){
						@unlink($file_real_path.$logo);
					}
					$ins = array(
					'logo' => $file_store_path.$file_name,
					);
					$db->query_unbuffered("update {$tpf}users set ".$db->sql_array($ins)." where userid='$pd_uid'");
					$sysmsg[] = __('logo_upload_success');
					redirect('back',$sysmsg);
				}
			}else{
				redirect('back',$sysmsg);
			}
			@unlink($file['tmp_name']);

		}elseif($task =='chg_url'){
			form_auth(gpc('formhash','P',''),formhash());
			$logo_url = trim(gpc('logo_url','P',''));

			if(!$logo_url){
				$error = true;
				$sysmsg[] =__('logo_url_error');
			}
			if(!$error){
				$ins = array(
				'logo_url' => $logo_url,
				);
				$db->query_unbuffered("update {$tpf}users set ".$db->sql_array($ins)." where userid='$pd_uid'");
				$sysmsg[] = __('logo_url_update_success');
				redirect('back',$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task =='mod_pro'){

			form_auth(gpc('formhash','P',''),formhash());
			$space_name = trim(gpc('space_name','P',''));

			if(checklength($space_name,1,250)){
				$error = true;
				$sysmsg[] = __('space_name_error');
			}
			if(!$error){
				$ins = array(
				'space_name' => htmlspecialchars($space_name),
				);
				$db->query_unbuffered("update {$tpf}users set ".$db->sql_array($ins)." where userid='$pd_uid'");
				$sysmsg[] = __('space_name_update_success');
				redirect('back',$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}elseif($task=='mod_domain'){
			auth_task_mod_domain();
		}elseif($task=='space_pwd'){
			auth_task_space_pwd();
		}else{
			$rs = $db->fetch_one_array("select space_name,logo,logo_url,domain,space_pwd from {$tpf}users where userid='$pd_uid'");
			if($rs){
				$space_name = $rs['space_name'];
				$logo = $rs['logo'];
				$logo_url = $rs['logo_url'];
				$domain = $rs['domain'];
				$space_pwd = $rs['space_pwd'];
			}
			unset($rs);
			//$tmp_username = convert_str('utf-8','gbk',$pd_username);
			$logo = $logo ? $settings['file_path'].'/'.$logo : $user_tpl_dir.'images/logo.png';
			$logo_url = $logo_url ? $logo_url : urr("space","username=".rawurlencode($pd_username));
			require_once template_echo($item,$user_tpl_dir);
		}
		break;

	case 'income_set':
		if($task=='income_set'){
			form_auth(gpc('formhash','P',''),formhash());
			$income_account = trim(gpc('income_account','P',''));
			$income_name = trim(gpc('income_name','P',''));
			$income_type = trim(gpc('income_type','P',''));

			if(!$error){
				$ins = array(
				'income_account' => $income_account,
				'income_name' => $income_name,
				'income_type' => $income_type,
				);
				$db->query_unbuffered("update {$tpf}users set ".$db->sql_array($ins)." where userid='$pd_uid'");
				$sysmsg[] = __('income_set_update_success');
				redirect('back',$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$rs = $db->fetch_one_array("select income_account,income_name,income_type from {$tpf}users where userid='$pd_uid'");
			if($rs){
				$income_account = $rs['income_account'];
				$income_name = $rs['income_name'];
				$income_type = $rs['income_type'];
			}
			unset($rs);
			require_once template_echo('profile',$user_tpl_dir);
		}
		break;

	case 'income_plans':
		if($task=='open_plan'){
			conv_credit($pd_uid);
			$db->query_unbuffered("update {$tpf}users set open_plan=1 where userid='$pd_uid'");
			$sysmsg[] = __('open_plan_success');
			redirect('back',$sysmsg);

		}elseif($task=='close_plan'){
			conv_credit($pd_uid);
			$ins = array(
			'open_plan'=>0,
			'plan_id'=>0,
			'credit_rate'=>'',
			);
			$db->query_unbuffered("update {$tpf}users set ".$db->sql_array($ins)." where userid='$pd_uid'");
			$sysmsg[] = __('close_plan_success');
			redirect('back',$sysmsg);

		}elseif($task=='income_plans'){
			form_auth(gpc('formhash','P',''),formhash());
			$plan_id = (int)gpc('plan_id','P',0);

			if(!$plan_id){
				$error = true;
				$sysmsg[] = __('select_plans_error');
			}

			if(!$error){
				conv_credit($pd_uid);
				$ins = array(
				'plan_id'=>$plan_id,
				'credit_rate'=>get_plans($plan_id,'income_rate'),
				);
				$db->query_unbuffered("update {$tpf}users set ".$db->sql_array($ins)." where userid='$pd_uid'");
				$sysmsg[] = __('select_plan_success');
				redirect(urr("mydisk","item=profile&action=$action"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$q = $db->query("select * from {$tpf}plans where is_hidden=0 order by show_order asc,plan_id asc");
			$plans = array();
			while ($rs = $db->fetch_array($q)) {
				if($rs[income_rate]){
					$arr = explode(',',$rs[income_rate]);
					if(count($arr)){
						$rs[income_rate_credit] = $arr[0];
						$rs[income_rate_money] = $arr[1];
					}
					$rs[plans_rate] = $arr[0].__('credit').'=='.$arr[1].__('currency_unit');
				}
				$plans[] = $rs;
			}
			$db->free($q);
			unset($rs);
			require_once template_echo('profile',$user_tpl_dir);
		}
		break;
	case 'forum_upload':

		if($task =='forum_upload_super' || $task =='forum_upload_min'){
			$plugin_type = trim(gpc('plugin_type','P',''));
			$folder_id = (int)gpc('folder_id','P',0);
			$code_arr = auth_task($task,$_POST,$_GET);
			$code = $code_arr[$task];

		}
		require_once template_echo('profile',$user_tpl_dir);

		break;

	case 'dl_users':
		$perpage = 20;
		$sql_do = "{$tpf}buddys b,{$tpf}users u where b.userid='$pd_uid' and b.touserid=u.userid";
		$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
		$total_num = $rs['total_num'];
		$start_num = ($pg-1) * $perpage;

		$q = $db->query("select u.credit,u.username,u.qq,u.userid,b.is_system from $sql_do order by bdid desc limit $start_num,$perpage");
		$buddys = array();
		while ($rs = $db->fetch_array($q)) {
			$rs[credit] = get_discount($rs[userid],$rs[credit]);
			$rs[is_system] = $rs[is_system] ? __('system_promo') : __('self_promo');
			$rs[a_space] = urr("space","username=".rawurlencode($rs[username]));
			$rs[qq] = $rs[qq] ? '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$rs[qq].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$rs[qq].':52" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>' : '';
			$buddys[] = $rs;
		}
		$db->free($q);
		unset($rs);
		$page_nav = multi($total_num, $perpage, $pg, "mydisk.php?item=profile&action=$action");

		require_once template_echo('profile',$user_tpl_dir);
		break;
	case 'dl_users2':
		$q = $db->query("select touserid from {$tpf}buddys where userid='$pd_uid'");
		$bids = '';
		while ($rs = $db->fetch_array($q)) {
			$bids .= $rs[touserid].',';
		}
		$db->free($q);
		unset($rs);

		$sql_do = $bids ? substr($bids,0,-1) : '';
		$buddys = array();
		if($sql_do){
			$perpage = 20;
			$sql_do = "{$tpf}buddys b,{$tpf}users u where b.userid in ($sql_do) and b.touserid=u.userid";
			$rs = $db->fetch_one_array("select count(*) as total_num from {$sql_do}");
			$total_num = $rs['total_num'];
			$start_num = ($pg-1) * $perpage;

			$q = $db->query("select u.credit,u.username,u.qq,u.userid,b.is_system from $sql_do order by bdid desc limit $start_num,$perpage");
			//$buddys = array();
			while ($rs = $db->fetch_array($q)) {
				$rs[credit] = get_discount($rs[userid],$rs[credit]);
				$rs[is_system] = $rs[is_system] ? '系统分配' : '自己推广';
				$rs[a_space] = urr("space","username=".rawurlencode($rs[username]));
				$rs[qq] = $rs[qq] ? '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$rs[qq].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$rs[qq].':52" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>' : '';
				$buddys[] = $rs;
			}
			$db->free($q);
			unset($rs);
			$page_nav = multi($total_num, $perpage, $pg, "mydisk.php?item=profile&action=$action");
		}

		require_once template_echo('profile',$user_tpl_dir);
		break;
	case 'guest':
		if($task=='guest'){
			auth_task_guest();
		}else{
			$ref = $_SERVER['HTTP_REFERER'];
			$can_edit = (int)$myinfo[can_edit];
			require_once template_echo('profile',$user_tpl_dir);
		}
		break;
	case 'multi_upload':
		if($settings['open_multi_server']){
			$rs = $db->fetch_one_array("select server_host,server_key from {$tpf}servers where server_id>1 order by is_default desc limit 1");
			if($rs){
				$upload_url = $rs['server_host'].'mydisk.php?item=upload&code='.pd_encode($rs['server_key']);
			}
			unset($rs);
		}
		require_once template_echo('profile',$user_tpl_dir);
		break;
	default:
		$today_credit = (int)@$db->result_first("select sum(down_count) from ".get_table_day_down()." where userid='$pd_uid' and d_day='".date('Ymd')."'");
		$yesterday_credit = (int)@$db->result_first("select sum(down_count) from ".get_table_day_down()." where userid='$pd_uid' and d_day='".date('Ymd',strtotime('-1 day'))."'");
		$vip_end_time = get_profile($pd_uid,'vip_end_time');
		if($vip_end_time>$timestamp){
			$vip_end_time_txt = date('Y-m-d',get_profile($pd_uid,'vip_end_time'));
		}else{
			$vip_end_time_txt = date('Y-m-d',get_profile($pd_uid,'vip_end_time')).', <span class="txtred">('.__('vip_end_time_expire').')</span>';
		}
		$downline_num = (int)@$db->result_first("select count(*) from {$tpf}buddys where is_system=1 and userid='$pd_uid'");
		require_once template_echo('profile',$user_tpl_dir);

}

?>
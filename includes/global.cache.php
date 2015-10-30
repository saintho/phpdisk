<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: global.cache.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

function get_curr_tpl($tpl_type){
	global $db,$tpf;
	$tpl_name = @$db->result_first("select tpl_name from {$tpf}templates where tpl_type='$tpl_type' and actived=1");
	return array($tpl_name);
}
function get_lang_name(){
	global $db,$tpf;
	$lang_name = @$db->result_first("select lang_name from {$tpf}langs where actived=1");
	return array($lang_name);
}
function get_navigation_link($pos){
	global $db,$tpf;
	$pos = in_array($pos,array('top','bottom')) ? $pos : 'top';
	$q = $db->query("select * from {$tpf}navigations where position='$pos' order by show_order asc, navid desc");
	$arr = array();
	while($rs = $db->fetch_array($q)){
		$arr[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $arr;
}
function get_ads($adv_position){
	global $ads_cache_arr;
	$scope = substr(substr(strrchr($_SERVER['PHP_SELF'],'/'),1),0,-4);
	$echo_data = false;
	/*$q = $db->query("select * from {$tpf}advertisements where adv_position='$adv_position' and is_hidden=0 order by show_order asc,advid desc");
	$adv_arr = array();
	while($rs = $db->fetch_array($q)){*/
	$rs = $ads_cache_arr[$adv_position];
	if($rs){
		$count = mt_rand(0,count($rs)-1);
		$rs = unserialize($ads_cache_arr[$adv_position][$count]);
		$adv_type = $rs['adv_type'];
		$param = unserialize($rs['params']);
		$code = $rs['code'];
		$starttime = $rs['starttime'];
		$endtime = $rs['endtime'];

		if(strpos($param['adv_scope'],',')){
			$a2 = explode(',',$param['adv_scope']);
			if(in_array('all',$a2)){
				$echo_data = true;
			}elseif(in_array($scope,$a2)){
				$echo_data = true;
			}
		}else{
			if(!$param['adv_scope'] || $param['adv_scope'] =='all'){
				$echo_data = true;
			}elseif($param['adv_scope'] ==$scope){
				$echo_data = true;
			}
		}
		if($echo_data){
			if($starttime && TS<$starttime){
				$rs['adv_str'] = '';
			}elseif($endtime && TS>$endtime){
				$rs['adv_str'] = '';
			}else{
				switch($adv_type){
					case 'adv_text':
						$size = $param['adv_txt_size'] ? 'font-size:'.$param['adv_txt_size'].';' : 'font-size:12px;';
						$color = $param['adv_txt_color'] ? 'color:'.$param['adv_txt_color'].';' : '';

						$rs['adv_str'] = '<div style="padding:8px 0;"><a href="'.$param['adv_txt_url'].'" target="_blank" style="'.$size.$color.'">'.$param['adv_txt_title'].'</a></div>';
						break;
					case 'adv_code':
						$rs['adv_str'] = $code;
						break;
					case 'adv_flash':
						$rs['adv_str'] = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="'.$param['adv_flash_width'].'" height="'.$param['adv_flash_height'].'">
						  <param name="movie" value="'.$param['adv_flash_src'].'" />
						  <param name="quality" value="high" />
						  <param name="allowScriptAccess" value="always" />
						  <param name="wmode" value="transparent">
							 <embed src="'.$param['adv_flash_src'].'"
							  quality="high"
							  type="application/x-shockwave-flash"
							  WMODE="transparent"
							  width="'.$param['adv_flash_width'].'"
							  height="'.$param['adv_flash_height'].'"
							  pluginspage="http://www.macromedia.com/go/getflashplayer"
							  allowScriptAccess="always" />
						</object>';
						break;
					default:
						$rs['adv_str'] = '<a href="'.$param['adv_img_url'].'" target="_blank">';
						$rs['adv_str'] .= '<img src="'.$param['adv_img_src'].'" ';
						$rs['adv_str'] .= $param['adv_img_width'] ? ' width="'.$param['adv_img_width'].'" ' : '';
						$rs['adv_str'] .= $param['adv_img_height'] ? ' height="'.$param['adv_img_height'].'" ' : '';
						$rs['adv_str'] .= ' align="absmiddle" border="0" alt="'.$param['adv_img_alt'].'" />';
						$rs['adv_str'] .= '</a>';
				}
			}
		}
		$adv_arr[] = $rs;
	}
	//$db->free($q);
	unset($rs);

	return $adv_arr;
}
// direct show in tpl
function show_adv_data($pos,$show=1){
	//$adv_content = super_cache::get('get_ads|'.$pos,'ads',1,0);
	$adv_content = get_ads($pos);

	$rtn = '';
	switch($pos){
		case 'adv_bottom':
			if(count($adv_content)){
				foreach($adv_content as $v){
					$rtn .= '<div align="center">'.$v['adv_str'].'</div>';
				}
				unset($adv_content);
			}
			break;

		default:
			if(count($adv_content)){
				foreach($adv_content as $v){
					$rtn .= $v['adv_str'];
				}
				unset($adv_content);
			}
	}
	if($show){
		echo $rtn;
	}else{
		return $rtn;
	}
}

function my_folder_root($userid){
	global $db,$tpf;
	$file_count = (int)@$db->result_first("select count(*) from {$tpf}files where folder_id=0 and userid='$userid'");
	$folder_size = @$db->result_first("select sum(file_size) from {$tpf}files where folder_id=0 and userid='$userid'");
	return array('file_count'=>$file_count,'folder_size'=>$folder_size);
}
function my_folder_menu($userid){
	global $db,$tpf;

	$q = $db->query("select folder_id,parent_id,folder_name from {$tpf}folders where userid='$userid'  order by folder_order asc,folder_id asc");
	$arr = array();
	while($rs = $db->fetch_array($q)){
		//$num = (int)@$db->result_first("select count(*) from {$tpf}files where folder_id='{$rs['folder_id']}' and userid='$pd_uid'");
		//$rs[folder_size] = @$db->result_first("select sum(file_size) from {$tpf}files where folder_id='{$rs[folder_id]}' and userid='$pd_uid'");
		//$rs[count] = $num ? __('all_file')."$num , ".__('folder_size').get_size($rs['folder_size']) : '';
		$rs['parent_id'] = $rs['parent_id']==-1 ? 0 : (int)$rs['parent_id'];

		$arr[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $arr;
}
function get_option_folders($deep=4){
	global $db,$tpf,$pd_uid;

	$q = $db->query("select folder_node,folder_id,folder_name,folder_description,parent_id from {$tpf}folders where userid='$pd_uid'  order by folder_order asc,in_time asc");
	$folders = array();
	while($rs = $db->fetch_array($q)){
		$folders[] = $rs;
	}
	$db->free($q);
	unset($rs);

	$str_c = '<option value=\'0\' style=\'color:#0000FF\' id=\'fd_0\'>'.__('root_folder').'</option>'.LF;
	for($i = 0; $i < count($folders); $i++) {
		if($folders[$i]['folder_node'] == 1) {
			$str_c .= '<option value=\''.$folders[$i]['folder_id'].'\' id=\'fd_'.$folders[$i]['folder_id'].'\'>'.$folders[$i]['folder_name'].'</option>'.LF;
			for($j = 0; $j < count($folders); $j++) {
				if($folders[$j]['parent_id'] == $folders[$i]['folder_id'] && $folders[$j]['folder_node'] == 2) {
					$str_c .= '<option value=\''.$folders[$j]['folder_id'].'\' id=\'fd_'.$folders[$j]['folder_id'].'\'>'.str_repeat('&nbsp;',4).$folders[$j]['folder_name'].'</option>'.LF;
					for($k = 0; $k < count($folders); $k++) {
						if($folders[$k]['parent_id'] == $folders[$j]['folder_id'] && $folders[$k]['folder_node'] == 3) {
							$str_c .= '<option value=\''.$folders[$k]['folder_id'].'\' id=\'fd_'.$folders[$k]['folder_id'].'\'>'.str_repeat('&nbsp;',8).$folders[$k]['folder_name'].'</option>'.LF;
							if($deep ==4){
								for($l=0;$l<count($folders);$l++){
									if($folders[$l]['parent_id'] == $folders[$k]['folder_id'] && $folders[$l]['folder_node'] == 4) {
										$str_c .= '<option value=\''.$folders[$l]['folder_id'].'\' id=\'fd_'.$folders[$l]['folder_id'].'\'>'.str_repeat('&nbsp;',12).$folders[$l]['folder_name'].'</option>'.LF;
									}
								}
							}
						}
					}
				}
			}
		}
	}
	return $str_c;
}

function main_stats(){
	global $db,$tpf;
	$stats['user_folders_count'] = (int)@$db->result_first("select count(*) from {$tpf}folders");

	$stats['user_files_count'] = (int)@$db->result_first("select count(*) from {$tpf}files");

	$stats['users_count'] = (int)@$db->result_first("select count(*) from {$tpf}users ");

	$stats['users_locked_count'] = (int)@$db->result_first("select count(*) from {$tpf}users where is_locked=1");

	$stats['extract_code_count'] = (int)@$db->result_first("select count(*) from {$tpf}extracts");

	$stats['all_files_count'] = (int)@$db->result_first("select count(*) from {$tpf}files");

	$storage_count_tmp = (float)@$db->result_first("select sum(file_size) from {$tpf}files");

	$stats['user_storage_count'] = get_size($storage_count_tmp);
	$stats['total_storage_count'] = get_size($storage_count_tmp);
	$stats['users_open_count'] = $stats['users_count']-$stats['users_locked_count'];
	$stats['stat_time'] = TS;

	stats_cache($stats);
}
function show_announces(){
	global $db,$tpf,$settings;

	$q = $db->query("select * from {$tpf}announces where is_hidden=0 order by show_order asc,annid desc limit 5");
	$num = $db->num_rows($q);
	$tmpstr = '';
	//$str2 = '<div id="myscroll">'.LF;
	//$str2 .= '<ul class="scroll">'.LF;
	while($rs = $db->fetch_array($q)){
		$str2 .= '<tr><td><a href="javascript:;" onclick="abox(\''.urr("announce","aid=".$rs['annid']).'\',\''.$rs[subject].'\',650,450)" class="f14" style="color:#0000FF">'.$rs['subject'].' <span class="txtgray f10">('.date("Y-m-d",$rs['in_time']).')</span></a></td></tr>'.LF;
	}
	/*$str = $num>1 ? '<script language="javascript" type="text/javascript" src="includes/js/ann_js.js"></script>'.LF : '';*/
	$str .= '<script type="text/javascript">';
	$str .= $tmpstr.LF;
	$str .= '</script>'.LF;
	//$str2 .= '</ul>'.LF;
	//$str2 .= '</div>'.LF;
	$db->free($q);
	unset($rs);
	echo $str2.LF.$str.$rtn;
}
function get_last_file($num=10){
	global $db,$tpf;
	$q = $db->query("select file_id,file_name,file_extension,file_time,file_size from {$tpf}files where in_share=1 and is_del=0 and userid>0 order by file_id desc limit $num");
	$last_file = array();
	while($rs = $db->fetch_array($q)){
		$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
		$rs['file_name'] = filter_word($rs['file_name'].$tmp_ext);
		$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
		$rs['file_time'] = is_today($rs['file_time']) ? '<span class="txtred" style="float:right">'.date('m/d',$rs['file_time']).'</span>' : '<span class="txtgray" style="float:right">'.date('m/d',$rs['file_time']).'</span>';
		$rs['file_icon'] = file_icon($rs['file_extension']);
		$rs[file_size] = '<span class="txtgray" style="float:right">'.get_size($rs[file_size]).'</span>';
		$last_file[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $last_file;
}
function get_cate_file($cate_id=0,$order='file_id',$by='desc',$num=10){
	global $db,$tpf;
	$pid = (int)@$db->result_first("select cate_id from {$tpf}categories where pid='$cate_id'");
	$pid_sql = $pid ? " or cate_id='$pid'" : '';
	$sql_do = $cate_id ? "(cate_id='$cate_id' $pid_sql) and " : '';
	$q = $db->query("select /*get_cate_file|".$_SERVER['REQUEST_URI']."*/ file_id,file_name,file_extension,file_time,file_size from {$tpf}files where $sql_do in_share=1 and is_del=0 and userid>0 and is_checked=1 order by $order $by limit $num");
	$last_file = array();
	while($rs = $db->fetch_array($q)){
		$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
		$rs['file_name'] = filter_word($rs['file_name'].$tmp_ext);
		$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
		$rs['file_time'] = is_today($rs['file_time']) ? '<span class="txtred" style="float:right">'.date('m/d',$rs['file_time']).'</span>' : '<span class="txtgray" style="float:right">'.date('m/d',$rs['file_time']).'</span>';
		$rs['file_icon'] = file_icon($rs['file_extension']);
		$rs[file_size] = '<span class="txtgray" style="float:right">'.get_size($rs[file_size]).'</span>';
		$last_file[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $last_file;
}
function get_hot_file($num=10){
	global $db,$tpf;
	$q = $db->query("select file_id,file_name,file_extension,file_time,file_size from {$tpf}files where in_share=1 and is_del=0 and userid>0 order by file_views desc limit $num");
	$hot_file = array();
	while($rs = $db->fetch_array($q)){
		$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
		$rs['file_name'] = filter_word($rs['file_name'].$tmp_ext);
		$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
		$rs['file_time'] = is_today($rs['file_time']) ? '<span class="txtred" style="float:right">'.date('m/d',$rs['file_time']).'</span>' : '<span class="txtgray" style="float:right">'.date('m/d',$rs['file_time']).'</span>';
		$rs['file_icon'] = file_icon($rs['file_extension']);
		$rs[file_size] = '<span class="txtgray" style="float:right">'.get_size($rs[file_size]).'</span>';
		$hot_file[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $hot_file;
}
function get_commend_file($num=10){
	global $db,$tpf;
	$q = $db->query("select file_id,file_name,file_extension,file_time,file_size from {$tpf}files where commend=1 and is_del=0 and userid>0 order by file_views desc limit $num");
	$hot_file = array();
	while($rs = $db->fetch_array($q)){
		$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
		$rs['file_name'] = filter_word($rs['file_name'].$tmp_ext);
		$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
		$rs['file_time'] = is_today($rs['file_time']) ? '<span class="txtred" style="float:right">'.date('m/d',$rs['file_time']).'</span>' : '<span class="txtgray" style="float:right">'.date('m/d',$rs['file_time']).'</span>';
		$rs['file_icon'] = file_icon($rs['file_extension']);
		$rs[file_size] = '<span class="txtgray" style="float:right">'.get_size($rs[file_size]).'</span>';
		$hot_file[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $hot_file;
}
function get_rand_file($num=10){
	global $db,$tpf;
	$q = $db->query("select /*get_rand_file|".$_SERVER['REQUEST_URI']."*/ file_id,file_name,file_extension,file_time,file_size from {$tpf}files where in_share=1 and is_del=0 and userid>0 order by rand() limit $num");
	$file = array();
	while($rs = $db->fetch_array($q)){
		$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
		$rs['file_name'] = filter_word($rs['file_name'].$tmp_ext);
		$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
		$rs['file_time'] = is_today($rs['file_time']) ? '<span class="txtred" style="float:right">'.date('m/d',$rs['file_time']).'</span>' : '<span class="txtgray" style="float:right">'.date('m/d',$rs['file_time']).'</span>';
		$rs['file_icon'] = file_icon($rs['file_extension']);
		$rs[file_size] = '<span class="txtgray" style="float:right">'.get_size($rs[file_size]).'</span>';
		$file[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $file;
}
function get_user_other_file($file_id,$uid,$num=10){
	global $db,$tpf;
	$q = $db->query("select /*get_user_other_file|".$_SERVER['REQUEST_URI']."*/ file_id,file_name,file_extension,file_time,file_size,file_credit from {$tpf}files where file_id<>'$file_id' and in_share=1 and is_del=0 and userid='$uid' order by file_id desc limit $num");
	$file = array();
	while($rs = $db->fetch_array($q)){
		$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
		$rs['file_name'] = filter_word($rs['file_name'].$tmp_ext);
		$rs['file_name_min'] = cutstr(filter_word($rs['file_name']),28);
		$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
		$rs['file_time'] = is_today($rs['file_time']) ? '<span class="txtred" style="float:right">'.date('m/d',$rs['file_time']).'</span>' : '<span class="txtgray" style="float:right">'.date('m/d',$rs['file_time']).'</span>';
		$rs['file_icon'] = file_icon($rs['file_extension']);
		$rs[file_size] = '<span class="txtgray" style="float:right">'.get_size($rs[file_size]).'</span>';
		$file[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $file;
}
function get_day_down_file($stat_time,$stat_type='d_day',$cate_id=0,$uid=0,$num=10){
	global $db,$tpf;
	$sql_uid = $uid ? " and dd.userid='$uid'" : '';
	$q = $db->query("select fl.file_id,file_name,file_extension,file_time,file_size from {$tpf}files fl,".get_table_day_down()." dd where dd.{$stat_type}='$stat_time' and fl.file_id=dd.file_id and in_share=1 and cate_id='$cate_id' and is_del=0 $sql_uid order by dd.down_count desc limit $num");
	$file = array();
	while($rs = $db->fetch_array($q)){
		$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
		$rs['file_name'] = filter_word($rs['file_name'].$tmp_ext);
		$rs['a_viewfile'] = urr("viewfile","file_id={$rs['file_id']}");
		$rs['file_time'] = is_today($rs['file_time']) ? '<span class="txtred" style="float:right">'.date('m/d',$rs['file_time']).'</span>' : '<span class="txtgray" style="float:right">'.date('m/d',$rs['file_time']).'</span>';
		$rs['file_icon'] = file_icon($rs['file_extension']);
		$rs[file_size] = '<span class="txtgray" style="float:right">'.get_size($rs[file_size]).'</span>';
		$file[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $file;
}
function get_announces($num=5){
	global $db,$tpf;
	$q = $db->query("select annid,in_time,subject from {$tpf}announces where is_hidden=0 order by show_order asc,annid desc limit $num");
	$ann_list = array();
	while($rs = $db->fetch_array($q)){
		$rs[a_ann_href] = urr("ann_list","aid={$rs[annid]}");
		$rs[in_time] = date('m-d',$rs[in_time]);
		$ann_list[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $ann_list;
}
function get_hot_tag($num=30){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}tags where is_hidden=0 and tag_count>0 order by tag_count desc,tag_id desc limit $num");
	$hot_tags = array();
	while($rs = $db->fetch_array($q)){
		$rs['a_view_tag'] = urr("tag","tag=".rawurlencode($rs['tag_name'])."");
		$rs['tag_count'] = $rs['tag_count'] ? "({$rs['tag_count']})" : '';
		$hot_tags[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $hot_tags;
}

function get_last_tag($num=30){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}tags where is_hidden=0 and tag_count>0 order by tag_id desc limit $num");
	$last_tags = array();
	while($rs = $db->fetch_array($q)){
		$rs['a_view_tag'] = urr("tag","tag=".rawurlencode($rs['tag_name'])."");
		$rs['tag_count'] = $rs['tag_count'] ? "({$rs['tag_count']})" : '';
		$last_tags[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $last_tags;
}
function get_sub_nav(){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}categories where nav_show=1 order by show_order asc,cate_id asc");
	$arr = array();
	while($rs = $db->fetch_array($q)){
		$arr[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $arr;
}
?>
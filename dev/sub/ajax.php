<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: ajax.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

switch($action){

	case 'down_process':
		$temp_ip = gpc('down_ip','C','');
		$file_id = (int)gpc('file_id','G',0);

		$userid = @$db->result_first("select userid from {$tpf}files where file_id='$file_id'");
		$curr_tpl = @$db->result_first("select curr_tpl from {$tpf}users where userid='$userid'");

		/*$exp_down = (int)$settings['exp_down'];
		$db->query_unbuffered("update {$tpf}users set exp=exp+$exp_down where userid='$pd_uid'");

		$exp_down_my = (int)$settings['exp_down_my'];
		$db->query_unbuffered("update {$tpf}users set exp=exp+$exp_down_my where userid='$userid'");*/
		if($settings['credit_open'] && $pd_uid!=$userid && !$temp_ip){
			pd_setcookie('down_ip',1,86400);
			$db->query_unbuffered("update {$tpf}files set file_downs=file_downs+1,file_last_view='$timestamp' where file_id='$file_id'");

			$credit = $settings['credit_open'] ? (int)$settings['credit_down'] : 0;
			$credit_my = $settings['credit_open'] ? (int)$settings['credit_down_my'] : 0;
			if($pd_uid){
				$pd_credit = (int)$db->result_first("select credit from {$tpf}users where userid='$pd_uid' limit 1");
				if($pd_credit && $pd_credit>=$credit){
					$db->query_unbuffered("update {$tpf}users set credit=credit-{$credit} where userid='$pd_uid'");
				}
			}
			//$db->query_unbuffered("update {$tpf}users set credit=credit+{$credit_my} where userid='$userid'");
			$db->query_unbuffered("update {$tpf}users set tpl_credit=tpl_credit+{$credit_my} where userid='$userid'");
			$tpl_credit = @$db->result_first("select tpl_credit from {$tpf}users where userid='$userid'");
			if($tpl_credit>=10){
				$curr_tpl = $curr_tpl ? trim($curr_tpl) : 'default';
				$percent = $db->result_first("select percent from {$tpf}templates where tpl_name='$curr_tpl'");
				$sub_credit = round($tpl_credit*($percent/100));
				$add_credit = $tpl_credit-$sub_credit;
				$db->query_unbuffered("update {$tpf}users set credit=credit+$add_credit,tpl_credit=0 where userid='$userid'");
			}
			$db->query_unbuffered("update {$tpf}users set very_down=very_down+1 where userid='$userid'");
		}

		echo 'true';
		break;

	case 'get_my_last':
		$uid = (int)gpc('uid','P',0);
		$plugin_type = trim(gpc('plugin_type','P',''));
		if($uid){
			$q = $db->query("select file_id,file_name,file_extension,file_time,file_size from {$tpf}files where userid='$uid' order by file_id desc limit 10");
			$str = '';
			while ($rs = $db->fetch_array($q)) {
				$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
				$rs['file_name_all'] = cutstr($rs['file_name'].$tmp_ext,35);
				$rs['a_downfile'] = $settings[phpdisk_url].urr("viewfile","file_id=".$rs['file_id']);
				$rs['file_time'] = date('Y-m-d',$rs['file_time']);
				$rs['file_size'] = get_size($rs['file_size']);

				$rs[ctn_2] = str_replace(array('"',"'"),'_',$rs['file_name_all']).'\r\n下载地址： [url='.$rs['a_downfile'].']'.$rs['a_downfile'].'[/url]\r\n\r\n';
				$rs[ctn] = str_replace(array('"',"'"),'_',$rs['file_name_all']).'<br>下载地址： [url='.$rs['a_downfile'].']'.$rs['a_downfile'].'[/url]<br><br>';
				$str .= '<div class="fl_list">'.LF;
				$str .= '<div class="f1"><span style="float:right" class="txtgray">'.$rs[file_size].'</span>&nbsp;<a href="###" title="'.$rs['file_name'].'" onclick="addCodeToEditor(\''.$rs['ctn'].'\',\''.$rs['ctn_2'].'\',\''.$plugin_type.'\');">'.file_icon($rs['file_extension']).$rs['file_name_all'].'</a></div>'.LF;
				//$str .= '<div class="f1"><span style="float:right" class="txtgray">'.$rs[file_size].'</span>&nbsp;<a href="###" title="'.$rs['file_name'].'" id="f_'.$rs[file_id].'" onclick="top.test(\''.$rs['a_downfile'].'\');">'.file_icon($rs['file_extension']).$rs['file_name_all'].'</a></div>'.LF;
				$str .= '<div class="f2"><span class="txtgray">'.$rs['file_time'].'</span></div>'.LF;
				$str .= '</div>'.LF;
				$str .= '<div class="clear"></div>'.LF;
			}
			$db->free($q);
			unset($rs);
			echo $str;
		}else{
			echo 'false';
		}
		break;
	case 'add_cate':
		$cate_name = trim(gpc('cate_name','P',''));
		if(checklength($cate_name,1,150)){
			$error = true;
			$rtn = __('add_folder_error');
		}
		$num = @$db->result_first("select count(*) from {$tpf}folders where userid='$pd_uid' and folder_name='$cate_name'");
		if($num){
			$error = true;
			$rtn = __('folder_exists');
		}
		if(!$error){
			$ins = array(
			'folder_name' => $cate_name,
			'userid' => $pd_uid,
			'in_time'=>$timestamp,
			);
			$db->query_unbuffered("insert into {$tpf}folders set ".$db->sql_array($ins)."");
			$id = $db->insert_id();
			echo 'true|'.$id;
		}else{
			echo $rtn;
		}
		break;
	case 'load_cate':
		$uid = (int)gpc('uid','P','');
		$sel_id = (int)gpc('sel_id','P','');
		$str = '<select id="up_folder_id" name="up_folder_id">'.LF;
		$str .= '<option value="0">'.__('root_folder').'</option>'.LF;
		$str .= get_folder_option(0,$sel_id);
		$str .= '</select>';		
		
		echo $str;
		break;
}

//include PHPDISK_ROOT."./includes/footer.inc.php";

?>
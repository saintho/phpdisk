<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: nodes.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,15,$pd_uid);
$q = $db->query("select subject,node_id,server_oid from {$tpf}nodes where parent_id=0 order by show_order asc,node_id asc");
$nd = array();
while ($rs = $db->fetch_array($q)) {
	$nd[] = $rs;
}
$db->free($q);
unset($rs);

switch($action){
	case 'add':
		if($task =='add'){
			form_auth(gpc('formhash','P',''),formhash());
			$subject = trim(gpc('subject','P',''));
			$server_oid = trim(gpc('server_oid','P',''));
			$host = trim(gpc('host','P',''));
			$icon = trim(gpc('icon','P',''));
			$down_type = (int)gpc('down_type','P',0);
			$parent_id = (int)gpc('parent_id','P',0);
			$is_hidden = (int)gpc('is_hidden','P',0);

			if(checklength($subject,1,250)){
				$error = true;
				$sysmsg[] = __('nodes_subject_error');
			}else{
				/*$num = @$db->result_first("select count(*) from {$tpf}nodes where subject='$subject' and parent_id='$parent_id'");
				if($num){
					$error = true;
					$sysmsg[] = __('nodes_subject_exists');
				}*/
			}
			if($parent_id && !$host){
				$error = true;
				$sysmsg[] = __('nodes_host_error');
			}
			if($parent_id && (substr($host,0,7)!='http://' && substr($host,0,8)!='https://')){
				$error = true;
				$sysmsg[] = __('nodes_host_format_error');
			}elseif($parent_id && substr($host,-1)!='/'){
				$error = true;
				$sysmsg[] = __('nodes_host_format_error');
			}

			if(!$error){
				$ins = array(
				'subject'=>$subject,
				'host'=>$parent_id ? $host : '-',
				'server_oid'=>$server_oid,
				'icon'=>$icon,
				'down_type'=>$down_type,
				'parent_id'=>$parent_id,
				'is_hidden'=>$is_hidden,
				);
				$db->query_unbuffered("insert into {$tpf}nodes set ".$db->sql_array($ins)."");
				$sysmsg[] = __('add_nodes_success');
				redirect(urr(ADMINCP,"item=nodes&menu=file&action=list"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$pa = array();
			$pa[is_hidden] = 0;
			$pa[down_type] = 0;
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'edit':
		$node_id = (int)gpc('node_id','GP',0);
		if($task=='edit'){
			form_auth(gpc('formhash','P',''),formhash());
			$subject = trim(gpc('subject','P',''));
			$host = trim(gpc('host','P',''));
			$server_oid = trim(gpc('server_oid','P',''));
			$icon = trim(gpc('icon','P',''));
			$down_type = (int)gpc('down_type','P',0);
			$parent_id = (int)gpc('parent_id','P',0);
			$is_hidden = (int)gpc('is_hidden','P',0);

			if(checklength($subject,2,150)){
				$error = true;
				$sysmsg[] = __('nodes_subject_error');
			}else{
				/*$num = @$db->result_first("select count(*) from {$tpf}nodes where subject='$subject' and node_id<>'$node_id' and parent_id='$parent_id'");
				if($num){
					$error = true;
					$sysmsg[] = __('nodes_subject_exists');
				}*/
			}
			if($parent_id && !$host){
				$error = true;
				$sysmsg[] = __('nodes_host_error');
			}
			if($parent_id && (substr($host,0,7)!='http://' && substr($host,0,8)!='https://')){
				$error = true;
				$sysmsg[] = __('nodes_host_format_error');
			}elseif($parent_id && substr($host,-1)!='/'){
				$error = true;
				$sysmsg[] = __('nodes_host_format_error');
			}
			if($parent_id==$node_id){
				$error = true;
				$sysmsg[] = __('parent_node_id_the_same');
			}

			if(!$error){
				$ins = array(
				'subject'=>$subject,
				'host'=>$parent_id ? $host : '-',
				'server_oid'=>$server_oid,
				'icon'=>$icon,
				'down_type'=>$down_type,
				'parent_id'=>$parent_id,
				'is_hidden'=>$is_hidden,
				);
				$db->query_unbuffered("update {$tpf}nodes set ".$db->sql_array($ins)." where node_id='$node_id'");
				$sysmsg[] = __('edit_nodes_success');
				redirect(urr(ADMINCP,"item=nodes&menu=file&action=list"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$pa = $db->fetch_one_array("select * from {$tpf}nodes where node_id='$node_id'");
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'del':
		$node_id = (int)gpc('node_id','G',0);
		if($node_id){
			$db->query_unbuffered("delete from {$tpf}nodes where node_id='$node_id' or parent_id='$node_id'");
		}
		$sysmsg[] = __('nodes_del_success');
		redirect('back',$sysmsg);
		break;
	case 'change_status':
		$node_id = (int)gpc('node_id','G',0);
		if($node_id){
			$is_hidden = (int)@$db->result_first("select is_hidden from {$tpf}nodes where node_id='$node_id'");
			$is_hidden = $is_hidden ? 0 : 1;
			$db->query_unbuffered("update {$tpf}nodes set is_hidden=$is_hidden where node_id='$node_id'");
			$sysmsg[] = __('nodes_change_status_success');
		}
		redirect('back',$sysmsg);
		break;
	default:
		if($task=='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$show_order = gpc('show_order','P',array());
			$node_ids = gpc('node_ids','P',array());

			if($settings['online_demo']){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!$error){
				for($i =0;$i<count($node_ids);$i++){
					$db->query_unbuffered("update {$tpf}nodes set show_order='".(int)$show_order[$i]."' where node_id='".(int)$node_ids[$i]."'");
				}
				redirect(urr(ADMINCP,"item=$item&menu=file&action=list"),'',0);
			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$q = $db->query("select * from {$tpf}nodes order by show_order asc,node_id asc");
			$nodes = array();
			while ($rs = $db->fetch_array($q)) {
				$rs[icon] = $rs[icon] ? '<img src="'.$rs[icon].'" align="absmiddle" border="0" />' : '&nbsp;';
				$rs['status_text'] = $rs['is_hidden'] ? '<span class="txtred">'.__('hidden').'</span>' : '<span class="txtblue">'.__('display').'</span>';
				$rs['a_change_status'] = urr(ADMINCP,"item=$item&menu=file&action=change_status&node_id={$rs['node_id']}");
				$rs['a_edit_node'] = urr(ADMINCP,"item=$item&menu=file&action=edit&node_id={$rs['node_id']}");
				$rs['a_del_node'] = urr(ADMINCP,"item=$item&menu=file&action=del&node_id={$rs['node_id']}");
				$nodes[] = $rs;
			}
			$db->free($q);
			unset($rs);
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}

?>
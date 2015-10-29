<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-28 21:30:50

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: files.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if($action=='filterword'){ ?>

<?php 
}elseif($action =='index' || $action =='search'){
 ?>
<div id="container">
    <h1>课程列表<?php sitemap_tag("课程列表"); ?></h1>
    <div>
        <div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle"/> <b><?= __('tips') ?>
                : </b>
            <span class="txtgray">点击课程，可以进入到课程里章节做文件审核</span>
        </div>
        <form name="search_frm" action="<?=urr(ADMINCP,"")?>" method="get">
        <input type="hidden" name="item" value="files"/>
        <input type="hidden" name="menu" value="file"/>
        <input type="hidden" name="action" value="search"/>

        <div class="search_box">
            <div class="l"><img src="<?=$admin_tpl_dir?>images/it_nav.gif" align="absbottom"/>
                查看筛选:
                <select name="status" id="status" onchange="chg_status();">
                    <?php 
                    foreach($defineCouser as $k => $v){
                     ?>
                    <option value="<?=$k?>" <?=ifselected(
                    $current_status,$k,'int');?>><?=$v?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="r">
                日期：<input type="text" name="dd" value="<?=$dd?>" title="日期格式：<?=$dd?>"/>
                用户名：<input type="text" name="user" value="<?=$user?>"/>
                关键字：<input type="text" name="word" value="<?=$word?>" title="<?= __('search_files_tips') ?>"/>
                <input type="submit" class="btn" value="<?= __('search_files') ?>"/></div>
        </div>
        </form>
        <div class="clear"></div>
        <script language="javascript">
            function chg_status() {
                var status = getId('status').value.strtrim();
                document.location.href = '<?=urr(ADMINCP,"item=course&menu=file&action=search&status=' + status + '")?>';
            }
            function dosearch(o) {
                if (o.word.value.strtrim().length < 1) {
                    o.word.focus();
                    return false;
                }
            }
            function dosubmit(o) {
                if (checkbox_ids("file_ids[]") != true) {
                    alert("<?=__('please_select_operation_files')?>");
                    return false;
                }
            }
        </script>

        <form name="public_frm" action="<?=urr(ADMINCP,"item=course&menu=file")?>" method="post"
              onsubmit="return dosubmit(this);">
            <input type="hidden" name="action" value="<?=$action?>"/>
            <input type="hidden" name="formhash" value="<?=$formhash?>"/>
            <table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
                <?php 
                if(count($course_array)){
                 ?>
                <tr>
                    <td width="20%" class="bold">课程名称</td>
                    <td align="center" class="bold">用户</td>
                    <td align="center" class="bold">分类</td>
                    <td align="center" class="bold" width="150">视频数</td>
                    <td align="center" class="bold">下载数</td>
                    <td align="center" class="bold">浏览数</td>
                    <td align="center" width="150" class="bold"><?= __('status') ?></td>
                    <td align="center" width="150" class="bold">更新时间</td>
                    <td align="right" width="120" class="bold">
                        <?= __('operation') ?>
                    </td>
                </tr>
                <?php 
                    foreach($course_array as $k => $v){
                        $color = ($k%2 ==0) ? 'color1' :'color4';
                 ?>
                <tr class="<?=$color?>" id="tr_<?=$v['file_id']?>" onclick="load_file_addr('<?=$v[file_id]?>');">
                    <td>
                        <img src="images/folder.gif" align="absmiddle" border="0" />
                        <a href="<?=$v['a_course_view_admin']?>"><?=$v['course_name']?></a>
                    </td>
                    <td align="center" class="txtgray"><?=$v['username']?></td>
                    <td align="center" class="txtgray"><?=$v['cate_name']?></td>
                    <td align="center" class="txtgray"><?=$v['file_num']?></td>
                    <td align="center" class="txtgray"><?=$v['download_num']?></td>
                    <td align="center" class="txtgray"><?=$v['view_num']?></td>
                    <td align="center" class="txtgray"><?=$v['status']?></td>
                    <td align="center" class="txtgray"><?=$v['update_date']?></td>
                    <td align="right">
                        <a href="<?=$v['a_course_view_admin']?>"><img src="images/icon_search.gif" /></a>
                    </td>
                </tr>
                <?php 
                    }
                    unset($files_array);
                 ?>
                <?php if($page_nav){ ?>
                <tr>
                    <td colspan="6"><?=$page_nav?></td>
                </tr>
                <?php } ?>

                <?php 
                }else{
                 ?>
                <tr>
                    <td colspan="6">没有找到课程</td>
                </tr>
                <?php 
                }
                 ?>
            </table>
        </form>
    </div>
</div>
<?php }elseif($action=='course_view'){ ?>
<div id="container">
    <h1>章节列表<?php sitemap_tag("章节列表"); ?></h1>

    <div>
        <div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle"/> <b><?= __('tips') ?>
                : </b>
            <span class="txtgray">勾选章节，进行操作</span>
        </div>

        <div class="clear"></div>
        <script language="javascript">
            function chg_view() {
                var view = getId('view').value.strtrim();
                document.location.href = '<?=urr(ADMINCP,"item=files&menu=file&action=index&view=' + view + '")?>';
            }
            function dosearch(o) {
                if (o.word.value.strtrim().length < 1) {
                    o.word.focus();
                    return false;
                }
            }
            function load_file_addr(id) {
                $('#dl_' + id).html('<img src="images/ajax_loading.gif" align="absmiddle" border="0" />');
                $.ajax({
                    type: 'post',
                    url: 'ajax.php',
                    data: 'action=load_file_addr&file_id=' + id + '&t=' + Math.random(),
                    dataType: 'text',
                    success: function (msg) {
                        var arr = msg.split('|');
                        if (arr[0] == 'true') {
                            $('#dl_' + id).html(arr[1]);
                            $('#tr_' + id).attr('onclick', '');
                            $('#tr_' + id).attr('title', '');
                        } else {
                            alert(msg);
                        }
                    },
                    error: function () {
                    }

                });
            }
            function down_process2(file_id) {
                $.ajax({
                    type: 'post',
                    url: 'ajax.php',
                    data: 'action=down_process&file_id=' + file_id + '&t=' + Math.random(),
                    dataType: 'text',
                    success: function (msg) {
                        if (msg == 'true') {

                        } else {
                            alert(msg);
                        }
                    },
                    error: function () {
                    }

                });
            }

            function dosubmit(o) {
                if (checkbox_ids("file_ids[]") != true) {
                    alert("<?=__('please_select_operation_files')?>");
                    return false;
                }
            }
            function dis() {
                if (getId('move_to').checked == true) {
                    getId('dest_sid').disabled = false;
                    getId('server_oid').disabled = true;
                } else if (getId('move_oid').checked == true) {
                    getId('dest_sid').disabled = true;
                    getId('server_oid').disabled = false;
                } else {
                    getId('dest_sid').disabled = true;
                    getId('server_oid').disabled = true;
                }
            }

        </script>

        <form name="public_frm" action="<?=urr(ADMINCP,"item=course&menu=file")?>" method="post"
              onsubmit="return dosubmit(this);">
            <input type="hidden" name="action" value="<?=$action?>"/>
            <input type="hidden" name="task" value="course_view"/>
            <input type="hidden" name="formhash" value="<?=$formhash?>"/>
            <table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
                <?php if(count($chapter_section_array)){ ?>
                <tr>
                    <td width="22%" class="bold">章节／课程名称</td>
                    <td width="8%" align="center" class="bold">视频数</td>
                    <td width="8%" align="center" class="bold"><?=__('file_downs')?></td>
                    <td width="8%" align="center" class="bold">浏览数</td>
                    <td width="12%" align="center" class="bold">状态</td>
                    <td width="17%" align="center" width="150" class="bold">更新时间</td>
                    <!--<td width="13%" align="center" class="bold">
                        <?=__('operation')?>
                    </td>-->
                </tr>
                <?php 
    }
    if(count($chapter_section_array)){
        foreach($chapter_section_array as $k => $v){
            $color = ($k%2 ==0) ? 'color1' :'color4';
     ?>
                <?php if($v['is_cs']){  ?>
                <tr class="<?=$color?>">
                    <td>
                        <?php  echo str_repeat('&nbsp;',$v['level']*2) ?>
                        <img src="images/disk.gif" align="absmiddle" border="0" />
                        <?=$v['cs_name']?>
                    </td>
                    <td align="center" class="txtgray">-</td>
                    <td align="center" class="txtgray"><?=$v['download_num']?></td>
                    <td align="center" class="txtgray"><?=$v['view_num']?></td>
                    <td align="center" class="txtgray"><?=$v['status']?></td>
                    <td align="center" class="txtgray"><?=$v['update_date']?></td>
                    <!--<td align="center">
                        <a href="javascript:;" onclick="abox('<?=$v[a_edit]?>','修改章节',350,250);"><img src="images/ico_write.png" align="absbottom" border="0" /></a>
                        <a href="javascript:;" onclick="abox('<?=$v[a_del]?>','删除章节',400,250)"><img src="images/delete_icon.gif" align="absmiddle" border="0" /></a>
                    </td>-->
                </tr>
                <?php }  ?>
                <?php if($v['is_file']){  ?>
                <tr class="<?=$color?>">
                    <td>
                        <?php  echo str_repeat('&nbsp;',$v['level']*2) ?>
                        <input type="checkbox" name="file_ids[]" id="file_ids"  value="<?=$v['file_id']?>" />
                        <img src="images/tree/cd.gif" align="absmiddle" border="0" />
                        <?=$v['file_name']?>
                    </td>
                    <td align="center" class="txtgray">-</td>
                    <td align="center" class="txtgray"><?=$v['file_downs']?></td>
                    <td align="center" class="txtgray"><?=$v['file_views']?></td>
                    <td align="center" class="txtgray"><?=$v['status']?></td>
                    <td align="center" class="txtgray"><?=$v['file_time']?></td>
                    <!--<td align="center">
                        <a href="javascript:;" onclick="abox('<?=$v[a_del]?>','删除文件',400,250)"><img src="images/delete_icon.gif" align="absmiddle" border="0" /></a>
                    </td>-->
                </tr>
                <?php }  ?>
                <?php 
                    } ?>
                <tr>
                    <td colspan="6">
                        <a href="javascript:void(0);" onclick="reverse_ids(document.public_frm.file_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.public_frm.file_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
                        <label>操作：</label>
                        <select name="review_status" id="review_status">
                            <?php  foreach($defineFileChaptersSections as $k => $v){ ?>
                            <option value="<?=$k?>"><?=$v?></option>
                            <?php  } ?>
                        </select>&nbsp;&nbsp;
                        <input type="submit" class="btn" value="<?=__('btn_submit')?>"/>
                    </td>
                </tr>
                <?php } ?>
                <?php 
                if(!count($chapter_section_array) ){
                 ?>
                <tr>
                    <td colspan="6" align="center">内容为空，还没添加章节</td>
                </tr>
                <?php 
                }
                 ?>
            </table>
        </form>
    </div>
</div>
<?php } ?>
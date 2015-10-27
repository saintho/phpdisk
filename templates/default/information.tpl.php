<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: information.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="panel panel-primary">
    <div class="panel-heading"><img src="images/light.gif" align="absmiddle" border="0" /> <?=__('tips_message')?></div>
    <div class="panel-body">
        <div align="center"><?=$msg?></div>
        <div align="center"><a href="<?=$url?>"><?=__('click_to_back')?></a></div><br>
    </div>
</div>
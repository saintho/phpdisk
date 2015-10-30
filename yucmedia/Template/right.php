<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <?php include('common/common.php');?>
</head>
<body>
<?php include('common/header.php');?>
<div id="content">
    <div id="title">目录权限</div>
    <div id="dir-list">
        <?php
        $ri = '<span class="ri">V</span>';
        $er = '<span class="er">X</span>';
        ?>
        <?php foreach ($_dirs as $key => $write): ?>
        <div class="item">
            <?php if (in_array($key, $_specail)): ?>
            <div class="dir"><?php echo $key; ?> </div>
            <div class="result"><?php echo $write ? $ri : $er; ?></div>
            <span style="color: red;">必须必备可写权限</span>
            <?php else: ?>
            <div class="dir"><?php echo $key; ?> </div>
            <div class="result"><?php echo $write ? $ri : $er; ?></div>
            <?php endif; ?>
        </div>
        <?php endforeach;?>
    </div>
</div>
<?php include('common/footer.php');?>
</body>
</html>
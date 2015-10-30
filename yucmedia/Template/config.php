<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <?php include('common/common.php');?>
</head>
<body>
<?php include('common/header.php');?>
<div id="content">
    <?php if ($_write): ?>
    <div id="config">
        <div id='title'>配置文件</div>
        <form action="./install.php?act=config" method="post">
            <div><label>站点编码：</label></label>
                <select name="YUC_RESPONSE_CHARSET">
                    <option value="UTF-8" selected="">UTF-8</option>
                </select>
                <div class="remark">选择与你对应的站点编码！</div>
            </div>
            <div><label>缓存周期：</label></label><input type="text" name="YUC_CACHE_EXPIRE"
                                                    value="<?php echo $_config['YUC_CACHE_EXPIRE'];?>"/>

                <div class="remark">插件缓存需要的缓存失效周期！</div>
            </div>
            <div><label>日志类型：</label></label>
                <?php foreach ($_log_type as $item): ?>
                    <input type="checkbox"
                           name="YUC_LOG_TYPE[]" <?php echo in_array($item, $_config['YUC_LOG_TYPE']) ? 'checked' : '';?>
                           value="<?php echo $item;?>"><?php echo $item; ?>
                    <?php endforeach;?>
                <div class="remark">选择需要输出的日志类型！调试完成后请只选择“EMERG”类型！</div>
            </div>
            <div><label>日志大小：</label></label><input type="text" name="YUC_LOG_SIZE"
                                                    value="<?php echo $_config['YUC_LOG_SIZE'];?>"/>

                <div class="remark">插件会产生相关的日志，每个日志文件的大小！</div>
            </div>
            <div><label>站点KEY：</label></label><input type="text" name="YUC_SITE_KEY"
                                                     value="<?php echo $_config['YUC_SITE_KEY'];?>"/>

                <div class="remark">站点的唯一标示，表示站点唯一性！</div>
            </div>
            <div><label>密钥：</label></label><input type="text" name="YUC_SECURE_KEY"
                                                  value="<?php echo $_config['YUC_SECURE_KEY'];?>"/>
                <div class="remark">系统插件与官方服务器通信时加密使用！</div>
            </div>
            <div><label>插件目录：</label></label><input type="text" name="YUC_INSTALL_DIR"
                                                    value="<?php echo $_config['YUC_INSTALL_DIR'];?>"/>
                <div class="remark">必须输入插件的相对安装路径</div>
            </div>
            <div><label>永久本地化：</label></label>
                <select name="YUC_CODE_IS_LOCAL">
                    <option
                        value="0" <?php echo $_config['YUC_CODE_IS_LOCAL'] == 0 ? 'selected' : '';?> >
                        关闭
                    </option>
                    <option
                        value="1" <?php echo $_config['YUC_CODE_IS_LOCAL'] == 1 ? 'selected' : '';?> >
                        开启
                    </option>
                </select>
                <div class="remark">是否本地化,在此开启永久本地化验证码！</div>
            </div>
            <div>
                <input type="submit" name="submit" value="提交配置">
            </div>
        </form>
    </div>
    <?php else: ?>
    <div id="error">
        <div>配置文件没有写权限，请配置权限！</div>
        <div>配置完成后在进行配置！</div>
    </div>
    <?php endif;?>
</div>
<?php include('common/footer.php');?>
</body>
</html>
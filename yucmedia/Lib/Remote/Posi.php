<?php

/**
 * 定义 Posi 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo Description
 * @version $Id: Posi.php 1852 2012-08-31 02:57:50Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-08-31 10:57:50 +0800 (星期五, 2012-08-31) $
 * @package Posi
 */
class Remote_Posi {

    public function update() {
        Log::Write(serialize($_POST));
        $result = posi_update(json_decode($_POST['posi'], true));
        if ($result) {
            return array('result' => 1, 'content' => '');
        } else {
            return array('result' => 0, 'content' => '无权限写入数据本地配置文件');
        }
    }

    public function remove() {
        $result = posi_remove($_POST['posi_id']);
        if ($result) {
            return array('result' => 1, 'content' => '');
        } else {
            return array('result' => 0, 'content' => '无权限写入数据本地配置文件');
        }
    }

}



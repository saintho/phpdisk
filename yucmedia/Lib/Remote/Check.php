<?php

/**
 * 定义 Check 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo Description
 * @version $Id: Check.php 1852 2012-08-31 02:57:50Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-08-31 10:57:50 +0800 (星期五, 2012-08-31) $
 * @package Check
 */
class Remote_Check {

    public function link() {
        return array(
            'result' => 1,
            'content' => array('site_key' => md5(App::getConfig('YUC_SITE_KEY')))
        );
    }

    /**
     *  遍历插件下的所有文件
     * @return type
     */
    public function files() {
        return array(
            'result' => 1,
            'content' => Files::getFileSafeScanRecyle(M_PRO_DIR)
        );
    }

    public function dirs() {
        return array(
            'result' => 1,
            'content' => Files::getDirSafeScanRecyle(M_PRO_DIR)
        );
    }

}


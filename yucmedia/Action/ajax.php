<?php

/**
 * 定义 Ajax 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: ajax.php 1186 2012-07-25 02:29:24Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-07-25 10:29:24 +0800 (周三, 2012-07-25) $
 * @package Ajax
 */
define('P_IS_ACCESS', TRUE);

require('./_base.php');

class Ajax extends YPrepose implements YIAction {

    public function __construct() {
        parent::__construct();
    }

    /**
     *  获取校验结果
     * @return type
     */
    public function run() {
        $ret = Verify::getVerifyResult();
        $back_result = array(
            'code' => Verify::getCode(),
            'result' => Verify::getResult(),
            'details' => Verify::getDetails()
        );
        echo 'yuc_site_config.ajaxresult=' . json_encode($back_result);
    }
}

YAccess::run('Ajax');


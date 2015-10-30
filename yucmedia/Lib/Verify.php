<?php

/**
 * 定义 Verify 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: Verify.php 1852 2012-08-31 02:57:50Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-08-31 10:57:50 +0800 (星期五, 2012-08-31) $
 * @package Verify
 */

class Verify {

    static private $_result = FALSE;
    static private $_details = '';
    static private $_code = '';

    /**
     *  获取校验结果
     * @return type
     */
    static public function getVerifyResult() {
        $context = new Context();
        $typhoon = new Typhoon();
        if ($typhoon->isValid()) {
            $ssid = $typhoon->_ssid;
            $name = $typhoon->_name;
            $value = $context->get($name, '');
            if ($value != '') {
                if ($typhoon->_request_type == 1) {
                    $ret = Valid::sendVerifyRemoteRequest($ssid, $value, $typhoon->_diff_time);
                } else {
                    $ret = Valid::sendVerifyLocalRequest($ssid, $value);
                }
                self::$_result = Valid::getResult();
                self::$_code = Valid::getCode();
                self::$_details = Valid::getDetails();
            } else {
                self::$_result = 0;
                self::$_code = 'E_VALUEEMPTY_001';
                self::$_details = '验证码不可以为空';
            }
        } else {
            self::$_result = 0;
            self::$_code = 'E_PARAM_001';
            self::$_details = '重要参数传递错误';
        }
        return (self::$_result === 1 ? TRUE : FALSE);
    }

    /**
     * 验证结果
     * @return type
     */
    static public function getResult() {
        return self::$_result;
    }

    /**
     * 验证编码
     * @return type
     */
    static public function getCode() {
        return self::$_code;
    }

    /**
     * 验证描述
     * @return type
     */
    static public function getDetails() {
        return self::$_details;
    }


}



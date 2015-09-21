<?php

/**
 * 定义 YucCaptcha 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id:$
 * @author Administrator
 * @author $Author: $
 * $Date: 2012-07-10 09:46:31 +0800 (周二, 2012-07-10) $
 * @package YucCaptcha
 */

define('M_IS_ACCESS', TRUE);

define('M_PRO_DIR', dirname(__FILE__)); //定义项目目录

/**
 * 加载必须的 类
 */
require(M_PRO_DIR . '/Core/YApp.php');

YApp::start();
require(M_PRO_DIR . '/Lib/YucMonitor.php');

require(M_PRO_DIR . "/Lib/YucRequest.php");
require(M_PRO_DIR . '/Lib/YucContext.php');
//本地验证码时使用
require(M_PRO_DIR . '/Lib/YucCrypt.php');
require(M_PRO_DIR . '/Lib/YucMath.php');

class YucCaptcha {

    static private $_result = FALSE;
    static private $_details = '';
    static private $_code = '';

    /**
     *  获取校验结果
     * @param array $extra
     * @return type
     */
    static public function getVerifyResult($extra = array()) {
        $typhoon = self::getParams();
        if ($typhoon["_isValid"]) {
            $ssid = $typhoon["_ssid"];
            $name = $typhoon["_name"];
            $value = self::context($name, NULL, '');
            if (trim($value) != '') {
                if ($typhoon["_request_type"] == 1) {
                    self::sendVerifyRemoteRequest($ssid, $value, $typhoon["_diff_time"], $extra);
                } else {
                    self::sendVerifyLocalRequest($ssid, $value);
                }
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
     *  获取校验结果
     * @param $ssid
     * @param $result
     * @param int $diff
     * @param array $extra
     * @return type
     */
    static public function sendVerifyRemoteRequest($ssid, $result, $diff = 0, $extra = array()) {
        $client = new YucRequest(YApp::getConfig('YUC_SERVICE_NAME'), YApp::getConfig('YUC_SERVICE_PORT'));
        $client->setTimeout(YApp::getConfig('YUC_CLIENT_TIMEOUT')); //设置超时
        $client->post(YApp::getConfig('YUC_VERIFY_PATH'), array(
            'site_key' => YApp::getConfig('YUC_SITE_KEY'),
            'secure_key' => YApp::getConfig('YUC_SECURE_KEY'),
            'ssid' => $ssid,
            'result' => $result,
            'diffsec_client' => $diff,
            'extra' => $extra,
        ));
        $post_req = json_decode($client->getContent(), TRUE);
        YLog::Write('远程验证完成,输入结果为：' . $result . '，返回状态 ：' . $client->getStatus() . ';' . 'POST 验证码正确性请求返回的数据：' . $client->getContent(), YLog::DEBUG);
        if ($client->getStatus() == 200 && is_array($post_req)) {
            self::$_code = $post_req['code'];
            self::$_details = $post_req['details'];
            self::$_result = $post_req['result'];
        } else {
            self::$_code = 'E_SEVERVALID_001';
            self::$_details = '服务器请求失败!';
            self::$_result = 0;
        }
    }

    /**
     *  本地验证
     * @param type $ssid
     * @param type $result
     * @return type
     */
    static public function sendVerifyLocalRequest($ssid, $result) {
        $mass = self::context('yuc_mass', NULL, '');
        $code = YucCrypt::decrypt(base64_decode(urldecode($mass)), YucMath::erypt_key());
        $code = str_replace(",", "", $code);
        if ($code != '' && strtolower($code) === strtolower($result)) {
            self::$_result = 1;
            self::$_code = '';
            self::$_details = '验证码输入正确';
        } else {
            self::$_result = 0;
            self::$_code = 'E_LOCALVALID_001';
            self::$_details = '验证码验证失败';
        }
        YLog::Write('本地验证完成,输入结果为：' . $result . ';' . '', YLog::DEBUG);
    }

    /**
     * 台风域的参数分析
     * @return array|bool
     */
    static public function getParams() {
        $ret = array();
        $_value = self::context('yuc_typhoon_west', NULL, '');
        $_params = explode(',', $_value);
        $_sid = isset($_params[0]) ? $_params[0] : '';
        $_cid = isset($_params[1]) ? $_params[1] : '';
        $_ssid = $_sid . ',' . $_cid;
        $_name = isset($_params[2]) ? $_params[2] : '';
        $_request_type = isset($_params[3]) ? $_params[3] : 0;
        $_diff_time = isset($_params[4]) ? $_params[4] : 0;
        $ret["_value"] = $_value;
        $ret["_sid"] = $_sid;
        $ret["_cid"] = $_cid;
        $ret["_ssid"] = $_ssid;
        $ret["_name"] = $_name;
        $ret["_request_type"] = $_request_type;
        $ret["_diff_time"] = $_diff_time;
        if ($_sid != '' && $_cid != '' && $_name != '' && $_request_type != '') {
            $ret["_isValid"] = TRUE;
        } else {
            $ret["_isValid"] = FALSE;
        }
        return $ret;
    }

    /**
     * 获取 设置参数
     * @param $key
     * @param null $value
     * @param null $default
     * @return null
     */
    static public function context($key, $value = NULL, $default = NULL) {
        if ($value == NULL) {
            if (isset($_GET[$key])) {
                return $_GET[$key];
            } else if (isset($_POST[$key])) {
                return $_POST[$key];
            } else {
                return $default;
            }
        } else {
            $_GET[$key] = $value;
            $_POST[$key] = $value;
        }
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

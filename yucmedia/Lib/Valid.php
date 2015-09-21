<?php

/**
 * 定义 Valid 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: Valid.php 2186 2012-09-18 09:48:05Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-09-18 17:48:05 +0800 (星期二, 2012-09-18) $
 * @package Valid
 */
class Valid {

    static private $_yuc_result = 0;
    static private $_yuc_details = '';
    static private $_yuc_code = '';

    /**
     *  获取校验结果
     * @param $ssid
     * @param $result
     * @param int $diff
     * @return type
     */
    static public function sendVerifyRemoteRequest($ssid, $result, $diff = 0) {
        $client = new HttpClient(App::getConfig('YUC_SERVICE_NAME'), App::getConfig('YUC_SERVICE_PORT'));
        $client->setTimeout(App::getConfig('YUC_CLIENT_TIMEOUT')); //设置超时
        $client->post(App::getConfig('YUC_VERIFY_PATH'), array(
            'site_key' => App::getConfig('YUC_SITE_KEY'),
            'ssid' => $ssid,
            'result' => $result,
            'diffsec_client' => $diff,
        ));
        $post_req = json_decode($client->getContent(), TRUE);
        Log::Write('远程验证完成,输入结果为：' . $result . '，返回状态 ：' . $client->getStatus() . ';' . 'POST 验证码正确性请求返回的数据：' . $client->getContent(), Log::DEBUG);
        if ($client->getStatus() == 200 && is_array($post_req)) {
            //200状态 正常返回数据 且返回数据格式正常
            self::$_yuc_code = $post_req['code'];
            self::$_yuc_details = $post_req['details'];
            self::$_yuc_result = $post_req['result'];
        } else {
            self::$_yuc_code = 'E_SEVERVALID_001';
            self::$_yuc_details = '服务器请求失败!';
            self::$_yuc_result = 0;
        }
        return array(
            'code' => self::$_yuc_code,
            'result' => self::$_yuc_result,
            'details' => self::$_yuc_details
        );
    }

    /**
     *  本地验证
     * @param type $ssid
     * @param type $result
     * @return type
     */
    static public function sendVerifyLocalRequest($ssid, $result) {
        $mass = Context::getInstance()->get('yuc_mass', '');
        $code = Crypt::decrypt(urldecode($mass), Math::erypt_key());
        $code = str_replace(",", "", $code);

        if ($code != '' && strtolower($code) === strtolower($result)) {
            self::$_yuc_result = 1;
            self::$_yuc_code = '';
            self::$_yuc_details = '验证码输入正确';
        } else {
            self::$_yuc_result = 0;
            self::$_yuc_code = 'E_LOCALVALID_001';
            self::$_yuc_details = '验证码验证失败';
        }
        Log::Write('本地验证完成,输入结果为：' . $result . ';' . '', Log::DEBUG);
        return array(
            'code' => self::$_yuc_code,
            'result' => self::$_yuc_result,
            'details' => self::$_yuc_details
        );
    }

    /**
     * 验证结果
     * @return type
     */
    static public function getResult() {
        return self::$_yuc_result;
    }

    /**
     * 验证编码
     * @return type
     */
    static public function getCode() {
        return self::$_yuc_code;
    }

    /**
     * 验证描述
     * @return type
     */
    static public function getDetails() {
        return self::$_yuc_details;
    }

}


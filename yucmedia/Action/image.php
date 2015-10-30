<?php

/**
 * 定义 SafeCode 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: image.php 2186 2012-09-18 09:48:05Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-09-18 17:48:05 +0800 (周二, 2012-09-18) $
 * @package SafeCode
 */
define('P_IS_ACCESS', TRUE);

require('./_base.php');

class Image extends YPrepose implements YIAction {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 参数说明 全部由URL 接入参数值 目前提供参数为以下
     */
    public function run() {
        $is = $this->_context->get('I_S', '');
        $iw = 'YucMedia CopyRight ' . date('Y') . ' <Local>';
        $mass = $this->_context->get('mass', '');
        $apiParam = $this->getApiParamValue();
        if ($is != '' && $mass !== '') {
            $code = explode(',', YucCrypt::decrypt(base64_decode(urldecode($mass)), YucMath::erypt_key()));
            YucCaptcha::showComplexImage($code, 20, 5, 2, $apiParam['width'], $apiParam['height'], $apiParam['fontsize'], $iw);
        } else {
            YucCaptcha::showImgDesc('Access defined!', $iw, $apiParam['width'], $apiParam['height'], $apiParam['fontsize']);
        }
    }

    /**
     *  参数值 有URL传入
     * @return array
     */
    private function getApiParamValue() {
        $ret = array();
        $ret['width'] = $this->getValueInRange('width', 160, 320, 245);
        $ret['height'] = $this->getValueInRange('height', 90, 180, 185);
        $ret['fontsize'] = $this->getValueInRange('fontsize', 30, 60, 30);
        return $ret;
    }

    /**
     *  获取值的确定值 为了安全着想
     * @param type $key
     * @param type $default
     * @param type $max
     * @param type $min
     * @return type
     */
    private function getValueInRange($key, $default, $max, $min) {
        $value = $this->_context->get($key, $default);
        if ($value > $max) {
            return $max;
        } else if ($value < $min) {
            return $min;
        } else {
            return $value;
        }
    }
}

YAccess::run('Image');


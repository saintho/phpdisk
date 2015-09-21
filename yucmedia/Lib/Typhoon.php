<?php

/**
 * 定义 Typhoon 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo Description
 * @version $Id: Typhoon.php 1852 2012-08-31 02:57:50Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-08-31 10:57:50 +0800 (星期五, 2012-08-31) $
 * @package Typhoon
 */
class Typhoon {

    private $_context;
    private $_value;
    private $_params;
    public $_sid;
    public $_cid;
    public $_ssid;
    public $_name;
    public $_request_type;
    public $_diff_time;

    public function __construct() {
        $this->_context = new Context();
        $this->getParams();
    }

    /**
     *  组装参数 以数组返回
     * @return type
     */
    private function getParams() {
        $this->_value = $this->_context->get('yuc_typhoon_west', '');
        $this->_params = explode(',', $this->_value);
        $this->_sid = isset($this->_params[0]) ? $this->_params[0] : '';
        $this->_cid = isset($this->_params[1]) ? $this->_params[1] : '';
        $this->_ssid = $this->_sid . ',' . $this->_cid;
        $this->_name = isset($this->_params[2]) ? $this->_params[2] : '';
        $this->_request_type = isset($this->_params[3]) ? $this->_params[3] : 0;
        $this->_diff_time = isset($this->_params[4]) ? $this->_params[4] : 0;
        return $this->_params;
    }

    /**
     *  参数是否有效
     * @return boolean
     */
    public function isValid() {
        if ($this->_sid != '' && $this->_cid != '' && $this->_name != '' && $this->_request_type != '') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}



<?php

/**
 * 定义 ComParam 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo 公共参数类
 * @version $Id: ComParam.php 1852 2012-08-31 02:57:50Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-08-31 10:57:50 +0800 (星期五, 2012-08-31) $
 * @package ComParam
 */
class ComParam {

    private $_cell = array ();
    private $_special = array ();

    public function __construct() {
        ;
    }

    private function setSpecial($keys) {
        if (is_array($keys)) {
            $this->_special = array_merge($this->_special, $keys);
        } else {
            $this->_special[] = $keys;
        }
    }

    public function set($key, $value) {
        $this->_cell[$key] = $value;
    }

    /**
     *  从json数据创建数据
     * @param type $json
     */
    public function createdFromJson($json) {
        $items = json_decode($json);
        if (is_array($items)) {
            foreach ($items as $key => $value) {
                $this->set($key, $value);
            }
        }
    }

    /**
     *  从数组创建数据
     * @param type $arr
     */
    public function createdFromArray($arr) {
        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                $this->set($key, $value);
            }
        }
    }

    /**
     *  删除数据
     * @param type $key
     * @return boolean
     */
    public function remove($key) {
        if (is_string($key)) {
            unset($this->_cell[$key]);
            if (!isset($this->_cell[$key])) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * 整理数据，将数据转换成JS对象格式的
     * @param array $keys
     * @return string
     */
    public function createdJsVar($keys = array ()) {
        $obj_name = 'yuc_site_config';
        $this->setSpecial($keys);
        $ret = "{$obj_name}=new Object();";
        foreach ($this->_cell as $key => $value) {
            if (in_array(strtolower($key), $this->_special)) {
                $ret .= "{$obj_name}.{$key}={$value};";
            } else if (trim($value) == '' || is_string($value)) {
                $ret .= "{$obj_name}.{$key}=\"{$value}\";";
            } else if (is_numeric($value)) {
                $ret .= " {$obj_name}.{$key}={$value};";
            } else {
                $ret .= " {$obj_name}.{$key}={$value};";
            }
        }
        return $ret;
    }

}


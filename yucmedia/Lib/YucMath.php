<?php

/**
 * 定义 Math 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo Description
 * @version $Id: Math.php 2190 2012-09-19 01:55:55Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-09-19 09:55:55 +0800 (周三, 2012-09-19) $
 * @package Math
 */
class YucMath {

    /**
     *  生成序列id
     * @param int $No
     * @return type
     */
    static public function createdSerialId($No = 20) {
        $ret = '';
        for ($i = 0; $i < $No; $i++) {
            $ret .= mt_rand(0, 9) . '.';
        }
        return $ret . mt_rand(0, 9);
    }

    /**
     *  生成多节序列号
     * @param int|\type $m
     * @param int|\type $No
     * @return string|\type
     */
    static public function getMultiSerialId($m = 2, $No = 20) {
        $ret = '';
        for ($i = 0; $i < $m; $i++) {
            if ($ret == '') {
                $ret = self::createdSerialId($No);
            } else {
                $ret .= '-' . self::createdSerialId($No);
            }
        }
        return $ret;
    }

    /**
     * 获取ssid
     * @return type
     */
    static public function createdRandSsidSerial() {
        return md5(self::getMultiSerialId(5, 30));
    }

    /**
     *  获取生成验证码字符
     * @param int $codeType
     * @param int $codeNum
     * @return type
     */
    static function getCheckCode($codeNum = 4, $codeType = 4) {
        $codeStr = '去我饿人他一哦平啊是的飞个好就看了在想才吧你吗张辉赵俊平刘东赵俊利';
        $strNum = strlen($codeStr) / 3 - 1;
        $string = array();
        switch ($codeType) {
            case 1:
                //数字字符串
                $string = array_rand(range(0, 9), $codeNum);
                break;
            case 2:
                //大字母字符串
                $string = array_rand(array_flip(range('A', 'Z')), $codeNum);
                break;
            case 3:
                //汉字字符串
                for ($i = 0; $i < ($codeNum); $i++) {
                    $start = mt_rand(0, $strNum);
                    $string[$i] = self::msubstr($codeStr, $start);
                }
                break;
            case 4:
                //混合字符串
                for ($i = 0; $i < ($codeNum); $i++) {
                    $rand = mt_rand(0, 2);
                    switch ($rand) {
                        case 0:
                            $ascii = mt_rand(48, 57);
                            $string[$i] = sprintf('%c', $ascii);
                            break;
                        case 1:
                            $ascii = mt_rand(97, 122);
                            $string[$i] = sprintf('%c', $ascii);
                            break;
                        case 2:
                            $start = mt_rand(0, $strNum);
                            $string[$i] = self::msubstr($codeStr, $start);
                            break;
                    }
                }
        }
        return $string;
    }

    //+--------------------------------------------------------------------------------
    //* 中文截取 ThinkPHP中的中文截取checkCode
    //+--------------------------------------------------------------------------------
    //* @return string
    //+--------------------------------------------------------------------------------
    static protected function msubstr($str, $start = 0, $length = 1, $charset = "utf-8") {
        if (function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset); elseif (function_exists('iconv_substr')) {
            $slice = iconv_substr($str, $start, $length, $charset);
        } else {
            $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("", array_slice($match[0], $start, $length));
        }
        return $slice;
    }

    static function erypt_key() {
        $key = YApp::getConfig("YUC_SECURE_KEY") . date('Y-m-d');
        return $key;
    }
}


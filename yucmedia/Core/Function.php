<?php

/**
 * 定义 Function 函数文件
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: Function.php 2382 2012-09-29 01:46:55Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-09-29 09:46:55 +0800 (周六, 2012-09-29) $
 * @package Function
 */

/**
 *  文件缓存的快速缓存
 * @param type $key
 * @param type $data
 * @param type $expire
 * @return type
 */
function F($key, $data = NULL, $expire = NULL) {
    $cache = new YFileCache();
    if ($expire !== NULL) {
        $cache->setExpire(YApp::getConfig('YUC_CACHE_EXPIRE'));
    }
    if ($data === NULL) {
        return $cache->get($key);
    } else {
        return $cache->set($key, $data);
    }
}

/**
 *  返回JSON数据
 * @param type $result
 * @return type
 */
function returnJSON($result) {
    return json_encode($result);
}

/**
 *  Ajax返回
 * @param type $result
 */
function _returnAjax($result) {
    @header("Content-type: text/html; charset=" . YApp::getConfig('YUC_RESPONSE_CHARSET'));
    @header("Pragma:no-cache\r\n");
    @header("Cache-Control:no-cache\r\n");
    @header("Expires:0\r\n");
    echo $result;

}

/**
 *  Ajax JSON 返回
 * @param type $result
 */
function _returnJsonAjax($result) {
    @header("Content-type: text/html; charset=" . YApp::getConfig('YUC_RESPONSE_CHARSET'));
    @header("Pragma:no-cache\r\n");
    @header("Cache-Control:no-cache\r\n");
    @header("Expires:0\r\n");
    echo json_encode($result);

}

function _returnCryptAjax($result) {
    @header("Content-type: text/html; charset=" . YApp::getConfig('YUC_RESPONSE_CHARSET'));
    @header("Pragma:no-cache\r\n");
    @header("Cache-Control:no-cache\r\n");
    @header("Expires:0\r\n");
    echo Crypt::encrypt(json_encode($result), YApp::getConfig("YUC_SECURE_KEY"));

}

/**
 * 向系统导入数组文件
 * @param type $file
 * @return type
 */
function loadArrayFile($file) {
    $data = require($file);
    if (is_array($data)) {
        return $data;
    }
    return array();
}

/**
 * 持久化数组
 * @param $file
 * @param $array
 * @return bool
 */
function saveArrayFile($file, $array) {
    $cache_data = var_export($array, TRUE);
    if (file_exists($file) && is_writable($file)) {
        @file_put_contents($file, '<?php return ' . $cache_data . ';?>');
        return TRUE;
    } else {
        YucMonitor::report("REPORT_0009");
        return FALSE;
    }
}

/**
 * 更新 广告位
 * @param $config
 * @return bool
 */
function posi_update($config) {
    if (count($config) > 0) {
        $file = M_PRO_DIR . '/Config/position.php';
        $posi = loadArrayFile($file);
        return saveArrayFile($file, array_merge($posi, $config));
    }
    return FALSE;
}

/**
 * 删除广告位
 * @param $posi_id
 * @return bool
 */
function posi_remove($posi_id) {
    $file = M_PRO_DIR . '/Config/position.php';
    $posi = loadArrayFile($file);
    if (isset($posi[$posi_id])) {
        unset($posi[$posi_id]);
        return saveArrayFile($file, $posi);
    }
    return FALSE;
}


/**
 * 获取客户端ip地址
 * @return string
 */
function getClientIp() {
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $clientip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $clientip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
        $clientip = $_SERVER["REMOTE_ADDR"];
    } else {
        $clientip = '0.0.0.0';
    }
    return $clientip;
}


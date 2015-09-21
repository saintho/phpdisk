<?php

/**
 * 定义 Monitor 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id:$
 * @author Administrator
 * @author $Author: $
 * $Date: 2012-07-10 09:46:31 +0800 (周二, 2012-07-10) $
 * @package Monitor
 */

class YucMonitor {

    /**
     * 主动上报
     * @param $code
     * @param string $content
     * @internal param $details
     * @internal param array $data
     */
    static function report($code, $content = '') {
        $client = new YucRequest(YApp::getConfig('YUC_SERVICE_NAME'), YApp::getConfig('YUC_SERVICE_PORT'));
        $client->setTimeout(YApp::getConfig('YUC_CLIENT_TIMEOUT')); //设置超时
        $client->post(YApp::getConfig('YUC_MONITOR_PATH'), array(
            'site_key' => YApp::getConfig('YUC_SITE_KEY'),
            'code' => $code,
            'content' => $content,
            'datetime' => date("Y-m-d H:i:s"),
            'server' => $_SERVER,
        ));
        $result = json_decode($client->getContent(), TRUE);
        YLog::Write(var_export($result, TRUE), YLog::DEBUG);
        if ($client->getStatus() == 200 && is_array($result) && count($result) == 2 && $result['result'] == 1) {
            YLog::Write('主动上报信息成功！Code:' . $code . ';Content:' . $content, YLog::DEBUG);
        } else {
            YLog::Write('主动上报信息失败！', YLog::DEBUG);
        }
    }
}

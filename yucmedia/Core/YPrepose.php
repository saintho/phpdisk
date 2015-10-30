<?php

/**
 * 定义 YPrepose 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo Description
 * @version $Id:$
 * @author Administrator
 * @author $Author:$
 * $Date:$
 * @package Prepose
 */
class YPrepose {

    protected $_context;

    public function __construct() {
        $this->_context = new YucContext();
    }

    /**
     *  析构函数
     */
    public function __destruct() {
        YLog::Write('System Run Time >>>>：' . (microtime(TRUE) - M_START_TIME), YLog::DEBUG);
    }

}


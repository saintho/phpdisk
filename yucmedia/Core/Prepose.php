<?php

/**
 * 定义 Prepose 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo Description
 * @version $Id:$
 * @author Administrator
 * @author $Author:$
 * $Date:$
 * @package Prepose
 */
class Prepose {

    protected $_context;

    public function __construct() {
        $this->_context = new Context();
    }

    /**
     *  析构函数
     */
    public function __destruct() {
        Log::Write('System Run Time >>>>：' . (microtime(TRUE) - M_START_TIME), Log::DEBUG);
    }

}


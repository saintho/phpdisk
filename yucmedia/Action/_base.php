<?php

/**
 * 定义 _base 文件
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo 统一加载核心文件，开始启动核心文件
 * @version $Id: _base.php 1852 2012-08-31 02:57:50Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-08-31 10:57:50 +0800 (周五, 2012-08-31) $
 * @package _base
 */

date_default_timezone_set("PRC");

require(dirname(dirname(__FILE__)) . '/Core/YAccess.php');
// 开始执行框架初始化
YAccess::start();


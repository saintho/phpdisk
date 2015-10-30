<?php

/**
 * 定义 _base 文件
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: _base.php 1275 2012-08-01 07:51:11Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-08-01 15:51:11 +0800 (星期三, 2012-08-01) $
 * @package _base
 */

require(dirname(dirname(__FILE__)) . '/Core/Access.php');
// 开始执行框架初始化
Access::start();
?>

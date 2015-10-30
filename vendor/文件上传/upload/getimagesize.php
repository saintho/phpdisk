<?php 
//getimagesize($filename):得到指定图片的信息,如果是图片返回数组
//如果不是图片，返回false
$filename='nv.jpg';
$filename='1.jpg';
var_dump(getimagesize($filename));
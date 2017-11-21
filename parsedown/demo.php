<?php
/**
 * Author: CYLeft
 * Date: 2017-11-9
 * Time: 19:29
 */
include 'ParseDown.php';

$file_path = "README.md";

if(file_exists($file_path)){
    $fp = fopen($file_path,"r");
    $str = fread($fp,filesize($file_path));//指定读取大小，这里把整个文件内容读取出来
}

$ParseDown = new ParseDown();

echo $ParseDown->text($str);

var_dump($ParseDown->header($str));


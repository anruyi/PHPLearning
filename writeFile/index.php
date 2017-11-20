<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-16
 * Time: 22:53
 */
$title = '$';
$MDFileName = preg_replace('/[\\\\\/:?<>|*"]/','-',$title);
echo $MDFileName;
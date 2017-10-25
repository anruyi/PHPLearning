<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-10-25
 * Time: 21:59
 */

header( 'Content-Type:text/html;charset=utf-8 ');

if(isset($_POST['captcha'])){
    session_start();
    if( $_SESSION['captcha'] == strtolower($_POST['captcha']) ){
        echo "验证正确";
    } else
        echo "验证错误";
}
<?php
include "captcha.php";
//phpinfo();

/**
 * 载入图片
 */
//$imgSrc = "images/boy_4.jpg";
//
//$imgInfo = getimagesize($imgSrc);
//
//$imgType = image_type_to_extension($imgInfo[2],false);
//
//$function1 = "imagecreatefrom{$imgType}";
//
//$image = $function1($imgSrc);
//
///**
// * 处理图片
// */
//$color = imagecolorallocatealpha($image,255,255,255,50);
//
//$fontFile = "fonts/simfang.ttf";
//
//$text = "imooc";
//
//imagettftext($image,20,0,12,12, $color, $fontFile, $text);
//
///**
// * 输出图片
// */
//header("Content-type:".$imgInfo[mime]);
//
//imagejpeg($image);
//
//$function2 = "image{$imgType}";
//
//$function2($image);
//
///**
// * 销毁图片，节省开销
// */
//
//imagedestroy($image);

$pic = new captcha();
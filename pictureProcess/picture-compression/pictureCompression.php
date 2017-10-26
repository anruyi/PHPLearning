<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-10-26
 * Time: 19:22
 */

function zoomPicture($fileName='pictures/hua.jpg',$savePath = "./pictures/newPicture.jpg")
{

    //判断存储路径是否存在
    $Path = $savePath;
    if(file_exists($Path)){

    }
    $src_image = imagecreatefromjpeg($fileName);

    list($src_w,$src_h,$imageType) = getimagesize($fileName);

    $scare = 0.5;

    $dst_w = ceil($scare*$src_w);
    $dst_h = ceil($scare*$src_h);

    $dst_image = imagecreatetruecolor($dst_w,$dst_h);

    //本来的图片 生成的图片
    imagecopyresampled($dst_image,$src_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);

    imagejpeg($dst_image,$savePath);

    imagedestroy($dst_image);
}

zoomPicture();


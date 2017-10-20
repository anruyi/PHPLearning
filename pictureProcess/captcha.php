<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-10-6
 * Time: 15:24
 */

class Captcha
{
    /**
     * Captcha constructor.
     * 构造图片
     */
    public function __construct()
    {

        /**
         * 创建背景图
         */
        $image = imagecreatetruecolor(100,30);

        $color = imagecolorallocate($image,255,255,255);

        imagefill($image,0,0,$color);

        for($i=0;$i<4;$i++){
            $fontSize = 6;
            $fontColor = imagecolorallocate($image,rand(0,120),rand(0,120),rand(0,120));
            $fontContent = rand(0,9);

            $x = $i*25+rand(5,10);
            $y = rand(5,10);

            imagestring($image,$fontSize,$x,$y,$fontContent,$fontColor);
        }

        for($i=0;$i<200;$i++){
            $pointColor = imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
            imagesetpixel($image,rand(1,99),rand(1,29),$pointColor);
        }

        for($i=0;$i<3;$i++){
            $lineColor = imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
            imageline($image,rand(1,20),rand(1,20),rand(180,200),rand(1,20),$lineColor);
        }

        header("content-type: image/jpeg");

        imagejpeg($image);

        imagedestroy($image);

    }



}
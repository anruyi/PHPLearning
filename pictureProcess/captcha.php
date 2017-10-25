<?php
/**
 * Created by PhpStorm.
 * User: CYLeft
 * Date: 2017-10-6
 * Time: 15:24
 * [基本图形验证码功能]
 * 一、生成动态数字验证码图片
 * 二、生成动态数字字母混合验证码
 * 三、生成干扰点
 * 四、生成干扰线
 */

namespace pictureProcess;

session_start();
class Captcha
{
    /**
     * Captcha constructor.
     * 构造图片
     */
    public function __construct($type = 0,$line = true,$point = true)
    {
        $_SESSION['captcha'] = $this->showCaptcha($type,$line,$point);
    }

    /**
     * @param int $type
     * @param bool $line
     * @param bool $point
     * @return bool|int
     * （一）输出验证码
     * （二）返回生成的动态码
     */
    private function showCaptcha($type = 0,$line = false,$point = false)
    {
        /**
         * 创建背景图
         */
        $image = imagecreatetruecolor(100,30);

        $color = imagecolorallocate($image,255,255,255);

        imagefill($image,0,0,$color);

        /**
         * 验证码类型
         */
        if($type==0)
        {
            $captcha = $this->number($image);
        } elseif ($type==1){
            $captcha = $this->mixture($image);
        }

        /**
         * 是否增加影响项目
         */
        if($line) $this->line($image);
        if($point) $this->point($image);

        /**
         * 设置文件头并显示
         */
        header("content-type: image/jpeg");

        imagejpeg($image);

        /**
         * 及时销毁内存图片，节省空间
         */
        imagedestroy($image);

        return $captcha;
    }

    /**
     * @param $image
     * @return bool|int
     * 创建随机数字（验证码）
     */
    private function number($image)
    {
        /**
         * 返回校验码
         */
        $number = 0;
        for($i=0;$i<4;$i++){
            $fontSize = rand(7,9);
            $fontColor = imagecolorallocate($image,rand(0,120),rand(0,120),rand(0,120));
            $fontContent = rand(0,9);
            $number = $number*10 + $fontContent;

            $x = $i*25+rand(5,10);
            $y = rand(5,10);

            imagestring($image,$fontSize,$x,$y,$fontContent,$fontColor);
        }
        if($number) {
            return $number;
        } else {
            return false;
        }
    }

    /**
     * @param $image
     * @return bool|int|string
     * [混合验证码]
     */
    private function mixture($image)
    {
        /**
         * 返回校验码
         */
        $mixture = null;

        $ran = "abcdefghijkmnpqrstuvwxyz23456789";

        for($i=0;$i<4;$i++){
            $fontSize = rand(6,9);
            $fontColor = imagecolorallocate($image,rand(0,120),rand(0,120),rand(0,120));
            $fontContent = substr($ran,rand(0,strlen($ran)-1),1);
            $mixture .= $fontContent;

            $x = $i*25+rand(5,10);
            $y = rand(5,10);

            imagestring($image,$fontSize,$x,$y,$fontContent,$fontColor);
        }
        if($mixture) {
            return $mixture;
        } else {
            return false;
        }
    }

    /**
     * @param $image 图形对象
     * [生成干扰点]
     */
    private function point($image)
    {
        for($i=0;$i<200;$i++){
            $pointColor = imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
            imagesetpixel($image,rand(1,99),rand(1,29),$pointColor);
        }
    }

    /**
     * @param $image 图形对象
     * [生成干扰点]
     */
    private function line($image)
    {

        for($i=0;$i<3;$i++){
            $lineColor = imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
            imageline($image,rand(1,20),rand(1,20),rand(180,200),rand(1,20),$lineColor);
        }
    }
}

/**
 * 创建对象
 */
$pic = new captcha(1,false,true);

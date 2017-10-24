<?php
/**
 * 一、封装成函数
 * 二、[单/多]文件上传
 */

/**
 * @param $fileInfo
 * @return mixed 获取并重组上传文件信息
 * 获取并重组上传文件信息
 * 如果是单文件，本方法无需调用，但是默认调用比较合适
 */
function getFiles()
{
    foreach ($_FILES as $file){
        $i = 0;
        if (is_string($file['name'])){
            $files[$i] = $file;
        } elseif (is_array($file['name'])) {
            foreach ($file['name'] as $key=>$val) {
                $files[$i]['name'] = $file['name'][$key];
                $files[$i]['type'] = $file['type'][$key];
                $files[$i]['tmp_name'] = $file['tmp_name'][$key];
                $files[$i]['error'] = $file['error'][$key];
                $files[$i]['size'] = $file['size'][$key];
                $i++;
            }
        }
    }
    return $files;
}

/**
 * @param $fileInfo 上传的文件 $_FILES
 * @param string $uploadPath 上传路径
 * @param array $allowExtension 允许上的文件类型
 * @return array 返回基本图片类型
 * 封装的单文件上传方法
 */
function uploadFile($fileInfo,$uploadPath = 'uploads',$allowExtension = array('jpeg','jpg','png','gif','wbmp')) {

    /**
     * 上传文件大小限制2M
     */
    $maxSize = 2097152;

    $msg = array();

    if ($fileInfo['error'] == UPLOAD_ERR_OK) {
        //$error == 0;

        /**
         * 上传文件限制基本逻辑
         * 1. 限制文件大小
         * 2. 限制文件格式
         * 3. 限制文件上传方式
         * 4. 自动创建伤上传目录
         * 5. 防止文件重复
         * 6. 文件上传成功，并把文件移动到指定位置
         * TODO 检测文件是否被用户恶意篡改后缀名基本思路可以使用getimagesize，获取图片信息，非图片是获取不到相关信息的/
         */

        if($fileInfo['size']>$maxSize){
            $msg[1] = '上传文件过大';
        }

        $extension = pathinfo($fileInfo['name'],PATHINFO_EXTENSION);
        if (!in_array($extension,$allowExtension)) {
            $msg[2] = '非法文件类型';
        }

        //is_uploaded_file判断文件是否通过post方法而来
        if (!is_uploaded_file($fileInfo['tmp_name'])) {
            $msg[3] = '文件不是通过POST上传而来';
        }

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath,0777,true);
            chmod($uploadPath,0777);
        }

        $uniqueName = uniqid().'_'.$fileInfo['name'];

        //move_uploaded_file只能移动post方法上传而来
        if (@move_uploaded_file($fileInfo['tmp_name'],$uploadPath."/".$uniqueName)){
            return array(
                'fileName' => $uniqueName,
                'size' => $fileInfo['size'],
                'type' => $fileInfo['type']
            );
        } else {
            echo $fileInfo['name'].'文件上传失败';
            print_r($msg);
        }
    } else {
        /**
         * 判断文件上传失败原因
         */

        switch ($fileInfo['error']) {
            case 1:
                $msg[0] =  '上传文件超过PHP配置文件中upload_max_fileSize选项';
                break;
            case 2:
                $msg[0] =  '超过MAX_FILE_SIZE限制大小';
                break;
            case 3:
                $msg[0] =  '文件部分上传';
                break;
            case 4:
                $msg[0] =  '没有选择上传文件';
                break;
            case 6:
                $msg[0] =  '没有找到上传临时目录';
                break;
            case 7:
            case 8:
                $msg[0] =  '系统错误';
                break;
        }
        return $msg[0];
    }

}

$files = getFiles();

foreach ($files as $fileInfo) {
    uploadFile($fileInfo,'uploads');
}
<?php
/**
 * 封装成类的[单/多]文件上传
 */

class Upload
{
    protected $files;
    protected $fileName;
    protected $maxSize;
    protected $allowMime;
    protected $allowExtension;
    protected $uploadPath;
    protected $imgFlag;
    protected $fileInfo;
    protected $msg = '未捕获到错误信息';
    public function __construct($fileName = 'myFile',$maxSize = 2097152,$uploadPath = 'uploads',$imgFlag = true,$allowExtension = array('jpeg','jpg','png','gif'),$allowMime=array('image/jpeg','image/png','image/gif'))
    {
//        $files = $this->getFiles();
//        print_r($files);

        $this->fileName = $fileName;
        $this->maxSize = $maxSize;
        $this->uploadPath = $uploadPath;
        $this->imgFlag = $imgFlag;
        $this->allowExtension = $allowExtension;
        $this->allowMime = $allowMime;
        $this->fileInfo = $_FILES[$this->fileName];
    }

    /**
     * @return mixed
     */
    function getFiles()
    {
        $files = array();
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
     * 检测是否出现error错误
     * @return bool
     */
    protected function checkError()
    {
        if (!is_null($this->fileInfo)) {
            if ($this->fileInfo['error'] > 0) {
                switch ($this->fileInfo['error']) {
                    case 1:
                        $this->msg =  '上传文件超过PHP配置文件中upload_max_fileSize选项';
                        break;
                    case 2:
                        $this->msg =  '超过MAX_FILE_SIZE限制大小';
                        break;
                    case 3:
                        $this->msg =  '文件部分上传';
                        break;
                    case 4:
                        $this->msg =  '没有选择上传文件';
                        break;
                    case 6:
                        $this->msg =  '没有找到上传临时目录';
                        break;
                    case 7:
                    case 8:
                        $this->msg =  '系统错误';
                        break;
                }
                return false;
            } else {
                return true;
            }
        } else {
            $this->msg = '文件上传出错';
        }
    }

    /**
     * 检测上传文件大小
     * @return bool
     */
    protected function checkSize()
    {
        if ($this->fileInfo['size'] > $this->maxSize) {
            $this->msg = '上传文件过大';
            return false;
        } else {
            return true;
        }
    }

    /**
     * 检测文件类型是否合法
     * @return bool
     */
    protected function checkExtension()
    {
        $extension = pathinfo($this->fileInfo['name'],PATHINFO_EXTENSION);
        if(!in_array($extension,$this->allowExtension)) {
            $this->msg = '不允许该文件扩展名的上传';
            return false;
        } else {
            return true;
        }
    }

    /**
     * 检测前端是否修改文件合法类型
     * @return bool
     */
    protected function checkMime()
    {
        if(!in_array($this->fileInfo['type'],$this->allowMime)) {
            $this->msg = '不允许该文件类型的上传end';
            return false;
        } else {
            return true;
        }
    }

    /**
     * 检测是否为真实的图片
     * @return bool
     */
    protected function checkTrueImage()
    {
        if ($this->imgFlag == true) {
            if (!@getimagesize($this->fileInfo['tmp_name'])) {
                $this->msg = '不是真实的图片';
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * 检测是否http post上传而来
     * @return bool
     */
    protected function checkHTTPPost()
    {
        if (!is_uploaded_file($this->fileInfo['tmp_name'])) {
            $this->msg = '不是通过http Post方式上传而来';
            return false;
        } else {
            return true;
        }
    }

    /**
     * 检测目录是否存在
     * @return bool
     */
    protected function checkUploadPath()
    {
        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath,0777,true);
            chmod($this->uploadPath,0777);
        } else {
            return true;
        }
    }

    protected function showError()
    {
        print_r($_FILES);
        exit("<span style='color: #f0f;'>{$this->msg}</span>");
    }

    function uploadFile() {
        if ($this->checkError() && $this->checkExtension() && $this->checkHTTPPost() && $this->checkMime() && $this->checkSize() && $this->checkTrueImage()) {

            $uniqueName = uniqid().'_'.$this->fileInfo['name'];
            $filePath = $this->uploadPath.'/'.$uniqueName;
            if (@move_uploaded_file($this->fileInfo['tmp_name'],$filePath)) {
               return $filePath;
            }
        } else {
            $this->showError();
        }
    }
}

$file = new Upload();
$file->uploadFile();

//$files = getFiles();
//
//print_r($files);
//
//foreach ($files as $fileInfo) {
//    uploadFile($fileInfo,'uploads');
//}
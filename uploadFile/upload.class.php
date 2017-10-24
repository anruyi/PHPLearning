<?php
/**
 * [单/多][文件/图片]上传
 * TODO 判断是单文件还是多文件上传，自动排查比较合适
 */

class Upload
{
    /**
     * 前端文件上传name值
     * 文件大小限制
     * 允许类型
     * 允许后缀名
     * 上传路径
     * 是否为图片上传
     */
    protected $fileName;
    protected $maxSize;
    protected $allowMime;
    protected $allowExtension;
    protected $uploadPath;
    protected $imgFlag;

    /**
     * 文件信息数组
     * 错误信息
     */
    protected $fileInfo;
    protected $msg = '未捕获到错误信息';

    /**
     * Upload constructor.
     * @param string $fileName 文件名
     * @param int $maxSize 文件大小
     * @param string $uploadPath 文件上传路径
     * @param bool $imgFlag 是否上传图片
     * @param array $allowExtension 允许后缀名
     * @param array $allowMime 允许类型
     * 一、初始化文件上传配置
     */
    public function __construct($fileName = 'myFile',$maxSize = 2097152,$uploadPath = './uploads',$imgFlag = true,$allowExtension = array('jpeg','jpg','png','gif'),$allowMime=array('image/jpeg','image/png','image/gif'))
    {
        $this->fileName = $fileName;
        $this->maxSize = $maxSize;
        $this->uploadPath = $uploadPath;
        $this->imgFlag = $imgFlag;
        $this->allowExtension = $allowExtension;
        $this->allowMime = $allowMime;
    }

    /**
     * @return array
     * 一、获取多文件的三位数组并转换成二维数组
     * 二、自动过滤单文件情况
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
     * @return bool
     * 一、检测是否出现系统error错误
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
            } else {
                //$this->fileInfo['error']==0时代表程序完全正确
                return true;
            }
        } else {
            $this->msg = '文件上传出错';
        }
    }

    /**
     * @return bool
     * 检测上传文件大小
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

    /**
     * @param string $fileName
     * 一、输出错误代码
     */
    protected function showError($fileName = '')
    {
        echo ("<span style='color: #f0f;'>文件{$fileName}发生了“{$this->msg}”错误</span><br>");
    }

    /**
     * @return string
     * [单文件上传]
     * （一）检测若干错误
     * （二）上传文件/图片
     * （三）返回文件路径或者上传的错误信息
     */
    function uploadFile() {
        $this->fileInfo = $_FILES[$this->fileName];

        if ($this->checkError() && $this->checkExtension() && $this->checkHTTPPost() && $this->checkMime() && $this->checkSize() && $this->checkTrueImage()) {
            $uniqueName = uniqid().'_'.$this->fileInfo['name'];
            $filePath = $this->uploadPath.'/'.$uniqueName;
            if (move_uploaded_file($this->fileInfo['tmp_name'],$filePath)) {
               return $filePath;
            }
        } else {
            $this->showError($this->fileInfo['name']);
        }
    }

    /**
     * @return array
     * [多文件上传]
     *
     */
    function uploadFiles() {
        /**
         * 获取整理好的多组数据
         */
        $files = $this->getFiles();

        /**
         * 保存每次返回的文件名
         */
        $fileName = array();

        /**
         * 1.由于多文件上传，$_FILE数组结构改变，覆盖之前的fileInfo
         * 2.判断是否错误，错误则返回错误信息，若没有错误，则保存每次上传的文件名
         * 3.循环推出，返回文件名数组
         */
        foreach ($files as $key => $fileInfo) {
            $this->fileInfo = $fileInfo;
            if ($this->checkError() && $this->checkExtension() && $this->checkHTTPPost() && $this->checkMime() && $this->checkSize() && $this->checkTrueImage()) {
                //TODO 修改随机文件名，选用更好的方式
                $uniqueName = uniqid() . '_' . $fileInfo['name'];
                $filePath = $this->uploadPath . '/' . $uniqueName;
                if (move_uploaded_file($fileInfo['tmp_name'], $filePath)) {
                    $fileName[$key] = $filePath;
                    echo "文件".$fileName[$key].'上传成功！<br>';
                }
            } else {
                $this->showError($fileInfo['name']);
            }
        }
        return $fileName;
    }
}
/**
 * 请及时修改前端[单/多]文件情况
 */
$file = new Upload();

/**
 * 单文件调用方法，一般即便是单文件，也可以用多文件方法上传，但是能节约一丁点资源
 * $file->uploadFile();
 */
$file->uploadFiles();



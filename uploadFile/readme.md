# 文件上传

> 单文件上传、多文件上传，单图片上传、多图片上传

## 一、[封装类]文件上传类
*upload.php*

### 使用方法
1. 实例化对象
  
  `$uploadFile = new Upload();`

2. 单文件上传调用方法
  
  `$uploadFile->uploadFile();`

3. 多文件上传调用方法
  
  `$uploadFile->uploadFiles();`
  
### 配置方法
1. 简易配置
  
  实例化对象时请带上这些参数
  
```php
  $uploadFile = new (
  //前端input标签name值
  $fileName = 'myFile',
  //文件大小限制
  $maxSize = 2097152,
  //文件保存路径
  $uploadPath = 'uploads',
  //是否上传图片
  $imgFlag = true,
  //上传文件格式要求
  $allowExtension = array('jpeg','jpg','png','gif'),
  //上传文件类型
  $allowMime=array('image/jpeg','image/png','image/gif')
  )
```

## 二、[封装方法]文件上传方法
*upload.class.php*

### 使用方法
  
  单文件上传
  ```php
uploadFile($fileInfo,'uploads');
  ```
  
  多文件上传
```php
$files = getFiles();
foreach ($files as $fileInfo) {
    uploadFile($fileInfo,'uploads');
}
```
  
### 配置方法
1.简易配置
  
  改代码
  
  
## 三、注意事项

1. 如果你有路由
2. 如果你有别的
3. 我没查过








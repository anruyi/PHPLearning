<?php

/**
 * micro php Crawler
 * 以下代码仅供参考
 */
class Crawler
{
    private $content;
    private $data;
    static private $mysql;

    function __construct()
    {
        echo "开始爬取内容...<br>";
        //Nothing to do
    }

    public function loadFile($file_path)
    {
        echo "正在加载文件...<br>";
        $this->content = file_get_contents($file_path);
    }

    public function parseCourseBody()
    {
        $regex = "/\<body\>.*\<\/body\>/";
        preg_match_all($regex, $this->content, $matches);
            $this->content = $matches[0];

        echo "end";
    }

    public function parseContent()
    {
        echo "开始解析内容...<br>";
//        $this->parseCourseBody();
        $this->parseTitle();
        echo "解析内容结束!<br/>";

    }

    public function saveData()
    {
        echo "插入数据库...";
    }

    public function parseTitle()
    {
        echo "解析课程标题...<br>";
        $regex = "/\<h3\>.*\<\/h3\>/";
        preg_match_all($regex, $this->content, $matches);

        var_dump($matches);
        foreach ($matches as $key) {
            $value = str_replace("</div>", "", str_replace("<div class=\"course-name\">", "", $value));
//            $this->data['title'][$key] =
        }
        $this->data['cnames'] = $cnames;
    }

    public function parseDesc()
    {
        echo "解析课程简介...<br>";
    }

    public function parseType()
    {
        echo "解析课程类型...<br>";
    }

    public function titleIsLong()
    {
        echo "判断课程是否超长...<br>";
    }
}

$Crawler = new Crawler();
$Crawler->loadFile('shiyanlou.html');
$Crawler->parseContent();
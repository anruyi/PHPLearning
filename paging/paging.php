<?php
/**
 * User: CY
 * Date: 2017-10-20
 * Time: 22:43
 */

namespace paging;

/**
 * Class Paging
 * @package paging
 * 分页插件制作
 */
class Paging
{
    private $table = 'phptest';

    private $sql = "select * from admin";


    function Paging()
    {

        $pdo = $this->linkSQL();
        $res = $pdo->query($this->sql);

        /**
         * 总数据，即数据总量
         */
        $totalRows = $res->rowCount();

        /**
         * 页面承载容量
         */
        $pageSize = 2;

        /**
         * 浏览的页面
         */
        $page = $_GET['page']?$_GET['page']:1;
        if($page>ceil($totalRows/$pageSize)) $page = ceil($totalRows/$pageSize);
        if($page<1||$page==null||!is_numeric($page)) $page = 1;

        /**
         * 页面总数
         */
        $totalPage = $totalRows/$pageSize;

        /**
         * 偏移量
         * 简单的来说，就是每翻一页需要读取多少条数据
         * ps:最开始0，能理解？就是没有任何偏移量的意思
         */
        $offset = ($page-1)*$pageSize;


        $this->showPage($page,$totalPage);

        /**
         * 显示数据
         */
        $sql1 = "SELECT * FROM admin LIMIT {$offset},{$pageSize}";
        $res = $pdo->query($sql1);
        foreach($res as $key=>$row){
            echo "====================第{$key}条数据================="."<br>";
            print_r($row);
            echo "<br>";
        }

    }

    public function showPage($page,$totalPage,$where=null)
    {
        /**
         * 获取本页面的连接
         */
        $url = $_SERVER['PHP_SELF'];

        /**
         * 筛选条件
         */
        $where==null?null:"&".$where;

        /**
         * 首页面
         * 尾页面

         * 上一页
         * 下一页
         */
        $home = ($page==1)?'[Home]':"<a href='{$url}?page=1{$url}'>".'[Home]'."</a>";
        $last = ($page==$totalPage)?"[LAST]":"<a href='{$url}?page={$totalPage}'>[LAST]</a>";

        $prev = $page==1?"[上一页]":"<a href={$url}?page=".($page-1).".{$url}>[上一页]</a>";
        $next = $page==$totalPage?"[下一页]":"<a href={$url}?page=".($page+1).">[下一页]</a>";;

        /**
         * 本次需要的前十个页码
         */
        $p = null;

        /**
         * 所有页码保存
         */
        $allPage = array();

        /**
         * 保存所有page页面
         */
        for ($i=1;$i<=$totalPage;$i++) {
            if($page==$i)
                $allPage[$i] = "[{$i}]";
            else
                $allPage[$i] = "<a href='{$url}?page={$i}'>[{$i}]</a>";
        }

        /**
         * 想办法截取最需要的十个
         */
        for ($i=1;$i<=$totalPage;$i++) {
            if($page==$i)
                $p .= "[{$i}]";
            else
                $p .= "<a href='{$url}?page={$i}'>[{$i}]</a>";
        }

        /**
         * 显示输出所有页码
         */
        echo "<br>".$home.$prev;
        for ($i=1;$i<=$totalPage;$i++) {
            echo $allPage[$i];
        }
        echo "<br>".$next.$last."<br>";

        /**
         * 截取部分页码
         */
        $pageStr = "<br>".$home.$prev;
        echo "<br>".$home.$prev;
        for ($i=1;$i<=$totalPage;$i++) {
            if($page-$i<4&&$page-$i>=0 || $i-$page<4&&$page-$i<0){
                echo $allPage[$i];
                $pageStr .= $allPage[$i];
            }
        }
        echo $next.$last."<br>";

        $pageStr .= $next.$last."<br>";
        echo $pageStr;
        return $pageStr;
    }

    public function linkSQL()
    {
        $pdo = new \PDO("mysql:host=localhost;dbname=phptest","phptest","123456");
        $pdo->query("set character set 'gbk'");
        if($pdo){
            $ret = $pdo->query($this->sql);
//            foreach($ret as $row){
//                print_r($row);
//                echo "<br>";
//            }

        } else {
            echo 'no';
        }

        return $pdo;
    }
}

$pag = new Paging();
$pag->Paging();
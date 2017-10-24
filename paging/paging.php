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
    /**
     * @var string
     * 简单的数据库连接，写你自己的喽
     */
    private $dbname = 'phptest';

    private $username = 'phptest';

    private $dbpsw = '123456';

    private $sql = "select * from admin";

    /**
     * 演示使用showPage方法：
     * 准备部分：
     *      ①连接数据库，②设置基本参数
     * 第一部分：
     *      显示数据
     * 第二部分：
     *      显示分页页码
     */
    function Paging()
    {
        /**
         * 1. ①连接数据库，②并设置必要的参数
         */
        $pdo = new \PDO("mysql:host=localhost;dbname={$this->dbname}",$this->username,$this->dbpsw);
        $pdo->query("set character set 'gbk'");
        if(!$pdo){echo "数据库失败";}
        $res = $pdo->query($this->sql);

        /**总数据条数*/
        $totalRows = $res->rowCount();

        /**页面承载容量*/
        $pageSize = 2;

        /**用户正在浏览的页面，get方法获取，并且做简单的判断*/
        $page = $_GET['page']?$_GET['page']:1;
        if($page>ceil($totalRows/$pageSize)) $page = ceil($totalRows/$pageSize);
        if($page<1||$page==null||!is_numeric($page)) $page = 1;

        /**页面数量*偏移量[用户一共阅览到第多少条记录]*/
        $totalPage = $totalRows/$pageSize;
        $offset = ($page-1)*$pageSize;

        /**
         * 2. 显示数据
         */
        $sql1 = "SELECT * FROM admin LIMIT {$offset},{$pageSize}";
        $res = $pdo->query($sql1);
        foreach($res as $key=>$row){
            echo "====================第{$row['adminID']}条数据================="."<br>";
            print_r($row);
            echo "<br><br>";
        }

        /**
         * 3. 显示分页页码
         */
        echo $this->showPage($page,$totalPage);

    }

    /**
     * @param $page 当前页面
     * @param $totalPage 总页面数目
     * @param null $where 查询条件
     * @return string 返回正确的页码标签
     * 显示正确的页码标签
     * 【页面分页·基本步骤】
     * 一、获取基本数据
     *      （一）当前页面url
     *      （二）查询条件where
     *      （三）页面描述
     *      （四）保存所有页码allPage
     *      （五）当前所需要显示的九个页码pageStr
     * 二、计算出所有分页
     * 三、整理出当前应显示的部分页码
     * 四、正确的返回所需要的页码字符串
     */
    public function showPage($page,$totalPage,$where=null,$sep='')
    {
        /**
         * 一、获取基本数据
         */
        $url = $_SERVER['PHP_SELF'];
        $where==null?null:"&".$where;

        /** 首页面* 尾页面* 上一页* 下一页**/
        $home = ($page==1)?'[首页]':"<a href='{$url}?page=1{$url}'>".'[首页]'."</a>";
        $last = ($page==$totalPage)?"[尾页]":"<a href='{$url}?page={$totalPage}'>[尾页]</a>";
        $prev = $page==1?"[上一页]":"<a href={$url}?page=".($page-1).".{$url}>[上一页]</a>";
        $next = $page==$totalPage?"[下一页]":"<a href={$url}?page=".($page+1).">[下一页]</a>";;

        $allPage = array();
        $pageStr = null;

        /**
         * 二、保存所有page页面
         * echo "<br>".$home.$prev;
         * for ($i=1;$i<=$totalPage;$i++) {
         * echo $allPage[$i];   }
         * echo "<br>".$next.$last."<br>";
         */
        for ($i=1;$i<=$totalPage;$i++) {
            if($page==$i)
                $allPage[$i] = "[{$i}]";
            else
                $allPage[$i] = "<a href='{$url}?page={$i}'>[{$i}]</a>";
        }

        /**
         * 三、截取部分页码保存
         */
        $pageStr = "<br>".$home.$prev;
        for ($i=1;$i<=$totalPage;$i++) {
            if($page-$i<4&&$page-$i>=0 || $i-$page<4&&$page-$i<0){
                $pageStr .= $allPage[$i];
            }
        }
        $pageStr .= $next.$last."<br>";

        /**
         * 四、正确的返回所需要的页码字符串
         */
        return $pageStr;
    }
}

/**
 * 实例化
 */
$pag = new Paging();
$pag->Paging();

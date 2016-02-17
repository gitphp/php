<?php
namespace Home\Controller;
use Think\Controller;
/*
 * 生活文件列表控制器
*/
class LifeController extends HomeController {
	/**
     * 文章分类2，显示日志分类列表信息
     */
    public function index(){
        // 分配title,keywords,description,js,css
        $this->assign(array(
            'title'=>'PHP源码下载—一个刚入门web后端开发的码农程序员的个人网站',
            'keywords'=>'html5模板,html5 css3 模板,个人博客模板,博客模板,网站后台模板,PHP源码,PHP动态网站,PHP网站欣赏',
            'description'=>'杨松个人PHP技术博客网站，提供PHP博客技术分享，html5模板,博客模板，商城网站模板，PHP源码，PHP企业网站，PHP博客网站下载',
            'css'=>array('base.css','style.css','lrtk.css'),
            'js'=>array('jquery-1.9.1.min.js','js.js'),
        ));
        // 1、取出当前分类的子分类列表（IT生活）
        $cat = new \Model\CategoryModel();
        $arc = new \Model\ArticleModel();
        $id=2;  // 2=是IT生活栏目
        $this->cats=$cat->getChildById($id);    // 取出当前大类的子类
        //2、取出大类的所有文章
        $ids = array();
        foreach ($this->cats as $v) {
            $ids[] = $v['id'];
        }
        $ids = implode(',' , $ids);

            // 2、取出所有的说说数据、分页(20)条
            $p=$_GET['p']?$_GET['p']:1;
            // $list = $dao->page($p.',10')->order('id desc')->select();
            $list = $arc->page($p.',20')->where('type_id in (' .$ids .')')->select();
            $this->assign('data',$list);
            $count      = $arc->where('type_id in (' .$ids .')')->count();
            $Page       = new \Think\Page($count,10);
            // $Page->setConfig('prev','上一页');
            // $Page->setConfig('next','下一页');
            $Page->setConfig('header','总'.$count.'共');

            $show       = $Page->show();// 分页显示输出
            $this->assign('page',$show);// 赋值分页输出 

        // 3、取出右侧文章列表
            $arc = new \Model\ArticleModel();
            $this->new_arcs = $arc->field('id,title')->order('id desc')->limit(8)->select();             // 最新文章8篇
            $this->click_arcs = $arc->field('id,title')->order('arc_click desc')->limit(5)->select();    //点击榜5篇

        $this->display();
    }


    /**
     * 相册方法也在这里显示
     */
    public function xc(){
        // 分配title,keywords,description,js,css
        $this->assign(array(
            'title'=>'程序员的生活—不仅仅是一个码农',
            'keywords'=>'html5模板,html5 css3 模板,个人博客模板,博客模板,网站后台模板,PHP源码,PHP动态网站,PHP网站欣赏',
            'description'=>'杨松个人博客网站作品展示，均是真实案例。都是个人设计，从最初的菜鸟到手到擒来，总结一句话：付出才会有回报！',
            'css'=>array('base.css','case.css'),
            'js'=>array('jquery-1.9.1.min.js','js.js'),
        ));

        // 3、取出右侧文章列表
            $start = mt_rand(0,20);
            $arc = new \Model\ArticleModel();
            $this->new_arcs = $arc->field('id,title')->order('id desc')->limit($start, 8)->select();             // 最新文章8篇
            $this->click_arcs = $arc->field('id,title')->order('arc_click desc')->limit($start, 9)->select();    //点击榜5篇

        // 取出当前分类的子分类列表（IT生活）
        $cat=new \Model\CategoryModel();
        $id=4;  // 4=是模板下载栏目
        $this->cats=$cat->getChildById($id);
        // 取出所有图 -- 分页
                // 2、取出所有的说说数据、分页(20)条
                $p=$_GET['p']?$_GET['p']:1;

                $list = D('Photo')->page($p.',12')->order('id desc')->select();
                $this->assign('imgs',$list);
                $count      = D('Photo')->count();
                $Page       = new \Think\Page($count,10);
                // $Page->setConfig('prev','上一页');
                // $Page->setConfig('next','下一页');
                $Page->setConfig('header','总'.$count.'共');

                $show       = $Page->show();// 分页显示输出
                $this->assign('page',$show);// 赋值分页输出 


        // $this->imgs=D('Photo')->select();
        $this->display();
    }

    public function info(){
        phpinfo();
    }


} // end
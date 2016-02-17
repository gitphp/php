<?php
namespace Home\Controller;
use Think\Controller;

/*
 * FlieName:ArticleController.class.php
 * Auth:Young\
 * Location:Yang/Home/Controller/
 * AddTime:2015年11月21日10:20:11
 * Deacription:前台文章控制器
 */
class ArticleController extends HomeController {
	/*
	 * 文章分类显示方法(通用)
	*/
    public function index(){
    	// 分配title,keywords,description,js,css
    	$this->assign(array(
    		'title'=>'PHP源码下载—一个刚入门web后端开发的码农程序员的个人网站',
    		'keywords'=>'html5模板,html5 css3 模板,个人博客模板,博客模板,网站后台模板,PHP源码,PHP动态网站,PHP网站欣赏',
    		'description'=>'杨松个人PHP技术博客网站，提供PHP博客技术分享，html5模板,博客模板，商城网站模板，PHP源码，PHP企业网站，PHP博客网站下载',
    		'css'=>array('base.css','share.css','lrtk.css'),
			'js'=>array('jquery-1.9.1.min.js','js.js'),
    	));
        // 取出当前大类的文章列表，分页
        // 1、取出当前分类的子分类列表（IT生活）
        $cat = new \Model\CategoryModel();
        $arc = new \Model\ArticleModel();
        $id = I('get.id');  // 根据分类id查找子分类文章列表
        if (!$id){
            $id = 0;
        }
        $this->cats=$cat->getChildById($id);    // 取出当前大类的子类
        //2、取出大类的所有文章
        $ids = array();
        foreach ($this->cats as $v) {
            $ids[] = $v['id'];
        }
        $ids = implode(',' , $ids);
        // 若当前分类下没文章
        if(!$ids){
            $ids = $id; 
        }
            // 2、取出所有的说说数据、分页(20)条
            $p=$_GET['p']?$_GET['p']:1;
            // $list = $dao->page($p.',10')->order('id desc')->select();
            $list = $arc->page($p.',20')->where('type_id in (' .$ids .')')->order('id desc')->select();
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
     * 文章详情页面
     * @return [type] [description]
     */
    public function detail() {
        
        $arc = new \Model\ArticleModel();
        $id = I('get.id');
        $this->detail = $arc->get_detail($id);       // 分配详情
        $this->new_arcs = $arc->field('id,title')->order('id desc')->limit(8)->select();             // 最新文章8篇
        $this->click_arcs = $arc->field('id,title')->order('arc_click desc')->limit(5)->select();    //点击榜5篇
        // 相关文章应该是同类目下面的6篇，这里我就不麻烦了，随便取6篇吧
        $this->xiangguan_arcs = $arc->field('id,title')->where('id >' . $id)->limit(6)->select();    //相关文章6篇

        // 2、取出子分类
        $cat = new \Model\CategoryModel();
        $this->cats=$cat->getChildById($this->detail['type_id']);    // 取出当前大类的子类

        // 动态的 分配title,keywords,description,js,css
        $this->assign(array(
            'title'=>$this->detail['title'],
            'keywords'=>$this->detail['keywords'],
            'description'=>$this->detail['remark'],
            'css'=>array('base.css', 'new.css', 'lrtk.css'),
            'js'=>array('jquery-1.9.1.min.js', 'js.js'),
        ));


        $this->display();
    }
    
} // end

<?php
namespace Home\Controller;
use Think\Controller;

/*
 * FlieName:IndexController.class.php
 * Auth:Young\
 * Location:Yang/Home/Controller/
 * AddTime:2015年11月21日10:10:31
 * Deacription:前台首页控制器
 */
class IndexController extends HomeController {
	/*
	 * 首页显示方法
	*/
    public function index(){
    	// 分配title,keywords,description
    	$this->assign(array(
    		'title'=>'杨松个人PHP技术博客 - 一个刚入门web后端开发的码农程序员的个人网站',
    		'keywords'=>'个人博客,杨松PHP博客,程序员技术博客,静态模板,PHP个人网站',
    		'description'=>'杨松个人PHP博客，是一个刚入门web后端开发的程序员个人技术博客，提供个人技术分享，免费PHP教程分享的个人原创网站。',
    		'css'=>array('base.css','index.css')
    	));

        $this-> msg = $this->get_san();                             // 分配msg变量
        $this-> new_arcs = $this->get_new_articles();              // 最新文章
        $this-> click_arcs = $this->get_clicks();                  // 点击排行榜文章
        $this-> links = $this->get_links();                         // 友情链接4条
        $this-> top_arcs = $this->get_my_template();                // 友情链接4条
        $categorys = $this->get_category();                  // 所有文章分类

        // $this-> arc_list = $this->get_articles();   // 文章推荐
        $wens = $this->get_articles();      // 所有文章推荐
        foreach ($wens as $k=>$v) {
            foreach ($categorys as $vv){
                if ($v['type_id'] == $vv['id']) {
                    $wens[$k]['catname'] = $vv['catname'];
                    $wens[$k]['cat_id'] = $vv['id'];
                }
            }
        }
        $this-> arc_list = $wens;   // 传递文章列表

		$this->display();
    }

    /**
     * 取出友情链接
     */
    private function get_links(){
        $link = new \Model\LinkModel();
        return $link->field('link_name,link_url')->limit(4)->select();
    }

    /**
     * 首页banner三句话获取
     */
    private function get_san() {

        $cat = new \Model\TouModel();
        return $cat->order('id desc')->limit(1)->select();
    }

    /**
     * 文章推荐
     * @return array
     */
    private function get_articles() {
        $cat = new \Model\ArticleModel();
        return $cat->field('id,title,type_id,keywords,remark,addtime,author,arc_pic')->limit(7)->order('id desc')->select();
    }

    /**
     * 最新文章
     * @return array
     */
    private function get_new_articles() {
        $arc = new \Model\ArticleModel();
        return $arc->field('id,title')->order('id desc')->limit(12)->select();        // 最新文章8篇
    }

    /**
     * 点击排行榜
     * @return [array] [description]
     */
    private function get_clicks() {
        $arc = new \Model\ArticleModel();
        return $arc->field('id,title')->order('arc_click desc')->limit(9)->select();    //点击榜5篇

    }

    /**
     * 个人博客模板
     * @return array
     */
    private function get_my_template() {
        $arc = new \Model\ArticleModel();
        return $arc->field('id,arc_pic,title')->order('id desc')->limit(5)->select();

    }

    /**
     * 根据文章id取出文章所属分类的名字
     */
    private function get_category(){
        // 取出文章的父id
        // $type_id = D('Article')->where('id = ' .$id)->getField('type_id');

        return  D('Category')->field('id,catname')->select();
    }





}
<?php
/**
 * Created by PhpStorm.
 * User: kingblanc
 * Date: 2018/8/29
 * Time: 15:34
 */
namespace app\index\controller;
use think\Controller;

class  News extends Controller{
    /**
     * 新闻列表页（注意分页和新闻的置顶）
     * @author
     */
	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','5');
}
    public function index(){
        $news = db('news') ->where(array('status'=>1))-> order('id desc')  -> paginate(10);
        $page=$news->render();
        $this->assign('news',$news);
        $this->assign('page',$page);

        return  $this -> view -> fetch();
    }

    /**
     * 新闻列表页（注意分页和新闻的置顶）
     * @author
     */
    public   function  detail(){
        $id =$this->request->param('id');
        $news = db('news') -> where(array('id' => $id)) -> find();
        $this->assign('news',$news);
        return $this -> view -> fetch();
    }
}
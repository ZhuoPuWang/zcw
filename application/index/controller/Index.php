<?php
namespace app\index\controller;

use  think\Controller;

class Index extends  Controller
{
	public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','1');
}
    public function index(){
        //获取session
		//dump($_SESSION);
        if(!isset($_SESSION['sh'])){
            $sh = db('configure')->where('id','0')->field('name,phone')->find();
            $_SESSION['sh'] = $sh;
        }
        if(!isset($_SESSION['think']['role'])){
            $_SESSION['think']['role'] = '0';
        }

        //首恶banner
        $home = db('home') -> where(array('id' => 1)) -> find();
        $this -> view -> assign('home',$home);
        $homes = db('home') -> where('id','>', '1') -> select();
        $this -> view -> assign('homes',$homes);

        //最新课程
        $course = db('course')->order('id desc')  -> limit(10) -> select();
        $this -> view -> assign('course',$course);

        //最新新闻
        $news = db('news')->order('isfrist desc')  -> limit(10) -> select();
        $this -> view -> assign('news',$news);
        return $this -> view -> fetch();
    }
}

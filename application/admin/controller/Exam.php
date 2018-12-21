<?php
namespace  app\admin\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class  Exam  extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 管理后台考试管理
     * @author
     */
	  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    public function index(){
        

        return $this -> view -> fetch();
    }

    /**
     * 添加考试管理
     * @author
     */
    public function add(){

    }

	/**
     * 修改考试管理
     * @author
     */
    public function edit(){

    }
    
}
?>
<?php
namespace  app\admin\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class  Userattribute  extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 管理后台用户属性管理
     * @author
     */
	  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    public function index(){
        

        return $this -> view -> fetch();
    }

    
    
}
?>
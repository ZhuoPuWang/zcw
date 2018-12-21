<?php
namespace  app\admin\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class  Userimport  extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 管理后台用户导入
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
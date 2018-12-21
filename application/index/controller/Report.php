<?php
namespace  app\index\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class Report extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 报表
     * @author
     */
    public function index(){
        
        return $this -> view -> fetch();
    }






    
}
?>
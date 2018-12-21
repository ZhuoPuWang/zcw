<?php
namespace  app\admin\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class  Departimport  extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 管理后台组织结构导入
     * @author
     */
    public function index(){
        

        return $this -> view -> fetch();
    }

    
    
}
?>
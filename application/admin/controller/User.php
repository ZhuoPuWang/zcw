<?php
namespace  app\admin\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class  User  extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 管理后台用户管理
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
     * 添加用户管理
     * @author
     */
    public function add(){

    }


    public function  logout(){
        //添加日志
        $info['userid'] = Session::get('userid');
        $info['type'] = '退出';
        $info['time'] = time();
        db('logs') -> data($info) -> insert();
        session(null);
        $this->success("退出成功");
    }


}
?>
<?php
namespace  app\admin\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class Logs  extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 管理后台日志管理
     * @author
     */
	  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    public function index(){
        $listRows = $this -> request -> param('numPerPage') ?: Config::get("paginate.list_rows");
        $list = db('logs') -> alias('l') -> join('user u','l.userid = u.id')
            -> field(array('l.id','l.cont','u.username','u.realname','l.time','l.type','u.email')) -> order('l.id desc')
            -> paginate($listRows, false, ['query' => $this-> request -> get()]);
        $this-> view -> assign('list', $list);
        $this-> view -> assign("page", $list -> render());
        $this-> view -> assign('numPerPage', $list -> listRows());
        return $this -> view -> fetch();


    }

    
    
}
?>
<?php
namespace  app\index\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class Database extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 资料库管理
     * @author
     */
	 public function __construct(){
        parent::__construct();
        $this -> view -> assign('base','3');
         if(!isset($_SESSION['think']['userid'])){
             $this->redirect('index/user/login');
         }
     }
    public function index(){
        $listRows = $this -> request -> param('numPerPage') ?: Config::get("paginate.list_rows");
        $list = db('database')  -> paginate($listRows, false, ['query' => $this-> request -> get()]);
        $this-> view -> assign('list', $list);
        $this-> view -> assign("page", $list -> render());
        $this-> view -> assign('numPerPage', $list -> listRows());
        return $this -> view -> fetch();
    }






    
}
?>
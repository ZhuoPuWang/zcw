<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/8/29
 * Time: 15:40
 */
namespace app\admin\controller;
use think\Controller;
use  think\Session;
use think\Config;

class Fl extends Controller{
    use \app\admin\controller\Base;
    /**
     * @yang
     * 列表页，列出所有讲师
     * @author
     */
	  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    public function index(){
        $list = db('fl') -> alias('d') -> join('fl b','b.id =  d.fid','LEFT') -> field(array('d.id','d.name','d.type','b.name as fname'))
            -> paginate(10, false, ['query' => $this->request->get()]);

        $this-> view -> assign('list', $list);
        $this-> view -> assign("page", $list -> render());
        $this-> view -> assign('numPerPage', $list -> listRows());
        return $this -> view -> fetch();
    }

    public function add(){
        if($this -> request -> isAjax()){
            //判断是一级就不能有二级
             if($this->request->post('type') == 1 && $this->request->post('fid') != 0){
                 return json(['state' => 2]);
             }
             if($this->request->post('name') == ''){
                 return json(['state' => 2]);
             }
            $data = $this->request->post();
            db('fl') -> data($data) -> insert();
            return json(['state' => 1]);
        }else{
            $father = db('fl')->where(array('type'=>'1'))->select();
            $this->assign('fa',$father);
            return $this -> view -> fetch();
        }
    }

    public function delete(){
        $id = $this -> request -> param('id');
        $table = request() -> controller();

        $son = db($table)->where(array('fid' => $id))->find();
        if($son){
            return json(array('state' => 2));
        }
        db($table) -> where(array('id' => $id))  -> delete();
        return json(array('state' => 1));
    }

    public function edit(){
        if($this -> request -> isAjax()){
            $id = $this -> request -> post('id');
            //判断是一级就不能有二级
            if($this->request->post('type') == 1 && $this->request->post('fid') != 0){
                return json(['state' => 2]);
            }
            if($this->request->post('name') == ''){
                return json(['state' => 2]);
            }
            $data = $this->request->post();
            db('fl') -> data($data)->where(array('id',$id)) -> update();
            return json(['state' => 1]);
        }else{
            $id = $this -> request -> param('id');

            $list = db('fl')->where(array('id'=>$id))->find();
            $father = db('fl')->where(array('type'=>'1'))->select();
            $this->assign('fa',$father);
            $this -> view -> assign('list',$list);
            return $this -> view ->  fetch();
        }
    }

}
<?php
namespace  app\admin\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class  Catalog  extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 管理后台目录
     * @author
     */
	  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    public function index(){
        $map = array();
        if($this -> request -> param('name')){
            $map['d.name'] = ['like','%'.$this -> request -> param('name').'%'];
        }

        if($this -> request -> param('no')){
            $map['d.no'] = ['like','%'.$this -> request -> param('no').'%'];
        }

        $listRows = $this->request->param('numPerPage') ?: Config::get("paginate.list_rows");
        $list = db('catalog') -> alias('d') -> join('zcw_catalog b','b.id =  d.pid','LEFT') -> field(array('d.id','d.name','d.no','d.status',
            'b.name as p_name','b.no as p_no')) -> where($map) -> order('d.id desc')
            -> paginate($listRows, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        //$this->view->assign("count", $list->total());
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this -> view -> fetch();
    }

    /**
     * 增加新的部门
     * @author 金志刚
     */
    public function add(){
        if($this -> request -> isAjax()){
            db('catalog') -> data($this -> request -> except('pname')) -> insert();
            return json(['state' => 1]);
        }else{
            return $this -> view -> fetch();
        }
    }

    /**
     * 修改部门信息
     * @author 金志刚
     */
    public function edit(){
        if($this -> request -> isAjax()){
            $id = $this -> request -> param('id');
            db('catalog') -> where(array('id' => $id)) -> data($this -> request -> except(array('id','pname'))) -> update();
            return  json(array('state' => 1));
        }else{
            $id = $this -> request -> param('id');
            $info = db('catalog') -> alias('d') -> join('zcw_catalog b','b.id = d.pid','LEFT') ->
            field(array('d.id','d.name','d.no','d.pid','b.name as pname')) -> where(array('d.id' => $id )) -> find();
            $this -> view -> assign('vo',$info);
            $this -> view -> assign('id',$id);
            return $this -> view ->  fetch();
        }
    }


    public function chooseParentDepart(){
        $map = array();
        if($this -> request -> param('name')){
            $map['d.name'] = ['like','%'.$this -> request -> param('name').'%'];
        }

        if($this -> request -> param('no')){
            $map['d.no'] = ['like','%'.$this -> request -> param('no').'%'];
        }

        if($this -> request -> param('id')){
            $map['d.id'] = ['neq',$this -> request -> param('id')];
        }


        $listRows = $this->request->param('numPerPage') ?: Config::get("paginate.list_rows");
        $list = db('catalog') -> alias('d') -> join('zcw_catalog b','b.id =  d.pid','LEFT') -> field(array('d.id','d.name','d.no',
            'b.name as p_name','b.no as p_no')) -> where($map) -> order('d.id desc')
            -> paginate($listRows, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        //$this->view->assign("count", $list->total());
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        $this -> view -> assign('haveLeft',false);
        $this -> view -> assign('haveHead',false);
        return $this -> view -> fetch();
    }
}
?>
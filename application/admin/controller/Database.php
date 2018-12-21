<?php
namespace  app\admin\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class Database extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 管理后台资料库管理
     * @author
     */
	  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    public function index(){

        $database = db('database')->order('id desc') -> select();
        $this-> view -> assign("database", $database);
        return $this -> view -> fetch();
    }

    /**
     * 添加资料库
     * @author
     */
    public function add(){
        if($this -> request -> isAjax()){
            //获取表单上传文件
            $file = request()->file('files');
            $data['file_name'] = $_FILES['files']['name'];
            $data['title'] = $this -> request->post('title');
            $data['pid'] = $this -> request->post('pid');
            $data['mid'] = $this -> request->post('mid');
            $data['time'] = time();


            if (empty($file)) {
                $data['file_url'] = $this -> request->post('files');
                db('database') -> data($data) -> insert();
                exit;
            }
            //移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
            $data['file_url'] = date('Ymd') . '/' . $info->getFilename();


            db('database') -> data($data) -> insert();

            if ($info) {
                $this->success('文件上传成功');
                echo $info->getFilename();
            } else {
                //上传失败获取错误信息
                $this->error($file->getError());
            }
        }else{
            return $this -> view -> fetch();
        }

    }

	/**
     * 修改资料库
     * @author
     */
    public function edit(){
        if($this -> request -> isAjax()){
            //获取表单上传文件
            $id = $this->request->param('id');
            $file = request()->file('files');
            $data['title'] = $this -> request->post('title');
            $data['pid'] = $this -> request->post('pid');
            $data['mid'] = $this -> request->post('mid');
            $data['time'] = time();

            if (empty($file)) {
                $data['file_url'] = $this -> request->post('files');
                db('database') -> data($data) -> where('id',$id) ->update();
                exit;
            }
            //移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
            $data['file_name'] = $info->getFilename();
            $data['file_url'] = date('Ymd') . '/' . $info->getFilename();

          $da = db('database')->where(array('id'=>$id))->update($data);


            if ($info) {
                $this->success('文件上传成功');
                echo $info->getFilename();
            } else {
                //上传失败获取错误信息
                $this->error($file->getError());
            }
        }else{
            $id = $this->request->param('id');

           $list = db('database')
               ->alias('a')
               ->join('depart b','a.pid = b.id','left')
               ->join('depart c','a.mid = c.id','left')
               ->field('a.id,a.title,a.file_name,a.file_url,a.pid,a.mid,a.time,b.name as pname,c.name as mname')
               ->where('a.id',$id)
               ->find();
            $this -> view -> assign('list',$list);
            $this -> view -> assign('id',$id);
            return $this -> view -> fetch();
        }
    }

    //选择目录
    public function chooseParentCatalog(){
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

//对象
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
        $list = db('depart') -> alias('d') -> join('zcw_depart b','b.id =  d.pid','LEFT') -> field(array('d.id','d.name','d.no',
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


    public function  delete(){
        $id = $this -> request->param('id');
        db('database')->where(array('id'=>$id))->delete();

    }
    
}
?>
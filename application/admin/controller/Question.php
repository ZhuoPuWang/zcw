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

class Question extends Controller{
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

        if($this->request->post('name')){
            $map['name']  =array('like','%'.$this->request->post('name'));
        }else{
            $map ='';
        }
        $list = db('question')->field('id,name,question,count,createtime')
            ->where($map)
            ->order('id desc')
            -> paginate(10, false, ['query' => $this-> request -> get()]);
        $this-> view -> assign('list', $list);
        $this-> view -> assign("page", $list -> render());
        $this-> view -> assign('numPerPage', $list -> listRows());
        return $this -> view -> fetch();

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


        $listRows = $this -> request -> param('numPerPage') ?: Config::get("paginate.list_rows");
        $list = db('depart') -> alias('d') -> join('zcw_depart b','b.id =  d.pid','LEFT') -> field(array('d.id','d.name','d.no',
            'b.name as p_name','b.no as p_no')) -> where($map) -> order('d.id desc')
            -> paginate($listRows, false, ['query' => $this->request->get()]);
        $this-> view -> assign('list', $list);
        //$this-> view -> assign("count", $list->total());
        $this-> view -> assign("page", $list->render());
        $this-> view ->assign('numPerPage', $list->listRows());
        $this -> view -> assign('haveLeft',false);
        $this -> view -> assign('haveHead',false);
        return $this -> view -> fetch();
    }

    public function add(){
        $table = strtolower($this -> request -> controller());
        if($this -> request -> isAjax()){
            $data['name'] =$this->request->post('name');
            $data['userobject'] =$this->request->post('userobject');
            $data['createtime'] =time();
            db('question')->data($data)->insert();
            return  json(array('state' => 1));
        }else{
            return $this -> view ->  fetch();
        }
    }

    public function edit(){
        $table = strtolower($this -> request -> controller());
        if($this -> request -> isAjax()){
            $id =  $this -> request -> post('id');
            $data['name'] = $this -> request -> post('name');
            $data['userobject'] = $this -> request -> post('userobject');
            db('question') ->data($data) -> where(array('id' => $id)) -> update();
            return  json(array('state' => 1));
        }else{
            $id = $this -> request -> param('id');
            $info = db($table) -> where(array('id' => $id)) -> find();
            $this -> view -> assign('list',$info);
            $this -> view -> assign('questionid',$id);
            return $this -> view ->  fetch();
        }
    }

    public function ti(){
        //题库Id
        $questionid = $this -> request -> param('id');
        $list = db('ti')->field('id,name,tname,type')->where(array('questionid'=>$questionid))-> paginate(10, false, ['query' => $this-> request -> get()]);
        $this-> view -> assign('list', $list);
        $this->view->assign('questionid',$questionid);
        $this-> view -> assign("page", $list -> render());
        $this-> view -> assign('numPerPage', $list -> listRows());
        return $this -> view -> fetch();
    }

    public function addti(){
        if($this -> request -> isAjax()){
            $data['type'] =$this->request->post('type');
            $data['content'] = $this->request->post('content');
            $data['questionid'] = $this->request->post('questionid');
            $data['name'] = $this->request->post('name');
            if($data['type'] == '1'){
                $data['answer'] =$this->request->post('dx');
                $data['question'] = json_encode(array('data1'=>$this->request->post('dxanswer1'),'data2'=>$this->request->post('dxanswer2'),'data3'=>$this->request->post('dxanswer3'),'data4'=>$this->request->post('dxanswer4')));
            }elseif($data['type'] == '2'){
                $data['answer'] = json_encode(array('data1'=>$this->request->post('duox1'),'data2'=>$this->request->post('duox2'),'data3'=>$this->request->post('duox3'),'data4'=>$this->request->post('duox4')));
                $data['question'] = json_encode(array('data1'=>$this->request->post('duoxanswer1'),'data2'=>$this->request->post('duoxanswer2'),'data3'=>$this->request->post('duoxanswer3'),'data4'=>$this->request->post('duoxanswer4')));
            }elseif($data['type'] == '3'){
                $data['answer'] = $this->request->post('sft');
                $data['question'] = '';
            }elseif($data['type'] == '4'){

            }elseif($data['type'] == '5'){
                $data['answer'] = $this->request->post('tk');
                $data['question'] = '';
            }
            db('ti')->data($data)->insert();
            return  json(array('state' => 1));
        }else{
            $ran=rand('10000','99999');
            $name = md5($ran);
            $questionid = $this -> request -> param('questionid');
            $this->view->assign('questionid',$questionid);
            $this->view->assign('name',$name);
            return $this -> view ->  fetch();
        }
    }
    public function editti(){
        if($this -> request -> isAjax()){
            $id =$this->request->post('id');
            $data['type'] =$this->request->post('type');
            $data['content'] = $this->request->post('content');
            $data['name'] = $this->request->post('name');
            if($data['type'] == '1'){
                $data['answer'] =$this->request->post('dx');
                $data['question'] = json_encode(array('data1'=>$this->request->post('dxanswer1'),'data2'=>$this->request->post('dxanswer2'),'data3'=>$this->request->post('dxanswer3'),'data4'=>$this->request->post('dxanswer4')));
            }elseif($data['type'] == '2'){
                $data['answer'] = json_encode(array('data1'=>$this->request->post('duox1'),'data2'=>$this->request->post('duox2'),'data3'=>$this->request->post('duox3'),'data4'=>$this->request->post('duox4')));
                $data['question'] = json_encode(array('data1'=>$this->request->post('duoxanswer1'),'data2'=>$this->request->post('duoxanswer2'),'data3'=>$this->request->post('duoxanswer3'),'data4'=>$this->request->post('duoxanswer4')));
            }elseif($data['type'] == '3'){
                $data['answer'] = $this->request->post('sft');
                $data['question'] = '';
            }elseif($data['type'] == '4'){

            }elseif($data['type'] == '5'){
                $data['answer'] = $this->request->post('tk');
                $data['question'] = '';
            }
            db('ti')->data($data)->where(array('id'=>$id))->update();
            return  json(array('state' => 1));
        }else{
            $id = $this -> request -> param('id');
            $info = db('ti') -> where(array('id' => $id)) -> find();
            if($info['type'] == '1'){
                $info['question'] = json_decode($info['question']);
            }elseif($info['type'] == '2'){
                $info['answer'] = json_decode($info['answer']);
                $info['question'] = json_decode($info['question']);
            }
            $this -> view -> assign('list',$info);
            return $this -> view ->  fetch();
        }
    }

    public function yulan(){
        $questionid = $this->request->param('id');
        $list = db('ti')->where(array('questionid'=>$questionid))->select();
        foreach ($list as $k=>$v){
            $data[$k] = $v;
            if($v['type'] == '1'){
                $data[$k]['question'] = json_decode($v['question']);
            }elseif($v['type'] == '2'){
                $data[$k]['answer'] = json_decode($v['answer']);
                $data[$k]['question'] = json_decode($v['question']);
            }
        }
        $this -> view -> assign('questionid',$questionid);
        $this -> view -> assign('list',$data);
        return $this -> view ->  fetch();
    }


    public function fenpei(){
        $id = $this->request->param('id');
        $cour_id = db('question')->where(array('id'=>$id))->field('ex_id')->find();
        $question = array();
        if($cour_id){
            $course = db('examination')->where(array('id'=>$cour_id['ex_id']))->find();
        }
        $this->view->assign('ids', $id);
        $this->view->assign('course', $course);
        $this -> view -> assign('questionid',$id);
        return $this->view->fetch();
    }


    public function choosekc()
    {
        $id = $this->request->param('id');
        //获取课程列表
        $kc = db('examination')->order('id desc')->field('id,number,name') ->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('kc',$kc);
        $this->view->assign('id',$id);
        return $this->view->fetch();
    }


    public function gl(){
        $id = $this->request->param('id');
        $data['ex_id'] = $this->request->param('cour_id');
        //修改tiku
        db('question')->data($data)->where(array('id'=>$id))->update();
        return '1';
    }


}
<?php
namespace  app\admin\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class  Survey  extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 管理后台评估管理
     * @authorsurvey
     * @wang
     */
	  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    public function index(){

        $map ='';
        $list = db('survey')->field('id,name,content,createtime,open')-> paginate(10, false, ['query' => $this-> request -> get()]);
        $this-> view -> assign('list', $list);
        $this-> view -> assign("page", $list -> render());
        $this-> view -> assign('numPerPage', $list -> listRows());
        return $this -> view -> fetch();
    }

    /**
     * 添加评估管理
     * @author
     */
    public function add(){
        $table = strtolower($this -> request -> controller());
        if($this -> request -> isAjax()){
            $data['name'] =$this->request->post('name');
            if($this->request->post('open')){
                $data['open'] ='1';
            }else{
                $data['open'] ='0';
            }
            $data['content'] =$this->request->post('content');
            $data['createtime'] =time();
            db('survey')->data($data)->insert();
            return  json(array('state' => 1));
        }else{
            return $this -> view ->  fetch();
        }
    }

    /**
     * 修改评估管理
     * @author
     */
    public function edit(){
        $table = strtolower($this -> request -> controller());
        if($this -> request -> isAjax()){
            $id =  $this -> request -> post('id');
            $data['name'] =$this->request->post('name');
            if($this->request->post('open')){
                $data['open'] ='1';
            }else{
                $data['open'] ='0';
            }
            $data['content'] =$this->request->post('content');
            db('survey') ->data($data) -> where(array('id' => $id)) -> update();
            return  json(array('state' => 1));
        }else{
            $id = $this -> request -> param('id');
            $info = db('survey') -> where(array('id' => $id)) -> find();
            $this -> view -> assign('list',$info);
            $this -> view -> assign('id',$id);
            return $this -> view ->  fetch();
        }
    }

    public function ti(){
        //题库Id
        $questionid = $this -> request -> param('id');
        $list = db('surveyti')->field('id,name,tname,type')->where(array('questionid'=>$questionid))-> paginate(10, false, ['query' => $this-> request -> get()]);
        $this-> view -> assign('list', $list);
        $this->view->assign('id',$questionid);
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
            db('surveyti')->data($data)->insert();
            return  json(array('state' => 1));
        }else{
            $ran=rand('10000','99999');
            $name = md5($ran);
            $questionid = $this -> request -> param('id');
            $this->view->assign('id',$questionid);
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

            db('surveyti')->data($data)->where(array('id'=>$id))->update();
            return  json(array('state' => 1));
        }else{
            $id = $this -> request -> param('id');
            $info = db('surveyti') -> where(array('id' => $id)) -> find();
            if($info['type'] == '1'){
                $info['question'] = json_decode($info['question']);
            }elseif($info['type'] == '2'){
                $info['answer'] = json_decode($info['answer']);
                $info['question'] = json_decode($info['question']);
            }
            $this -> view -> assign('list',$info);

            $this -> view -> assign('id',$info['questionid']);
            return $this -> view ->  fetch();
        }
    }

    public function yulan(){
        $questionid = $this->request->param('id');
        $list = db('surveyti')->where(array('questionid'=>$questionid))->select();
        foreach ($list as $k=>$v){
            $data[$k] = $v;
            if($v['type'] == '1'){
                $data[$k]['question'] = json_decode($v['question']);
            }elseif($v['type'] == '2'){
                $data[$k]['answer'] = json_decode($v['answer']);
                $data[$k]['question'] = json_decode($v['question']);
            }
        }
        $this -> view -> assign('id',$questionid);
        $this -> view -> assign('list',$data);
        return $this -> view ->  fetch();
    }


}
?>
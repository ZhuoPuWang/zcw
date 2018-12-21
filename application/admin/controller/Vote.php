<?php
namespace  app\admin\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class  Vote  extends  Controller{
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
        $list = db('vote')->field('id,name,content,createtime,open')-> paginate(10, false, ['query' => $this-> request -> get()]);
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
            $data['obj'] =$this->request->post('pid');
            $data['content'] = '请修改题目';
            $data['answer'] ='{"data1":null,"data2":null,"data3":null,"data4":null}';
            $data['question'] ='{"data1":"","data2":"","data3":"","data4":""}';
            $data['createtime'] =time();
            db('vote')->data($data)->insert();
            return  json(array('state' => 1));
        }else{
            return $this -> view ->  fetch();
        }
    }

    public function chooseParentDepart()
    {
        $map = array();
        if ($this->request->param('name')) {
            $map['d.name'] = ['like', '%' . $this->request->param('name') . '%'];
        }

        if ($this->request->param('no')) {
            $map['d.no'] = ['like', '%' . $this->request->param('no') . '%'];
        }

        if ($this->request->param('id')) {
            $map['d.id'] = ['neq', $this->request->param('id')];
        }


        $listRows = $this->request->param('numPerPage') ?: Config::get("paginate.list_rows");
        $list = db('depart')->alias('d')->join('zcw_depart b', 'b.id =  d.pid', 'LEFT')->field(array('d.id', 'd.name', 'd.no',
            'b.name as p_name', 'b.no as p_no'))->where($map)->order('d.id desc')
            ->paginate($listRows, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        //$this-> view -> assign("count", $list->total());
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        $this->view->assign('haveLeft', false);
        $this->view->assign('haveHead', false);
        return $this->view->fetch();
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
            $data['obj'] =$this->request->post('pid');
            db('vote') ->data($data) -> where(array('id' => $id)) -> update();
            return  json(array('state' => 1));
        }else{
            $id = $this -> request -> param('id');
            $info = db('vote')
                ->alias('a')
                ->join('depart b','a.obj = b.id','left')
                ->field('a.id,a.name,a.obj,b.name as objname')
                -> where(array('a.id' => $id))
                -> find();
            $this -> view -> assign('list',$info);
            $this -> view -> assign('id',$id);
            return $this -> view ->  fetch();
        }
    }

    public function ti(){
        if($this -> request -> isAjax()){
            $id =$this->request->post('id');
            $data['type'] =$this->request->post('type');
            $data['content'] = $this->request->post('content');
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

            db('vote')->data($data)->where(array('id'=>$id))->update();
            return  json(array('state' => 1));
        }else{
            $id = $this -> request -> param('id');
            $info = db('vote') -> where(array('id' => $id)) -> find();
            if($info['type'] == '1'){
                $info['question'] = json_decode($info['question']);
            }elseif($info['type'] == '2'){
                $info['answer'] = json_decode($info['answer']);
                $info['question'] = json_decode($info['question']);
            }
            $this -> view -> assign('list',$info);
            $this -> view -> assign('id',$id);
            return $this -> view ->  fetch();
        }
    }

    public function yulan(){
        $questionid = $this->request->param('id');
        $list = db('vote')->where(array('id'=>$questionid))->select();
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

    public function fb(){
        $id = $this->request->param('id');
        $data['open'] = '1';
        db('vote')->data($data)->where(array('id'=>$id))->update();
    }
    public function cx(){
        $id = $this->request->param('id');
        $data['open'] = '0';
        db('vote')->data($data)->where(array('id'=>$id))->update();
    }


}
?>
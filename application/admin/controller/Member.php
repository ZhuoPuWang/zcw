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

class Member extends Controller{
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
        $map ='';
        if($this->request->post('realname')){
            $map['usernumber'] =array('like','%'.$this->request->post('realname').'%');
        }else{
            $map ='';
        }
        $list = db('member')->where($map)->field('id,usernumber,realname,role,email,state,starttime')->where($map)->order('id desc')-> paginate(10, false, ['query' => $this-> request -> get()]);
        $this-> view -> assign('list', $list);
        $this-> view -> assign("page", $list -> render());
        $this-> view -> assign('numPerPage', $list -> listRows());
        return $this -> view -> fetch();
    }

    public function  add(){
        if($this -> request -> isAjax()){
            $data = $this-> request -> post();
            if($this-> request -> post('password') != $this-> request -> post('npassword')){
               return json_encode(array('state'=>2,'succ'=>'添加失败!!'));
            }
            $da['usernumber'] = $data['usernumber'];
            $da['realname'] = $data['realname'];
            $da['role'] = $data['role'];
            $da['email'] = $data['email'];
            $da['password'] = md5($data['password']);
            $da['approval'] = $data['approval'];
            $da['starttime'] =time();
            $da['organization'] = $data['pid'];
            $da['phone'] = $data['phone'];
            $da['address'] = $data['address'];
            $da['zw'] = $data['zw'];
            $da['operate'] = $data['operate'];
            $da['echelon'] = $data['echelon'];
            $da['depart'] = $data['depart'];
            $da['dangy'] = $data['dangy'];
            $da['remarks'] = $data['remarks'];
            $da['language'] = $data['language'];
            $da['sex'] = $data['sex'];

            db('member') -> data($da) -> insert();
            return json_encode(array('state'=>1,'succ'=>'修改成功!!'));
        }else{
            $fl = db('fl')->select();
            $this->view->assign('fl',$fl);
            return $this -> view -> fetch();
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


    public function  edit(){
        if($this -> request -> isAjax()){
            $id = $this-> request -> post('id');
            $data = $this-> request -> post();
            if($this-> request -> post('password') != $this-> request -> post('npassword')){
                return json_encode(array('state'=>2,'succ'=>'添加失败!!'));
            }
            $da['usernumber'] = $data['usernumber'];
            $da['realname'] = $data['realname'];
            $da['role'] = $data['role'];
            $da['email'] = $data['email'];
            if( $data['password'] != ''){
                $da['password'] = md5($data['password']);
            }
            $da['approval'] = $data['approval'];
            $da['organization'] = $data['pid'];
            $da['phone'] = $data['phone'];
            $da['address'] = $data['address'];
            $da['zw'] = $data['zw'];
            $da['operate'] = $data['operate'];
            $da['echelon'] = $data['echelon'];
            $da['depart'] = $data['depart'];
            $da['dangy'] = $data['dangy'];
            $da['remarks'] = $data['remarks'];
            $da['language'] = $data['language'];
            $da['sex'] = $data['sex'];
            $da['state'] = '0';

            db('member') -> data($da) ->where('id',$id) -> update();
            return json_encode(array('state'=>1,'succ'=>'添加成功!!'));
        }else{

            $id = $this -> request -> param('id');
            $member = db('member')
                ->alias('a')
                ->join('depart b','a.organization = b.id','left')
                -> where(array('a.id'=> $id))
                ->field('a.id,a.head,a.usernumber,a.realname,a.role,a.email,a.state,a.approval,a.starttime,a.endtime,
                a.organization,a.phone,a.address,a.zw,a.operate,a.echelon,a.depart,a.dangy,a.remarks,a.language,a
                .sex,b.name as pname')
                -> find();
            $this-> view -> assign('news',$member);
            $fl = db('fl')->select();
            $this->view->assign('fl',$fl);

            return $this -> view -> fetch();
        }
    }
}
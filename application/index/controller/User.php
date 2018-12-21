<?php
/**
 * Created by PhpStorm.
 * User: kingblanc
 * Date: 2018/8/27
 * Time: 15:56
 */
namespace app\index\controller;

use  think\Controller;
use  think\Cookie;
use  think\Session;
use think\Config;
class User extends Controller{
    use \app\index\controller\Base;
    /*
     * @author 金志刚
     *用户登陆
     */
	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','1');
}
    public function login(){
        if($this -> request -> isAjax()){
            //验证码验证
            if(!captcha_check($this -> request -> param('verifyCode'))) {
                return json(['state' => 0,'msg' => '验证码错误']);
            }
//
            //检查用户名密码

            $result = db('member') -> field(array('id','realname','usernumber','role','organization')) -> where(array
            ('usernumber' => $this -> request -> param('username'),'password' => md5($this -> request -> param('pwd')
                    ),'state'=>'0')) -> find();

            if($result){

                //判断用户是否勾选记住密码
                if(intval($this -> request -> param('is_checked')) == 1){
                    Cookie::set('userid',$result['id'],['prefix'=>'think_','expire'=> 7*24*3600,'path' => '/']);
                }
                Session::set('userid',$result['id']);
                Session::set('realname',$result['realname']);
                Session::set('username',$result['usernumber']);
                Session::set('organization',$result['organization']);
                Session::set('role',$result['role']);

                //添加日志
                $data['userid'] = Session::get('userid');
                $data['type'] = '登录';
                $data['time'] = time();
                db('logs') -> data($data) -> insert();
                return  json(['state' => 1]);

            }else{
                return json(['state' => 0,'msg' => '用户名或密码错误']);
            }
        }else{
            return $this -> view  -> fetch();
        }
    }

    /*
     * @author 金志刚
     *用户登陆
     */
    public function regist(){
        if($this -> request -> isAjax()){
            $data = $this -> request -> except('repwd');
            $data['password'] = md5($data['password']);
            $data['starttime'] = time() ;
            db('member') -> data($data) -> insert();
            return json(['state' => 1]);
        }else{
            if(!isset($_SESSION['sh'])){
                $sh = db('configure')->where('id','0')->field('name,phone')->find();
                $_SESSION['sh'] = $sh;
            }
            if(!isset($_SESSION['think']['role'])){
                $_SESSION['think']['role'] = '0';
            }
            return $this -> view -> fetch();
        }
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

    //我的信息
    public function  info(){
        $info['userid'] = Session::get('userid');
        $member = db('member')->where('id',$info['userid'])->find();
        $juan = db('juan')->where('uid',$info['userid'])->find();
        $wc = db('kc')->where(array('u_id'=>$info['userid'],'state'=>3))->count();

        $this->assign('member',$member);
        $this->assign('wc',$wc);
        $this->assign('juan',$juan);
        $gq = db('course_classify')->where(array('uid'=>$info['userid'],'status'=>0))->count();
        $jx = db('course_classify')->where(array('uid'=>$info['userid'],'status'=>1))->count();
        $ywc = db('course_classify')->where(array('uid'=>$info['userid'],'status'=>2))->count();
        $dsp = db('course_classify')->where(array('uid'=>$info['userid'],'status'=>3))->count();
        $zong = db('course_classify')->where(array('uid'=>$info['userid']))->count();
		if($gq != 0){
			$gq = $gq / $zong *100;
		}
        if($dsp != 0){
			 $dsp = $dsp / $zong *100;
		}
		if($ywc != 0){
			$ywc = $ywc / $zong *100;
		}
		if($jx != 0){
			$jx = $jx / $zong *100;
		}
        
        
       
        $this ->assign('gq',$gq);
        $this ->assign('jx',$jx );
        $this ->assign('ywc',$ywc);
        $this ->assign('dsp',$dsp);


        $wtg = db('kc')->where(array('u_id'=>$info['userid'],'state'=>0))->count();
        $zbks = db('kc')->where(array('u_id'=>$info['userid'],'state'=>1))->count();
        $ytg = db('kc')->where(array('u_id'=>$info['userid'],'state'=>2))->count();
        $ygq = db('kc')->where(array('u_id'=>$info['userid'],'state'=>4))->count();
        $zong_kc = db('kc')->where(array('u_id'=>$info['userid']))->count();
		
			if($wtg != 0){
			  $wtg = $wtg / $zong_kc *100;
		}
        if($zbks != 0){
			  $zbks = $zbks / $zong_kc *100;
		}
		if($ytg != 0){
			 $ytg = $ytg / $zong_kc *100;
		}
		if($zong_kc != 0){
			 $zong_kc = $zong_kc / $zong_kc *100;
		}
        
      
      
       
       
        $this ->assign('wtg',$wtg);
        $this ->assign('zbks',$zbks );
        $this ->assign('ytg',$ytg);
        $this ->assign('ygq',$ygq);


        return $this -> view -> fetch();
    }
    //修改的信息
    public function  profile(){

        if($this -> request -> isAjax()){
            $data = $this-> request -> post();
            if($this-> request -> post('password') != $this-> request -> post('npassword')){
                return json_encode(array('state'=>2,'succ'=>'添加失败!!'));
            }
            $da['head'] = $data['head'];
            $da['realname'] = $data['realname'];
            $da['email'] = $data['email'];
            $da['password'] = md5($data['password']);
            $da['organization'] = $data['pid'];
            $da['phone'] = $data['phone'];
            $da['zw'] = $data['zw'];
            $da['address'] = $data['address'];
            $da['operate'] = $data['operate'];
            $da['echelon'] = $data['echelon'];
            $da['depart'] = $data['depart'];
            $da['dangy'] = $data['dangy'];
            $da['remarks'] = $data['remarks'];
            $da['language'] = $data['language'];
            $da['sex'] = $data['sex'];

            db('member') -> data($da) -> where('id',1)->update();
            return json_encode(array('state'=>1,'succ'=>'修改成功!!'));
        }else{
            $id =$this->request->param('id');
            $member = db('member')->where('id',$id)->find();
            $this->view->assign('member',$member);
            $fl = db('fl')->select();
            $this->view->assign('fl',$fl);
            return $this -> view -> fetch();
        }
    }



//我的团队
    public function  team(){
        $info['userid'] = Session::get('userid');
        $team = db('member')->where('id',$info['userid'])->find();
        $member = db('member')->where(array('organization'=>$team['organization'],'id'=>array('neq',$info['userid'])))->select();
        $this->view->assign('team',$member);
        return $this -> view -> fetch();
    }
    //我的团队
    public function  fd(){

        return $this -> view -> fetch();
    }


    //使用帮助
    public function  help(){

        return $this -> view -> fetch();
    }


    public function upload_hear()
    {
        $file = request()->file('hearimg');

        if ($file) {
            $path = ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads';
            $info = $file->move($path);
            if ($info) {
                echo json_encode(array('state' => 1, 'path' => date('Ymd') . DS . $info->getFilename()));

            } else {
                echo json_encode(array('state' => 0, 'err' => '上传失败，失败原因为:' . $file->getError()));
            }
        } else {
            echo json_encode(array('state' => 0, 'err' => '网络错误，请重试！'));
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

}
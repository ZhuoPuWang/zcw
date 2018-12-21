<?php
namespace app\admin\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class  Report  extends  Controller{
    use \app\admin\controller\Base;
    /**
     * 报表
     * @author
     */
	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','6');
}
    public function index(){
//        if ($this->request->isAjax()) {
//            $staus = $this -> request ->post();
//            db('report')->where(array('id' => 1))->data($staus)->update();
//        }else{
//            $status = db('report')->where(array('id' => 1))->find();
//            $this->view->assign('status', $status);
//            $this->view->assign('haveLeft', false);
//            return $this -> view -> fetch();
//        }
        $this->redirect('admin/report/train');
    }


    /**
     * 培训记录
     * @author
     */
    public function train(){
            $map  =  array();
            if($this->request->param('uname')){
                $map['c.usernumber'] = array('like','%'.$this->request->param('uname').'%');
            }
            $list = db('kc')->alias('a')
                ->join('course b','a.kc_id = b.id')
                ->join('member c','a.u_id = c.id')
                ->field('a.id,b.course_type,b.course_number,b.course_title,b.course_time_d,b.course_time_h,a.starttime,a.endtime,a.state,c.usernumber,c.realname,c.email')
                ->where($map)
                ->paginate(10);
            $this->view->assign('haveLeft', false);
            $this->view->assign('list', $list);
            $this-> view -> assign("page", $list -> render());
            $this-> view -> assign('numPerPage', $list -> listRows());
            return $this -> view -> fetch();

    }


    /**
     * 课件报表
     * @author
     */
    public function course_report(){

        if($this ->request ->isAjax()){

        }else{
            $list = db('course')
                ->alias('c')
                ->join('user u', 'c.uid=u.id')
                ->field('c.id,u.realname,c.course_title,c.course_type,c.catalog,c.addtime')
                ->paginate(10);
            $this->view->assign('list', $list);
            $this-> view -> assign("page", $list -> render());
            $this-> view -> assign('numPerPage', $list -> listRows());
            $this->view->assign('haveLeft', false);
            return $this -> view -> fetch();
        }
    }

    /**
     * 考试报表
     * @author
     */
    public function examination_report(){
        $map  =  array();
        if($this->request->param('uname')){
            $map['m.usernumber'] = array('like','%'.$this->request->param('uname').'%');
        }
        $list = db('juan')
            ->alias('j')
            ->join('examination e','j.ex_id = e.id')
            ->join('member m','j.uid = m.id')
            ->join('depart d','m.organization = d.id')
            ->field('m.realname,m.usernumber,m.email,d.name,e.number,e.name as title,j.fen,e.limitstart,e.limitend,e.limittime,e.adopt,e.credit')
            ->where($map)
            ->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        $this->view->assign('haveLeft', false);
        return $this -> view -> fetch();


    }


    /**
     * 学习路径报表
     * @author
     */
    public function study_report(){
        $list = db('study')
            ->alias('s')
            ->join('ability a', 's.uid=a.uid')
            ->join('member m', 'm.id=s.uid')
            ->join('depart d', 'm.organization=d.id')
            ->join('fl z', 'm.zw=z.id')
            ->join('fl o', 'm.operate=o.id')
            ->join('fl e', 'm.echelon=e.id')
            ->join('fl t', 'm.depart=t.id')
            ->field('m.usernumber,m.realname,m.email,d.name,m.dangy,z.name as zw,o.name as operate,e.name as echelon,t.name as depart,a.ability_title,s.study_title')
            ->paginate(10);

        $this->view->assign('haveLeft', false);
        $this->view->assign('list', $list);
        return $this -> view -> fetch();
    }


    /**
     * 培训信息
     * @author
     */
    public function lesson(){
        if($this ->request ->isAjax()){

        }else{
            $list = db('course')
                ->alias('c')
                ->join('member u', 'c.uid=u.id')
                ->field('c.user_object,u.realname,c.course_type,c.credit,c.catalog,c.addtime,c.course_number,c.course_title,c.course_content,c.course_time_d,c.updatetime')
                ->paginate(10);

            $this->view->assign('list', $list);
            $this-> view -> assign("page", $list -> render());
            $this-> view -> assign('numPerPage', $list -> listRows());
            $this->view->assign('haveLeft', false);
            return $this -> view -> fetch();
        }
    }


    /**
     * 用户信息
     * @author
     */
    public function user(){
        $map  =  array();
        if($this->request->param('uname')){
            $map['m.usernumber'] = array('like','%'.$this->request->param('uname').'%');
        }
        $list = db('member')
            ->alias('m')
            ->join('depart d', 'm.organization=d.id','left')
            ->join('fl z', 'm.zw=z.id','left')
            ->join('fl o', 'm.operate=o.id','left')
            ->join('fl e', 'm.echelon=e.id','left')
            ->join('fl t', 'm.depart=t.id','left')
            ->join('fl r', 'm.role=r.id','left')
            ->field('z.name as zw,r.name as role,d.name,o.name as operate,e.name as echelon,t.name as depart,m.usernumber, m.realname,m.email,m.sex,m.remarks,m.approval,m.dangy,m.phone,m.address')
            ->order('m.id desc')
            ->where($map)
            ->paginate(10, false, ['query' => $this->request->get()]);

        $this->view->assign('list', $list);
        $this->view->assign('haveLeft', false);
        return $this -> view -> fetch();
    }


    /**
     * 评估报表
     * @author
     */
    public function assess_report(){

        $list = db('assess')->order('id desc')->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        $this->view->assign('haveLeft', false);
        return $this -> view -> fetch();
    }




    /**
     * 讲师报表
     * @author
     */
    public function teacher_report(){
            $map  =  array();
            if($this->request->param('uname')){
                $map['m.usernumber'] = array('like','%'.$this->request->param('uname').'%');
            }
            $list = db('teacher')
                ->alias('t')
                ->join('course c', 't.course=c.id','left')
                ->join('member m', 't.uid=m.id','left')
                ->field('t.id,m.realname,c.course_title,m.email,c.course_time_h,c.course_time_d')
                ->where($map)
                ->paginate(10);
            $this->view->assign('list', $list);
            $this-> view -> assign("page", $list -> render());
            $this-> view -> assign('numPerPage', $list -> listRows());
            $this->view->assign('haveLeft', false);
            return $this -> view -> fetch();

    }


    /**
     * 证书报表
     * @author
     */
    public function certificate_report(){
        $map  =  array();
        if($this->request->param('uname')){
            $map['m.usernumber'] = array('like','%'.$this->request->param('uname').'%');
        }
        $list = db('member')
            ->alias('m')
            ->join('course j', 'm.id= j.uid','left')
            ->join('certificate c', 'j.zs_id=c.id','left')
            ->join('depart d', 'm.organization=d.id','left')
            ->join('fl z', 'm.zw=z.id','left')
            ->join('fl o', 'm.operate=o.id','left')
            ->join('fl e', 'm.echelon=e.id','left')
            ->join('fl t', 'm.depart=t.id','left')
            ->where($map)
            ->field('m.realname,m.dangy,m.usernumber,m.email,d.name,m.email,z.name as zw,o.name as operate,e.name as echelon,t.name as depart ,c.number,c.chtitle,c.entitle,c.endtime')
            ->paginate(10);
        $this->view->assign('haveLeft', false);
        $this->view->assign('list', $list);
        return $this -> view -> fetch();
    }






}
?>
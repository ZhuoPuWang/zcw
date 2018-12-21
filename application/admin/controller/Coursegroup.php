<?php
/**
 * Created by PhpStorm.
 * User: kingblanc
 * Date: 2018/8/29
 * Time: 15:40
 */
namespace app\admin\controller;

use  think\Session;
use think\Config;
use think\Controller;

class Coursegroup extends Controller
{
    use \app\admin\controller\Base;


    /**
     * @yang
     * 列表页，列出所有课程
     *
     */
	  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    public function index()
    {
        $map = '';
        if ($this->request->param('course_title')) {
            $map['a.course_title'] = ['like', '%' . $this->request->param('course_title') . '%'];
        }
        if ($this->request->param('course_type')) {
            $map['a.course_type'] = ['like', '%' . $this->request->param('course_type') . '%'];
        }
        $list = db('course_group')
            ->alias('a')
            ->join('member b', 'a.uid=b.id')
            ->where($map)
            ->field('a.course_number,a.course_title,b.realname,a.id')
            ->paginate(5);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    /**@yang
     * 添加课程信息
     *
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            $data  =  $this->request->except('catalog1');
            $data['addtime'] = time();
            $data['updatetime'] = time();
            $data['uid'] = session('userid');
            $res = db('course_group')->data($data)->insert();
            //添加日志
            $info['userid'] = Session::get('userid');
            $info['type'] = '课程组合管理';
            $info['cont'] = '创建' . $this->request->post('course_title');
            $info['time'] = time();
            db('logs')->data($info)->insert();
//           echo json_encode(array('state' => 1, 'succ' => $data));
//            die;
            if ($res) {
                echo json_encode(array('state' => 1, 'succ' => '新建课程成功!!'));
            } else {
                echo json_encode(array('state' => 0, 'err' => '网络错误，请重试！'));
            }

        } else {

            return $this->view->fetch('add');
        }
    }

    /**@yang
     * 课程编辑
     */
    public function edit()
    {
        if ($this->request->isAjax()) {
            $data  =  $this->request->except('catalog1');
            $id = $this->request->post('id');
            $data['updatetime'] = time();
            $res = db('course_group')->where(array('id' => $id))->data($data)->update();
            if ($res) {
                echo json_encode(array('state' => 1, 'succ' => '修改课程成功!!'));
            } else {
                echo json_encode(array('state' => 0, 'err' => '网络错误，请重试！'));
            }
        } else {
            $id = $this->request->param('id');
            $data = db('course_group')
                ->alias('a')
                ->join('depart b','a.catalog  = b.id','left')
                ->field('a.id,a.course_number,a.course_title,a.course_content,a.catalog,a.target_user,a.email,a
                .weixin,a.self_help,a.to_examine,a.data,a.auto_distribution,a.distribution_condition,a.order,a
                .order_course,a.language,a.diz,b.name as catalogname,a.addtime,a.updatetime')
                ->where('a.id', $id)
                ->find();
            $this->view->assign('data', $data);
            $this->view->assign('ids', $id);
            return $this->view->fetch();
        }
    }


    /**@yang
     * 关联课程
     *
     */
    public function chooseCourse()
    {
        $id = $this->request->param('cpid');
        $list = db('course')->paginate(5);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        $this->view->assign('cpid', $id);
        return $this->view->fetch();
    }

    /***
     * 关联考试
     ****/
    public function chooseExamination()
    {
        $id = $this->request->param('id');
        $cpid = $this->request->param('cpid');
        $data = db('course')->where(array('id' => $id))->find();
        $this->view->assign('data', $data);
        $this->view->assign('cpid', $cpid);
        $this->view->assign('haveLeft', false);
        $this->view->assign('haveHead', false);
        return $this->view->fetch();
    }


    /**@yang
     * 删除课
     */
    public function delete()
    {
        $id = $this->request->param('id');
        db('course_group')->where(array('id' => $id))->delete();

        $this->redirect('coursegroup/index');
    }

    /*****
     * 组合课程键
     *****/
    public function coursereport()
    {
        $id = $this->request->param('id');
        $data = db('course_group')->where('id', $id)->find();
        $map['c.id'] = $id;
        $course = db('course_group_info')
            ->alias('a')
            ->join('course b', 'b.id = a.c_id')
            ->join('course_group c', 'c.id = a.c_p_id')
            ->join('examination d', 'd.id = a.k_id')
            ->where($map)
            ->field('a.id,a.first,a.must,b.course_title,b.course_type,b.course_number,d.name')
            ->paginate(5);
        $this->view->assign('data', $data);
        $this->view->assign('course', $course);
        $this->view->assign("page", $course->render());
        $this->view->assign('numPerPage', $course->listRows());
        $this->view->assign('ids', $id);
        return $this->view->fetch();
    }


    /**@yang
     * 获取部门
     */
    public function chooseParent()
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

    /**@yang
     *获取考试
     */
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
        $list = db('Examination')->order('id desc')
            ->paginate($listRows, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        $this->view->assign('haveLeft', false);
        $this->view->assign('haveHead', false);
        return $this->view->fetch();
    }

    /*****
     * 添加记录
     */
    public function cpadd()
    {
        $data = $this->request->post();
        if ($data['k_id'] == '') {
            return json(array('state' => 2, 'err' => '请选择关联考试'));
        }
        $data['addtime'] = time();
        $res = db('course_group_info')->data($data)->insert();
        if ($res) {
            return json(array('state' => 1, 'succ' => '设置成功'));
        } else {
            return json(array('state' => 0, 'err' => '网络错误！请重试'));
        }
    }

    /****删除课程组合价键
     **/

    public function deletecourse()
    {
        $id = $this->request->param('id');
        db('course_group_info')->where(array('id' => $id))->delete();
        echo '<script>history.go(-1)</script>';
    }

    /***
     * 课程分配
     */
    public function distribution()
    {
        $map = '';
        $id = $this->request->param('id');
        $map['aa.course_group_id']= $id;
        $data = db('course_group')->where('id', $id)->find();
        $list = db('member')
            ->alias('a')
            ->join('depart b','b.id = a.organization')
            ->join('fl c','c.id = a.role')
            ->join('fl d','d.id = a.zw')
            ->join('fl e','e.id = a.operate')
            ->join('fl f','f.id = a.echelon')
            ->join('fl g','g.id = a.dangy')
            ->join('fl h','h.id = a.depart')
            ->join('cpstudy aa','aa.member_id = a.id')
            ->where($map)
            ->field('aa.id,a.realname,a.usernumber,b.name as organization,a.email,c.name as role,d.name as zw,e.name as operate,f.name as echelon,g.name as dangy,h.name as depart')
            ->paginate(10);
        $this->view->assign('ids', $id);
        $this->view->assign('data', $data);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    /***
     * 分配学生
     *
     *****/
    public function cpstudy()
    {
        $cpid = $this->request->param('cpid');
        $member_id = $this->request->param('member_id');
        $data['course_group_id'] = $cpid;
        $data['member_id'] = $member_id;
        $data['addtime'] = time();
        db('cpstudy')->data($data)->insert();
        echo '<script> window.parent.location.reload();
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    parent.layer.close(index);</script>';
    }

    public function chooseStudy()
    {
        $map = '';
        if($this->request->param('realname')){
             $map['a.realname'] = ['like', '%' . $this->request->param('realname') . '%'];
        }
        if($this->request->param('usernumber')){
            $map['a.usernumber'] = ['like', '%' . $this->request->param('usernumber') . '%'];
        }
        $cpid = $this->request->param('cpid');
        $in = db('cpstudy')->where(array('course_group_id'=>$cpid))->select('member_id');
        if($in){
             $t = array();
        foreach ($in as $k => $v) {
            array_push($t, $v['member_id']);
        }
        $tt = join(',', $t);
        $map['a.id'] = array('not in', $tt);
        }
       
        $map['a.role'] = 24;
        $list = db('member')
            ->alias('a')
            ->join('depart b','b.id = a.organization')
            ->join('fl c','c.id = a.role')
            ->join('fl d','d.id = a.zw')
            ->join('fl e','e.id = a.operate')
            ->join('fl f','f.id = a.echelon')
            ->join('fl g','g.id = a.dangy')
            ->join('fl h','h.id = a.depart')
            ->where($map)
            ->field('a.id,a.realname,a.usernumber,b.name as organization,a.email,c.name as role,d.name as zw,e.name as operate,f.name as echelon,g.name as dangy,h.name as depart')
            ->paginate(10);
        
        $this->view->assign('cpid', $cpid);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        $this->view->assign('haveLeft', false);
        $this->view->assign('haveHead', false);
        
        return $this->view->fetch();
    }
    /******
        删除关联
    ******/
      public function deletecpstudy(){
        $id = $this->request->param('id');
        db('cpstudy')->where(array('id'=>$id))->delete();
        echo '<script> history.go(-1)</script>';
      }
}
<?php

namespace app\index\controller;

use  think\Controller;
use  think\Session;
use think\Config;

class Train extends Controller
{
    use \app\admin\controller\Base;

    /**
     * 报表
     * @wang
     */
    public function __construct()
    {
        parent::__construct();
        $this->view->assign('base', '2');
        if (!isset($_SESSION['think']['userid'])) {
            $this->redirect('index/user/login');
        }
    }

    //进行中的课程
    public function index()
    {
        $uid = $_SESSION['think']['userid'];
        $list = db('course')->alias('b')->join('kc a', 'a.kc_id = b.id', 'left')->where(array('a.u_id' => $uid, 'a.state' => array('lt', '2'), 'a.endtime' => array('gt', time())))->field('a.id,a.kc_id,a.state,a.starttime,a.endtime,b.course_title,b.id as course_id,b.ks_id,b.dz_id,b.assess_id')->paginate(10, false, ['query' => $this->request->get()]);

        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    //已完成的课程
    public function index2()
    {
        $uid = $_SESSION['think']['userid'];
        $list = db('kc')
            ->alias('a')
            ->join('course b', 'a.kc_id = b.id', 'left', 'left')
            ->where(array('a.u_id' => $uid, 'a.state' => array('eq', '2'), 'a.endtime' => array('gt', time())))
            ->field('a.id,a.kc_id,a.state,a.starttime,a.endtime,b.course_title,b.ks_id,b.dz_id,b.assess_id')
            ->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    //已过期的课程
    public function index3()
    {
        $uid = $_SESSION['think']['userid'];
        $list = db('kc')->alias('a')->join('course b', 'a.kc_id = b.id', 'left')->where(array('a.u_id' => $uid, 'a.endtime' => array('elt', time())))->field('a.id,a.kc_id,a.state,a.starttime,a.endtime,b.course_title,b.ks_id,b.dz_id,b.assess_id')->paginate(10, false,
            ['query' =>
                $this->request->get()]);

        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    //待审批的课程
    public function index4()
    {

        return $this->view->fetch();
    }

    //考试信息
    public function ks()
    {
        $id = $this->request->param('kc');
        $ks = db('course')->alias('a')->join('examination b', 'a.ks_id = b.id')->field('b.number,b.name,b.describe,b.credit,b.limitstart,b.limitend,b.limittime,b.limitcount,b.outtime,b.adopt,b.id')->find();
        if (!$ks) {
            $this->error('网络错误');
        }
        $juan = db('juan')->where(array('ex_id' => $ks['id']))->find();
        $this->view->assign('juan', $juan);
        $this->view->assign('ks', $ks);
        return $this->view->fetch();

    }

    //更多 课程信息
    public function many()
    {

        $id = $this->request->param('kc');

        $ks = db('course')
            ->alias('a')
            ->join('examination b', 'a.ks_id = b.id', 'left')
            ->where(array('a.id' => $id))
            ->field('a.id,a.course_number,a.course_title,a.course_content,a.course_time_d,a.day,a.language,a.credit,a.ks_id,a.dz_id,a.assess_id,a.sur_id,a.addtime')
            ->find();
        if (!$ks) {
            $this->error('请先添加考试');
        }


        if ($ks['addtime'] + $ks['course_time_d'] * 24 * 3600 <= time()) {
            $ks['endday'] = '0';
        } else {
            $ks['endday'] = floor(($ks['addtime'] + $ks['course_time_d'] * 24 * 3600 - time()) / 24 / 3600);
        }

        $this->view->assign('ks', $ks);
        return $this->view->fetch();
    }

    //开始课程学习
    public function courseplay()
    {
        $id = $this->request->param('id');
        $course_id = $this->request->param('course_id');
        $uids = session('userid');

        $data = db('kc')->where(array('id' => $id))->find();
        $res = db('courseware')->where(array('course_id' => $course_id))->find();
        if ($res) {
            $res['arr'] = json_decode($res['courseware']);

        }
        $this->view->assign('ids', $id);
        $this->view->assign('uids', $uids);
        $this->view->assign('data', $res);
        $this->view->assign('course', $data);


        if ($data['state'] == 0) {
            if ($res['ware_type'] == '0' || $res['ware_type'] == '2') {
               db('kc')->where(array('id' => $id))->update(array('starttime' => time(), 'state' => '2'));
            } else {
               db('kc')->where(array('id' => $id))->update(array('starttime' => time(), 'state' => '1'));
            }
        }

        return $this->view->fetch();

    }

    public function kaos()
    {

        if ($this->request->isAjax()) {
            $data = $this->request->post();

            $ins['ex_id'] = $data['ex_id'];
            $ins['qu_id'] = $data['qu_id'];
            $data1 = array();
            foreach ($data as $k => $v) {
                $data[$k] = $v;
                if (is_array($v)) {
                    $da = '';
                    foreach ($v as $k1 => $v2) {
                        $da = $da . $v2 . ',';
                    }
                    $data[$k] = $da;
                }
            }
            if(count($data)<= 3){
                return array('state' => '2');
            }
            $ins['ti'] = json_encode($data);
            $ins['addtime'] = time();
            $ins['uid'] = $_SESSION['think']['userid'];

            db('kc')->where(array('u_id' => $_SESSION['think']['userid'], 'kc_id' => $data['kc_id']))->update(array
            ('outtime'=>''));

            db('juan')->data($ins)->insert();
            return array('state' => '1');
        } else {
            $id = $this->request->param('ks_id');
            $question = db('question')->where('ex_id', $id)->find();
            if (!$question['kaoti']) {
                $this->error('该考试未关联试题');
            }
            $outtime = db('examination')
                ->where(array('id' => $question['ex_id']))
                ->field('limittime,limitcount')
                ->find();
            $c_id = db('course')
                ->where(array('ks_id' => $id))
                ->field('id')
                ->find();
            $ress = db('kc')
                ->where(array('u_id' => $_SESSION['think']['userid'], 'kc_id' => $c_id['id']))
                ->find();

            //获取考了几次
            $cout = db('juan')->where(array('ex_id'=>$question['ex_id'],'uid'=>$_SESSION['think']['userid']))->count();
            if($cout > $outtime['limitcount']){
                $this->error('请勿重复开始');
            }

            $ti = explode(',', $question['kaoti']);
            $list = db('ti')->where(array('id' => array('IN', $ti)))->select();
            $data = array();
            foreach ($list as $k => $v) {
                $data[$k] = $v;
                if ($v['type'] == '1') {
                    $data[$k]['question'] = json_decode($v['question']);
                } elseif ($v['type'] == '2') {
                    $data[$k]['answer'] = json_decode($v['answer']);
                    $data[$k]['question'] = json_decode($v['question']);
                }
            }

            if ($ress['outtime'] != '') {
                $outtime1 = $ress['outtime'];
            } else {
                $outtime1 = $outtime['limittime'] * 60 + time();
                $kc = array(
                    'outtime' => $outtime1
                );
                $res = db('kc')
                    ->where(array('u_id' => $_SESSION['think']['userid'], 'kc_id' => $c_id['id']))
                    ->data($kc)
                    ->update();
            }
            $time = $outtime1 - time();
            $this->view->assign('list', $data);
            $this->view->assign('question', $question);
            $this->view->assign('outtime', $time);
            $this->view->assign('kc_id', $c_id['id']);
            return $this->view->fetch();
        }
    }

    public function sous()
    {
        if ($this->request->post('course_title')) {
            $map['b.course_title'] = array('like', '%' . $this->request->post('course_title'));
        } else {
            $map = '';
        }
        $uid = $_SESSION['think']['userid'];
        $list = db('course')->alias('b')
            ->join('kc a', 'a.kc_id = b.id', 'left')
            ->where($map)->field('a.id,a.kc_id,a.state,b.addtime,a.starttime,b.course_title')
            ->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    public function zhengshu()
    {
        $ex_id = $this->request->param('id');
        $uid = $_SESSION['think']['userid'];
        //根据考试ID 和用户ID 查找
        $juan = db('juan')
            ->alias('a')
            ->join('certificate b', 'a.cer_id = b.id')
            ->join('member c', 'a.uid = c.id')
            ->where(array('a.ex_id' => $ex_id, 'a.uid' => $uid))
            ->field('b.number,b.chtitle,b.entitle,b.endtime,c.realname,a.fen,a.addtime')
            ->find();


        if (!$juan) {
            $this->error('暂无证书');
        }

        $this->view->assign('juan', $juan);
        return $this->view->fetch();
    }

    public function strat()
    {
        $id = $this->request->param('id');
        $videotime = $this->request->param('video');

        $data['starttime'] = time();
        $data['videotime'] = $videotime;

        $map['u_id'] = session('userid');
        $map['kc_id'] = $id;
        $res = db('kc')->where($map)->field('starttime')->find();
        if ($res['starttime'] == '') {
            $r = db('kc')->where($map)->data($data)->update();
            return json(array('state' => 1));
        } else {
            return json(array('state' => 0));
        }
    }

    public function pinggu()
    {
        //查找评估相关的题目
        $id = $this->request->param('id');
        if (!$id) {
            $this->error('该课程未关联评估');
        }
        $list = db('assessti')->where(array('questionid' => $id))->select();
        $data = array();
        foreach ($list as $k => $v) {
            $data[$k] = $v;
            if ($v['type'] == '1') {
                $data[$k]['question'] = json_decode($v['question']);
            } elseif ($v['type'] == '2') {
                $data[$k]['answer'] = json_decode($v['answer']);
                $data[$k]['question'] = json_decode($v['question']);
            }
        }
        $this->view->assign('list', $data);
        $this->view->assign('id', $id);
        return $this->view->fetch();
    }

    public function dopinggu()
    {
        $data = $this->request->post();
        $ins['course_id'] = $data['course_id'];
        $data1 = array();
        foreach ($data as $k => $v) {
            $data[$k] = $v;
            if (is_array($v)) {
                $da = '';
                foreach ($v as $k1 => $v2) {
                    $da = $da . $v2 . ',';
                }
                $data[$k] = $da;
            }
        }

        $ins['ti'] = json_encode($data);
        $ins['addtime'] = time();
        $ins['uid'] = $_SESSION['think']['userid'];
        db('juanpinggu')->data($ins)->insert();
        return array('state' => '1');

    }

    public function diaoyan()
    {
        //查找评估相关的题目
        $id = $this->request->param('id');
        if (!$id) {
            $this->error('该课程未关联调研');
        }
        $list = db('coursesurveyti')->where(array('questionid' => $id))->select();
        $data = array();
        foreach ($list as $k => $v) {
            $data[$k] = $v;
            if ($v['type'] == '1') {
                $data[$k]['question'] = json_decode($v['question']);
            } elseif ($v['type'] == '2') {
                $data[$k]['answer'] = json_decode($v['answer']);
                $data[$k]['question'] = json_decode($v['question']);
            }
        }
        $this->view->assign('list', $data);
        $this->view->assign('id', $id);
        return $this->view->fetch();
    }

    public function dodiaoyan()
    {
        $data = $this->request->post();
        $ins['course_id'] = $data['course_id'];
        $data1 = array();
        foreach ($data as $k => $v) {
            $data[$k] = $v;
            if (is_array($v)) {
                $da = '';
                foreach ($v as $k1 => $v2) {
                    $da = $da . $v2 . ',';
                }
                $data[$k] = $da;
            }
        }

        $ins['ti'] = json_encode($data);
        $ins['addtime'] = time();
        $ins['uid'] = $_SESSION['think']['userid'];
        db('juandiaoyan')->data($ins)->insert();
        return array('state' => '1');

    }

    public function looktime()
    {
        $id = $this->request->param('id');
        $looktime = db('kc')->where(array('id' => $id))->field('looktime')->find();
        echo json_encode($looktime);
    }

    public function updatastate()
    {
        $id = $this->request->param('id');
        $data['state'] = $this->request->param('state');
        $res = db('kc')->where(array('id' => $id))->data($data)->update();
        echo json_encode(array('txt' => $res));
    }

    public function outtime()
    {
        $id = $this->request->param('id');
        $time = db('examination')->where(array('id' => $id))->find();
        echo json_encode($time);
    }
}

?>
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
use think\Db;

class Course extends Controller
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
        $list = db('course')
            ->alias('a')
            ->join('member b', 'a.uid=b.id','left')
            ->where($map)
            ->field('a.course_type,a.course_number,a.course_title,b.realname,a.id')
            ->order('a.id desc')
            ->paginate(5);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    public function delcourse(){
        $id = $this->request->param('id');
        db('course')->where('id',$id)->delete();
        return 1;
    }

    /**@yang
     * 添加课程信息
     *
     */
    public function add()
    {
        if ($this->request->isAjax()) {

            $data =  $this->request->except(array('user_object1','catalog1'));
            $data['addtime'] = time();
            $data['updatetime'] = time();
            $data['uid'] = session('userid');
            $res = Db::name('course')->insertGetId($data);
//            //添加教师
            $tea['teacher_id'] = $_SESSION['think']['userid'];
            $tea['course_id'] = $res;

            db('course_teacher')->data($tea)->insert();
            //用户目录为总部是添加学生只添加本部门学生，不添加下级部门
            if($data['user_object'] != 1){
                $user = db('member')->where(array('organization'=>$data['user_object'],'role'=>'0','state'=>'0'))->field
                ('id')
                    ->select();
                $student = array();
                if($user){
                    foreach($user as $k=>$v){
                        $student[$k]['kc_id'] = $res;
                        $student[$k]['state'] = '0';
                        $student[$k]['u_id'] = $v['id'];
                        $student[$k]['starttime'] = $data['addtime'];
                        $student[$k]['endtime'] = $data['addtime'] + $data['day'] * 24 * 60 * 60;
                    }
                    Db::name('kc')->insertAll($student);
                }
            }
            //添加日志
            $info['userid'] = Session::get('userid');
            $info['type'] = '课程管理';
            $info['cont'] = '创建' . $this->request->post('course_title');
            $info['time'] = time();
            db('logs')->data($info)->insert();
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
            $data = $this->request->except('user_object1,catalog1');
            unset($data['id']);
            $id = $this->request->post('id');
            $data['updatetime'] = time();
            $res = db('course')->where(array('id' => $id))->data($data)->update();
            if ($res) {
                echo json_encode(array('state' => 1, 'succ' => '修改课程成功!!'));
            } else {
                echo json_encode(array('state' => 0, 'err' => '网络错误，请重试！'));
            }
        } else {
            $id = $this->request->param('id');
            $data = db('course')
                ->alias('a')
                ->join('depart b','a.user_object = b.id','left','left')
                ->join('depart c','a.catalog = c.id','left','left')
                ->field('a.id,a.course_type,a.course_number,a.course_title,a.course_content,a.credit,a.course_time_d,
                a.day,a.user_object,a.catalog,a.target_user,a.email,a.weixin,a.self_help,a.to_examine,a.data,a
                .certificate,a.auto_distribution,a.distribution_condition,a.order,a.order_course,a.language,a.diz,a
                .course_time_h,b.name as user_objectname,c.name as catalogname,a.addtime,a.updatetime')
                ->where('a.id', $id)
                ->find();
            $this->view->assign('data', $data);
            $this->view->assign('ids', $id);
            return $this->view->fetch();
        }
    }

    /**@yang
     * 课程报表
     *
     */
    public function coursereport()
    {
        $id = $this->request->param('id');
        $list = db('coursereport')
            ->alias('a')
            ->join('member b', 'a.user_id=b.id','left')
            ->join('course c', 'a.course_id = c.id','left')
            ->where('c.id', $id)
            ->field('a.id,b.usernumber,b.realname,b.email,b.organization,c.course_title,c.course_type,c.catalog')
            ->paginate(3);
        $this->view->assign('ids', $id);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    /**课件管理
     * @return string
     */
    public function coursekj()
    {
        if ($this->request->isAjax()) {
            $result = $this->request->post();
//            dump($result);
            $data['ware_type'] = $result['attachment_type'];
            $data['courseware'] = json_encode($result['attaches']);
            $id = $result['course_id'];
            $datas = db('courseware')->where(array('course_id' => $id))->find();

            if ($datas) {
                unset($data['id']);
                $data['updatetime'] = time();
                $res = db('courseware')->where(array('id' => $datas['id']))->data($data)->update();
                if ($res) {
                    echo json_encode(array('state' => 1, 'succ' => '课件更新成功!'));
                } else {
                    echo json_encode(array('state' => 0, 'err' => '网络错误，请重试！'));
                }
            } else {
                $data['course_id'] = $result['course_id'];
                $data['addtime'] = time();
                $data['uid'] = session('userid');
                // return json(array('data'=>$data));
                $res = db('courseware')->data($data)->insert();
                if ($res) {
                    echo json_encode(array('state' => 1, 'succ' => '课件上传成功!!'));
                } else {
                    echo json_encode(array('state' => 0, 'err' => '网络错误，请重试！'));
                }
            }
        } else {
            $id = $this->request->param('id');
            $this->view->assign('ids', $id);
            return $this->view->fetch();
        }
    }

    /****
     * 课程预览
     */
    public function courseplay()
    {

        $id = $this ->request->param('id');
        $data = db('courseware')->where(array('course_id' => $id))->find();

        if ($data) {
            $data['arr'] = json_decode($data['courseware']);
            $this->view->assign('ids',$id);
            $this->view->assign('data',$data);
            return $this->view->fetch();
        }else{
            $this->redirect('admin/course/coursekj',array('id'=>$id));
        }

    }

    /**
     *上传课件
     *
     */
    public function uploadPic()
    {
        $type = $this->request->param('type');
        $pic_name = $this->request->param('pic_name');
        $file = request()->file($pic_name);

        if ($file) {
            //设置文件大小及后缀名
            if ($type == 0) {
                $rule = array('ext' => 'jpg,jpeg,gif,png');
            } elseif($type == 1) {
                $rule = array('ext' => 'avi,rmvb,asf,mp4');
            }else{
                $rule = array('ext' => 'pdf');
            }

            if (!$file->check($rule)) {
                echo json_encode(array('state' => 0, 'reason' => $file->getError()));
                exit;
            }

            $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');

            if ($info) {
                if ($type == 1) {
                    //生成缩略图
                    $v_file = ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads' . DS . date('Ymd') . DS . $info->getFilename();
                    $file_name = current(explode('.', $info->getFilename()));
                    $command_str = "D:/ffmp/bin/ffmpeg.exe -i " . $v_file . " -y -f mjpeg -ss 3 -t 1 -s 320*240 " .
                        ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads' . DS . date('Ymd') . DS . $file_name . '.jpg';
                    system($command_str);
                    //转码
                    $command_str = "D:/ffmp/bin/ffmpeg.exe -i " . $v_file . " -s 640*480 -c:v libx264 -strict -2 " .
                        ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads' . DS . date('Ymd') . DS . $file_name . 'v.mp4';
                    exec($command_str);
                    session('preview', date('Ymd') . '/' . $file_name . 'v.mp4');
                    echo json_encode(array('state' => 1, 'cover_path' => date('Ymd') . '/' . $file_name . '.jpg', 'path' => date('Ymd') . '/' . $file_name . 'v.mp4'));
                } else {
                    echo json_encode(array('state' => 1, 'path' => date('Ymd') . '/' . $info->getFilename()));
                }
            } else {
                echo json_encode(array('state' => 0, 'reason' => $file->getError()));
            }
        } else {
            echo json_encode(array('state' => 0, 'reason' => '文件name值错误', "null" => $file,
                "file" => $pic_name,'type'=>$type));
        }
    }


    public function play()
    {
        $this->view->assign('preview_src', session('preview'));
        $this->view->assign('haveLeft', false);
        $this->view->assign('haveHead', false);
        return $this->view->fetch();
    }


    /**@yang
     * 关联老师
     *
     */
    public function courseteacher()
    {
        $id = $this->request->param('id');
        $data = db('course')->where('id', $id)->find();
        $teacher = db('teacher')
            ->alias('a')
            ->join('course_teacher b', 'b.teacher_id =a.uid','left')
            ->join('member c', 'c.id = a.uid','left')
            ->join('depart d', 'c.organization = d.id','left')
            ->where(array('b.course_id' => $id))
            ->field('c.realname,c.usernumber,d.name,b.id')
            ->paginate(5);
        $this->view->assign('data', $data);
        $this->view->assign('teacher', $teacher);
        $this->view->assign("page", $teacher->render());
        $this->view->assign('numPerPage', $teacher->listRows());
        $this->view->assign('ids', $id);
        return $this->view->fetch();
    }

    /**@yang
     * 删除课
     */
    public function deletecourseteacher()
    {
        $id = $this->request->param('id');
        db('course_teacher')->where(array('id' => $id))->delete();
        echo '<script> history.go(-1)</script>';
    }

    /*获取当前课程为非配的老师
     *@yang
     * */
    public function chooseTeacher()
    {
        $map = array();
        $id = $this->request->param('id');
        if ($this->request->param('usernumber')) {
            $map['c.usernumber'] = ['like', '%' . $this->request->param('usernumber') . '%'];
        }

        if ($this->request->param('realname')) {
            $map['c.realname'] = ['like', '%' . $this->request->param('realname') . '%'];
        }
        $tec = db('course_teacher')->where(array('course_id' => $id))->field('teacher_id')->select();
        $t = array();
        foreach ($tec as $k => $v) {
            array_push($t, $v['teacher_id']);
        }
        $tt = join(',', $t);
        $map['a.id'] = array('not in', $tt);
        $teacher = db('teacher')
            ->alias('a')
            ->join('member c', 'c.id = a.uid','left')
            ->join('depart d', 'c.organization = d.id','left')
            ->where($map)
            ->field('c.realname,c.usernumber,d.name,a.id')
            ->paginate(5);
        $this->view->assign('list', $teacher);
        $this->view->assign('ids', $id);
        $this->view->assign('haveLeft', false);
        $this->view->assign('haveHead', false);
        return $this->view->fetch();
    }

    public function addCourseTeacher()
    {
        $data['teacher_id'] = $this->request->param('teacher_id');
        $data['course_id'] = $this->request->param('course_id');
        db('course_teacher')->data($data)->insert();
        echo '<script> window.parent.location.reload();
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    parent.layer.close(index);</script>';

    }

    /**@yang
     * 获取部门
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
     * 获取部门
     */
    public function distribution()
    {
        $id = $this->request->param('id');
        $map = '';
        $list = db('member')->paginate(3);
        $coursereport = db('coursereport')->select();
//        $list = json_encode($list);
//        $list = json_decode($list);
//       foreach($list->data as $k=>$v){
//           foreach($coursereport as $kone=>$vone){
//               if($v->id == $vone['user_id']){
//                   $v->fp = 1;
//
//               }else{
//                   $v->fp = 0;
//
//               }
//           }
//
//       }
        $this->view->assign('ids', $id);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());

        return $this->view->fetch();
    }


    public function ks()
    {
        $id = $this->request->param('id');
        $ks_id = db('course')->where(array('id' => $id))->field('ks_id')->find();
        $question = array();
        if ($ks_id) {
            $question_id = db('examination')->where(array('id' => $ks_id['ks_id']))->field('id,name,limitstart')->find();
        }
        $this->view->assign('ids', $id);
        $this->view->assign('question', $question_id);
        return $this->view->fetch();
    }

    public function chooseks()
    {
        $id = $this->request->param('id');
        //获取考题库
        $ks = db('examination')->order('id desc')->field('id,name,limitstart')->paginate(10, false, ['query' => $this->request->get()]);

        $this->view->assign('ks', $ks);
        $this->view->assign('id', $id);
        return $this->view->fetch();
    }

    public function gl()
    {
        $id = $this->request->param('id');
        $data['ks_id'] = $this->request->param('ks_id');
        //修改哦课程
        db('course')->data($data)->where(array('id' => $id))->update();
        return '1';
    }

    public function dz()
    {
        $id = $this->request->param('id');
        $dz = db('course')->alias('a')->join('discuz b', 'a.dz_id = b.id','left')->where(array('a.id' => $id))->field('b.id,b.title,b.content,b.summary')->find();
        $this->view->assign('ids', $id);
        $this->view->assign('question', $dz);
        return $this->view->fetch();
    }

    public function choosedz()
    {
        $id = $this->request->param('id');
        //获取考题库
        $ks = db('discuz')->order('id desc')->field('id,title,summary')->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('ks', $ks);
        $this->view->assign('id', $id);
        return $this->view->fetch();
    }

    public function dzgl()
    {
        $id = $this->request->param('course_id');
        $data['dz_id'] = $this->request->param('id');
        //修改讨论区
        db('course')->data($data)->where(array('id' => $id))->update();
        return '1';
    }

    //关联证书
    public function zs()
    {
        $id = $this->request->param('id');
        $dz = db('course')->alias('a')->join('certificate b', 'a.zs_id = b.id','left')->where(array('a.id' => $id))->field('b.id,b.number,b.chtitle,b.entitle,b.endtime')->find();

        $this->view->assign('ids', $id);
        $this->view->assign('question', $dz);
        return $this->view->fetch();
    }

    public function choosezs()
    {
        $id = $this->request->param('id');
        $ks = db('certificate')->order('id desc')->field('id,number,chtitle,entitle,endtime')->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('ks', $ks);
        $this->view->assign('id', $id);
        return $this->view->fetch();
    }

    public function zsgl()
    {
        $id = $this->request->param('course_id');
        $data['zs_id'] = $this->request->param('id');
        //修改讨论区
        db('course')->data($data)->where(array('id' => $id))->update();
        return '1';
    }


    public function coursestudent(){
        $id  = $this->request->param('id');
        if ($this->request->param('name')) {
            $map['a.realname'] = ['like', '%' . $this->request->param('name') . '%'];
        }
        //获取已关联的学生
        $user = db('kc')->alias('a')->join('member b','a.u_id = b.id','left')->where(array('a.kc_id'=>$id))->field('a.id as kc_id,b.id,b.realname,b.usernumber')->paginate(10, false, ['query' => $this->request->get()]);

        $this->view->assign('ids', $id);
        $this->view->assign('user', $user);
        $this->view->assign("page", $user->render());
        $this->view->assign('numPerPage', $user->listRows());
        return $this->view->fetch();

    }

    public function choosestudent(){
        $map = array();
        $id  = $this->request->param('id');
        if ($this->request->param('name')) {
            $map['realname'] = ['like', '%' . $this->request->param('name') . '%'];
        }
        //查找已有的用户
        $user = array();
        $uid = '';
        $user = db('kc')->where(array('kc_id'=>$id))->field('u_id')->select();
        $map['role'] = 0;
        $map['state'] = 0;
        foreach($user as $k=>$v){
            $uid = $uid.','.$v['u_id'];
        }

        $list = db('member')->where(array('id'=>array('notin',$uid)))->where($map)->field('id,realname,
        usernumber')
            ->paginate(10, false, ['query' => $this->request->get()]);

        $this->view->assign('ids', $id);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    public function dochoose(){
        $data['u_id']= $this->request->param('id');
        $data['kc_id'] = $this->request->param('kc_id');
        $kc = db('course')->where(array('id'=>$data['kc_id']))->field('day,addtime')->find();
        $data['endtime'] = $kc['addtime'] + $kc['day'] * 24 * 60 * 60;
        db('kc')->data($data)->insert();
        return '1';
    }
    public function delstu(){
        $id= $this->request->param('id');
        db('kc')->where(array('id'=>$id))->delete();
        return '1';
    }

    public function delete(){
        $id = $this->request->param('id');
        db('course')->where('id',$id)->delete();
        $this->redirect("admin/course/index");
    }

    public function pg()
    {
        $id = $this->request->param('id');
        $dz = db('course')->alias('a')->join('assess b', 'a.assess_id = b.id','left')->where(array('a.id' => $id))
            ->field('b.id,b.name,b.createtime,b.open,b.content,b.subject')->find();
        $this->view->assign('ids', $id);
        $this->view->assign('question', $dz);
        return $this->view->fetch();
    }

    public function choosepg()
    {
        $id = $this->request->param('id');
        //获取考题库
        $ks = db('assess')->order('id desc')->field('id,name,createtime,open,content,subject')->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('ks', $ks);
        $this->view->assign('id', $id);
        return $this->view->fetch();
    }

    public function pggl()
    {
        $id = $this->request->param('course_id');
        $data['assess_id'] = $this->request->param('id');
        //修改讨论区
        db('course')->data($data)->where(array('id' => $id))->update();
        return '1';
    }

    public function dy()
    {
        $id = $this->request->param('id');
        $dz = db('course')->alias('a')->join('coursesurvey b', 'a.sur_id = b.id','left')->where(array('a.id' => $id))
            ->field('b.id,b.name,b.createtime,b.open,b.content,b.subject')->find();
        $this->view->assign('ids', $id);
        $this->view->assign('question', $dz);
        return $this->view->fetch();
    }

    public function choosedy()
    {
        $id = $this->request->param('id');
        //获取考题库
        $ks = db('coursesurvey')->order('id desc')->field('id,name,createtime,open,content,subject')->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('ks', $ks);
        $this->view->assign('id', $id);
        return $this->view->fetch();
    }

    public function dygl()
    {
        $id = $this->request->param('course_id');
        $data['sur_id'] = $this->request->param('id');
        //修改讨论区
        db('course')->data($data)->where(array('id' => $id))->update();
        return '1';
    }

}



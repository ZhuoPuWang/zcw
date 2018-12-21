<?php
/**
 * Created by PhpStorm.
 * User: kingblanc
 * Date: 2018/8/29
 * Time: 15:40
 */
namespace app\admin\controller;

use think\Config;
use think\Controller;


class Teacher extends Controller
{
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
    public function index()
    {
        $map = [];
        if ($this->request->param('realname')) {
            $map['b.realname'] = ['like', '%' . $this->request->param('realname') . '%'];
        }
        $list = db('teacher')
            ->alias('a')
            ->join('member b','b.id = a.uid')
            ->where($map)
            ->field('b.realname,b.email,a.addtime,a.id,a.status')
            ->paginate(10);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    /**
     * 添加讲师信息
     * @author
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post();
            unset($data['courseshow']);
            unset($data['headimg']);
            $data['addtime'] = time();
            $res = db('teacher')->data($data)->insert();
            if ($res) {
                echo json_encode(array('state' => 1, 'succ' => '新建讲师成功!!'));
            } else {
                echo json_encode(array('state' => 0, 'err' => '网络错误，请重试！'));
            }
        } else {
            $member = db('member')
                ->where(array('role'=>'1','state'=>'0'))
                ->field('id,realname')
                ->select();
            $this->view->assign('member',$member);
            return $this->view->fetch('add');
        }
    }

    /**
     * 修改讲师信息
     * @author
     */
    public function edit()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post();
            $id = $this->request->post('ids');
            unset($data['ids']);
            unset($data['courseshow']);
            unset($data['hearimg']);
            $data['addtime'] = time();
            $res = db('teacher')->where(array('id' => $id))->data($data)->update();
            if ($res) {
                echo json_encode(array('state' => 1, 'succ' => '修改讲师成功!!'));
            } else {
                echo json_encode(array('state' => $data,'id'=>$id, 'err' => '网络错误，请重试！'));
            }
        } else {
            $id = $this->request->param('id');
            $teacher = db('teacher')
                ->alias('a')
                ->join('member c','c.id = a.uid')
                ->where(array('a.id' => $id))
                ->field('a.id,c.realname,a.uid,a.aptitude,a.intro,a.shot_inintro,a.experience,a.honor,a.course,a.head')
                ->find();
            $this->view->assign('teacher', $teacher);
            return $this->view->fetch();
        }
    }

    /**
     * 删除讲师
     * @author
     */
    public function delete()
    {
        $id = $this->request->param('id');
        $teacher = db('teacher')->where(array('id' => $id))->delete();
    }
///**
//     * 禁用讲师
//     * @author
//     */
//    public function forbid(){
//            $id = $this->request->param('id');
//            $teacher = db('teacher')->where(array('id'=>$id))->find();
//
//
//    }
    /**
     * 弹出框，功能为列出所有课程
     * @author
     */
    public function chooseCourse()
    {
        $map = array();
        if ($this->request->param('couser_title')) {
            $map['couser_title'] = ['like', '%' . $this->request->param('couser_title') . '%'];
        }

        if ($this->request->param('couser_number')) {
            $map['couser_number'] = ['like', '%' . $this->request->param('couser_number') . '%'];
        }
        $listRows = $this->request->param('numPerPage') ?: Config::get("paginate.list_rows");
        $list = db('course')->where($map)->order('id desc')
            ->paginate($listRows, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        //$this-> view -> assign("count", $list->total());
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        $this->view->assign('haveLeft', false);
        $this->view->assign('haveHead', false);
        return $this->view->fetch();
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
}
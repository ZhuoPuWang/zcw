<?php
namespace app\admin\controller;
use  think\Session;
use think\Controller;

class  Study extends Controller
{
    use \app\admin\controller\Base;

    /**
     * 学习路径管理
     * @author
     */
	  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    public function index()
    {
        $map = '';
        if ($this->request->param('study_title')) {
            $map['a.study_title'] = ['like', '%' . $this->request->param('study_title') . '%'];
        }
        $list = db('study')
            ->alias('a')
            ->join('member b', 'b.id = a.uid')
            ->where($map)
            ->field('a.study_number,a.study_title,b.realname,b.usernumber,a.id')
            ->paginate(10);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    /**
     * 添加职位
     * @author
     */
    public function add()
    {

        if ($this->request->isAjax()) {
            $data = $this->request->post();
            $data['addtime'] = time();
            $data['uid'] = session('userid');
            $res = db('study')->data($data)->insert();
            if ($res) {
                echo json_encode(array('state' => 1, 'succ' => '新建职位成功!!'));
            } else {
                echo json_encode(array('state' => 0, 'err' => '网络错误，请重试！'));
            }
        } else {
            return $this->view->fetch();
        }

    }

    /**
     * 修改职位
     * @author
     */
    public function edit()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post();
            $data['addtime'] = time();
            $data['uid'] = session('userid');
            $res = db('study')->where(array('id' => $data['id']))->data($data)->update();
            if ($res) {
                echo json_encode(array('state' => 1, 'succ' => '修改职位成功!!'));
            } else {
                echo json_encode(array('state' => 0, 'err' => '网络错误，请重试！'));
            }
        } else {
            $id = $this->request->param('id');
            $res = db('study')->where(array('id' => $id))->find();
            $this->view->assign('data', $res);
            $this->view->assign('id', $id);
            return $this->view->fetch();
        }

    }

    public function ability()
    {
        $id = $this->request->param('id');
        $list = db('ability')
            ->alias('a')
            ->join('member b', 'a.uid = b.id')
            ->where(array('study_id' => $id))
            ->field('a.ability_title,a.ability_number,b.realname,a.id')
            ->order('id desc')
            ->paginate(5);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        $this->view->assign('id', $id);
        return $this->view->fetch();
    }

    public function abilityadd()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post();
            $data['add_time'] = time();
            $data['uid'] = session('userid');
            unset($data['ability_id']);
            $res = db('ability')->data($data)->insert();
            if ($res) {
                return json(array('status' => 1, 'data' => '新建成功！'));
            } else {
                return json(array('status' => 0, 'data' => '网络错误，请重试！'));
            }

        } else {
            $study_id = $this->request->param('study_id');
            $this->view->assign('study_id', $study_id);
            $this->view->assign('haveLeft', false);
            $this->view->assign('haveHead', false);
            return $this->view->fetch();
        }
    }

    public function abilityedit()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post();
            $id = $data['ability_id'];
            $data['add_time'] = time();
            $data['uid'] = session('userid');
            unset($data['ability_id']);
            unset($data['study_id']);

            $res = db('ability')->where(array('id' => $id))->data($data)->update();
                if ($res) {
                    return json(array('status' => 1, 'data' => '修改成功！'));
                } else {
                    return json(array('status' => 0, 'data' => '网络错误，请重试！'));
                }

        } else {
            $id = $this->request->param('ability_id');
            $data = db('ability')->where(array('id' => $id))->find();
            $this->view->assign('data', $data);
            $this->view->assign('haveLeft', false);
            $this->view->assign('haveHead', false);
            dump($id);
            return $this->view->fetch();
        }
    }

   public function delete(){
           if($this->request->isAjax()){
               $data = $this->request->post();

               $res = db('study')->where(array('id' => $data['id']))->delete();
               if ($res) {
                   return json(array('status' => 1, 'data' => '删除成功！'));
               } else {
                   return json(array('status' => 0, 'data' => '网络错误，请重试！'));
               }
           }else{
               $id = $this->request->param('id');
               $res = db('study')->where(array('id' => $id))->find();
               $this->view->assign('data', $res);
               $this->view->assign('id', $id);
               return $this->view->fetch();
           }
    }
}

?>
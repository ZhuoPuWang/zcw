<?php
namespace app\admin\controller;

use  think\Controller;
use  think\Session;
use think\Config;

class  Courseassess extends Controller
{
    use \app\admin\controller\Base;

    /**
     * 管理后台课前调研
     * @wang
     */
	  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    public function index()
    {

        $map = '';
        if($this->request->post('name')){
            $map['b.name'] = ['like', '%' . $this->request->param('name') . '%'];

        }
        $id = $this->request->param('id');
        $map['a.course_id'] = $id;
        $data = db('course')->where(array('id' => $id))->find();
        $list = db('course_assess')
            ->alias('a')
            ->join('assess b', 'b.id = a.assess_id')
            ->where($map)
            ->field('a.id,b.name,b.content,b.open,a.addtime')
            ->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        $this->view->assign('ids', $id);
        $this->view->assign('data', $data);
        return $this->view->fetch();
    }

    /**
     * 添加评估管理
     * @author
     */
    public function chooseassess()
    {
        $map = '';
        $id = $this->request->param('id');
        if ($this->request->param('name')) {
            $map['name'] = ['like', '%' . $this->request->param('name') . '%'];

        }

        $list = db('assess')->field('id,name,content,createtime,open')->where($map)->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        $this->view->assign('ids', $id);
        $this->view->assign('haveLeft', false);
        $this->view->assign('haveHead', false);
        return $this->view->fetch();

    }

    /**
     * 关联评估
     * @author
     */
    public function addassess()
    {
        $data['assess_id'] = $this->request->param('id');
        $data['course_id'] = $this->request->param('course_id');
        $data['addtime'] = time();
        $res = db('course_assess')->where(array('assess_id' => $data['assess_id'], 'course_id' => $data['course_id']))->find();
        if ($res) {
            db('course_assess')->data($data)->where(array('id' => $res['id']))->update();
        } else {
            db('course_assess')->data($data)->insert();
        }
        echo '<script> window.parent.location.reload();
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    parent.layer.close(index);</script>';
    }

    public function delete()
    {
        $id = $this->request->param('id');
        db('course_assess')->where(array('id' => $id))->delete();
        return json(array(1));
    }

}

?>
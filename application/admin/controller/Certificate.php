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

class Certificate extends Controller{
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
        $cer = db('certificate')->select();
        $this->view->assign('cer',$cer);

        $this->view->assign('haveLeft', false);
        return $this->view->fetch();
    }

    public function add(){
        if ($this->request->isAjax()) {
            $data['number'] = $this->request->post('number');
            $data['chtitle'] = $this->request->post('chtitle');
            $data['entitle'] = $this->request->post('entitle');
            $data['endtime'] = strtotime($this->request->post('endtime'));

            db('certificate')->data($data)->insert();
            return json(array('state'=>'1'));
        }else{
            $this->view->assign('haveLeft', false);
            return $this->view->fetch();
        }
    }

    public function edit(){
        if ($this->request->isAjax()) {
            $id = $this->request->post('id');
            $data['number'] = $this->request->post('number');
            $data['chtitle'] = $this->request->post('chtitle');
            $data['entitle'] = $this->request->post('entitle');
            $data['endtime'] = strtotime($this->request->post('endtime'));

            db('certificate')->data($data)->where(array('id'=>$id))->update();
            return json(array('state'=>'1'));
        }else{
            $id = $this->request->param('id');
            $cer = db('certificate')->where(array('id'=>$id))->find();
            $this->view->assign('cer', $cer);
            $this->view->assign('haveLeft', false);
            return $this->view->fetch();
        }
    }




}
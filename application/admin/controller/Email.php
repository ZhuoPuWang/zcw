<?php
namespace app\admin\controller;

use  think\Controller;
use  think\Session;
use think\Config;

class Email extends Controller
{
    use \app\admin\controller\Base;
 	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    /**
     * 管理后台邮件管理
     * @author
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post();
            $data['add_time'] = time();
            if (db('email')->where(array('email_type' => $data['email_type']))->find()) {

                $res = db('email')->where(array('email_type' => $data['email_type']))->data($data)->update();
                if ($res) {
                    return json(array('status' => 1, 'data' => '修改成功！'));
                } else {
                    return json(array('status' => 0, 'data' => '网络错误，请重试！'));
                }
            } else {
                $res = db('email')->data($data)->insert();
                if ($res) {
                    return json(array('status' => 1, 'data' => '添加成功！'));
                } else {
                    return json(array('status' => 0, 'data' => '网络错误，请重试！'));
                }
            }

        } else {
            if($this->request->param('type')){
                $type = $this->request->param('type');
            }else{
                $type = 1;
            }
            $res = db('email')->where(array('email_type' => $type))->find();
            $this->view->assign('data',$res);
            $this->view->assign('type',$type);
            return $this->view->fetch();
        }

    }


}

?>
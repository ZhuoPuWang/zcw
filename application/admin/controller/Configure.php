<?php
namespace app\admin\controller;

use  think\Controller;
use  think\Session;
use think\Config;

class Configure extends Controller
{
    use \app\admin\controller\Base;

    /**
     * 管理配置管理
     * @author
     */
	  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    //系统信息
    public function index()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post();
            $result = db('configure')->find();
            if ($result) {
                $res = db('configure')->data($data)->where('id', 1)->update();
                if ($res) {
                    return json(array('status' => 1, 'data' => '修改成功'));
                } else {
                    return json(array('status' => 0, 'data' => '网络错误，请重试！！！'));
                }
            } else {
                $res = db('configure')->data($data)->insert();
                if ($res) {
                    return json(array('status' => 1, 'data' => '添加成功'));
                } else {
                    return json(array('status' => 0, 'data' => '网络错误，请重试！！！'));
                }
            }
        } else {
            $this->view->assign('haveLeft', false);
            $configure = db('configure')->find();
            $this->view->assign('configure', $configure);
            return $this->view->fetch();
        }

    }


//图标管理
    public function icon()
    {
        if ($this->request->isAjax()) {
            $logo['logo'] = $this->request->post('logo');
            if ($logo) {
                db('configure')->data($logo)->where('id', 1)->update();
            }
            $ewm['ewm'] = $this->request->post('ewm');
            if ($ewm) {
                db('configure')->data($ewm)->where('id', 1)->update();
            }

        } else {
            $configure = db('configure')->find();
            $this->view->assign('configure', $configure);
            $this->view->assign('haveLeft', false);
            return $this->view->fetch();
        }

    }




//主页管理
    public function home()
    {
        if ($this->request->isAjax()) {

            $id1 = $this->request->post('bannerid');
            $data1['icn'] =  $this->request->post('banner');
            if($this->request->post('banners')){
                $data1['status'] = '1' ;
            }else{
                $data1['status'] =  '0';
            }
            $data1['title'] =  $this->request->post('bannert');
           db('home')->data($data1)->where(array('id'=>$id1))->update();

            $id2 = $this->request->post('courseid');
            $data2['icn'] =  $this->request->post('course');
            if($this->request->post('courses')){
                $data1['status'] = '1' ;
            }else{
                $data1['status'] =  '0';
            }
            $data2['title'] =  $this->request->post('courset');
            db('home')->data($data2)->where(array('id'=>$id2))->update();

            $home = db('home') -> select();
            $this -> view -> assign('home',$home);
            $this -> view -> assign('haveLeft',false);


            $id3 = $this->request->post('lecturerid');
            $data3['icn'] =  $this->request->post('lecturer');
            if($this->request->post('lecturers')){
                $data1['status'] = '1' ;
            }else{
                $data1['status'] =  '0';
            }
            $data3['title'] =  $this->request->post('lecturert');
            db('home')->data($data3)->where(array('id'=>$id3))->update();

            $id4 = $this->request->post('datumid');
            $data4['icn'] =  $this->request->post('datum');
            if($this->request->post('datums')){
                $data1['status'] = '1' ;
            }else{
                $data1['status'] =  '0';
            }
            $data4['title'] =  $this->request->post('datumt');
            db('home')->data($data4)->where(array('id'=>$id4))->update();

           // return json(array('status'=>1));



        }else{
            $home = db('home') -> select();
            $this -> view -> assign('home',$home);
            $this -> view -> assign('haveLeft',false);
            return $this -> view -> fetch();

        }
    }





    //审核管理
    public function auditing()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post();
            db('auditing')->data($data)->where('id', 1)->update();

        } else {
            $auditing = db('auditing')->find();
            $this->view->assign('auditing', $auditing);
            $this->view->assign('haveLeft', false);
            return $this->view->fetch();
        }

    }

    //题目顺序
    public function question()
    {
        if ($this->request->isAjax()) {
            $sort['sort'] = $this->request->post('sort');
            $id = $this->request->post('id');
            db('question_sort')->data($sort)->where('id', $id)->update();


        } else {
            $question = db('question_sort')->order('sort desc')->select();
            $this->view->assign('question', $question);
            $this->view->assign('haveLeft', false);
            return $this->view->fetch();
        }

    }


    //排行榜管理
    public function rank()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post();
            db('rank')->data($data)->where('id', 1)->update();

        } else {
            $rank = db('rank')->find();
            $this->view->assign('rank', $rank);
            $this->view->assign('haveLeft', false);
            return $this->view->fetch();
        }

    }


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


    //处理图片上传
    public function uploadPic($pic_name)
    {
        $file = request()->file($pic_name);

        //判断是否接收到图片
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
            echo json_encode(array('state' => 1, 'path' => date('Ymd') . '/' . $info->getFilename()));

        } else {
            echo json_encode(array('state' => 0, 'reason' => '图片name值错误'));
        }
    }

}

?>
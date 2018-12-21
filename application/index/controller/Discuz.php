<?php
namespace app\index\controller;

use think\Controller;
use think\Config;
use think\Session;

class Discuz extends controller
{
    use \app\admin\controller\Base;

    /**
     * 展示所有讨论列表
     * @author
     */
	 public function __construct(){
        parent::__construct();
        $this -> view -> assign('base','5');
         if(!isset($_SESSION['think']['userid'])){
             $this->redirect('index/user/login');
         }
    }
    public function index()
    {
        $listRows = $this->request->param('numPerPage') ?: Config::get("paginate.list_rows");
        $list = db('discuz')->alias('d')->join('member u', 'd.userid = u.id')
            ->field(array('d.id', 'd.title', 'u.realname', 'd.status', 'd.isfirst', 'd.viewnum', 'd.addtime'))->order('d.id desc')
            ->paginate(10, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());
        return $this->view->fetch();
    }

    /**
     * 讨论详情页
     * @author
     */
    public function detail()
    {
        $id = $this->request->param('id');
        $res = db('discuz_feedback')
            ->alias('a')
            ->join('user b', 'a.userid = b.id','left')
            ->where(array('a.did' => $id))
            ->field('a.id,a.content,a.addtime,b.username,a.replycontent,a.replytime')
            ->select();
        $count = count($res);
        $detail = db('discuz')
            ->alias('d')
            ->join('user u', 'd.userid = u.id','left')
            ->field(array('d.id', 'd.title', 'u.username', 'u.realname', 'd.summary', 'd.addtime', 'd.content', 'd.status', 'd.isfirst', 'd.viewnum'))
            ->where('d.id=' . $id)
            ->find();
        db('discuz')->where(array('id' => $id))->setInc('viewnum', 1);
        $detail['res'] = $res;
        $detail['count'] = $count;
        $this->view->assign('detail', $detail);
        return $this->view->fetch();
    }

    /**
     * 回复当前主题
     * @author
     */
    public function feedBack()
    {
        if ($this->request->isAjax()) {//回复
            $data['replycontent'] =  $this->request->param('content');
            $id =  $this->request->param('id');
            if($data['replycontent']==''){
                return json(array('state'=>2,'err'=>'回复不能为空'));
            }
            $data['replytime'] = time();
//            return json(array('data'=>$data));
            $res = db('discuz_feedback')->where(array('id'=>$id))->data($data)->update();
            if($res){
                return json(array('state'=>1,'succ'=>'回复成功！'));
            }else{
                return json(array('state'=>0,'err'=>'网络错误,请重试！'));

            }
        } else {//展示页面
            $id = $this->request->param('id');
            $this->view->assign('id', $id);
            $this->view->assign('haveFooter', false);
            $this->view->assign('haveHeader', false);
            return $this->view->fetch();
        }
    }
    public  function reply(){
        $data =  $this->request->param();
        if($data['content'] == ''){
            return json(array('state'=>2,'err'=>'评论不能为空'));
        }
        unset($data['_']);
        $data['userid'] = session('userid');
        $data['addtime'] = time();
        $res = db('discuz_feedback')->data($data)->insert();
        if($res){
            return json(array('state'=>1,'succ'=>'评论成功！'));
        }else{
            return json(array('state'=>0,'err'=>'网络错误,请重试！'));

        }
    }
    /**
     * 添加讨论
     * @author
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            $data['depid'] = $this->request->post('pid');
            $data['title'] = $this->request->post('title');
            $data['content'] = $this->request->post('content');
            $data['userid'] = Session::get('userid');
            $data['addtime'] = time();
            $data['summary'] = $this->request->post('summary');
            $data['status'] = 1;
//
            db('discuz')->data($data)->insert();
            return json(array('data' => $data));
        } else {
            return $this->view->fetch();
        }
    }

    /**
     * 添加讨论
     * @author
     */
    public function edit()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->post('id');
            $data['depid'] = $this->request->post('pid');
            $data['title'] = $this->request->post('title');
            $data['content'] = $this->request->post('content');
            $data['userid'] = Session::get('userid');
            $data['addtime'] = time();
            $data['summary'] = $this->request->post('summary');
            $data['status'] = 1;
            db('discuz')->data($data)->where(array('id' => $id))->update();

        } else {
            $id = $this->request->param('id');
            $detail = db('discuz')
                ->alias('d')
                ->join('user u', 'd.userid = u.id')
                ->field(array('d.id', 'd.title', 'u.username', 'u.realname', 'd.status', 'd.isfirst', 'd.content', 'd.summary', 'd.addtime'))
                ->where(array('d.id' => $id))
                ->find();
            $this->view->assign('detail', $detail);
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

}

?>
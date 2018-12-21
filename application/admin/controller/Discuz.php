<?php
namespace app\admin\controller;

use  think\Controller;
use  think\Session;
use think\Config;

class  Discuz extends Controller
{
    use \app\admin\controller\Base;
 	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    /**
     * 管理后台展示讨论区数据
     * @author
     */
    public function index()
    {
        $listRows = $this->request->param('numPerPage') ?: Config::get("paginate.list_rows");
        $list = db('discuz')
            ->alias('d')
            ->join('user u', 'd.userid = u.id')
            ->field(array('d.id', 'd.title', 'u.username', 'u.realname', 'd.addtime','d.viewnum','d.reply', 'd.isfirst', 'd.status'))
            ->order('d.id desc')
            ->paginate($listRows, false, ['query' => $this->request->get()]);
        $this->view->assign('list', $list);
        $this->view->assign("page", $list->render());
        $this->view->assign('numPerPage', $list->listRows());

        return $this->view->fetch();
    }


    public function topping(){
       $id = $this->request->param('id');
       $top = $this->request->param('isfrist');
        $data['isfirst']=$top;
        db('discuz')->where(array('id'=>$id))->data($data)->update();
    }
}

?>
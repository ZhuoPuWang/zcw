<?php
/**
 * Created by PhpStorm.
 * User: kingblanc
 * Date: 2018/8/27
 * Time: 14:53
 */
namespace app\admin\controller;
use think\Controller;
use  think\Session;
use think\Config;

class News extends Controller{
    use \app\admin\controller\Base;

    /**
     * @姚启航
     * 新闻管理首页
     */
	  	
	 	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','7');
}
    public function index(){
        //列出所有新闻（字段：标题，作者，姓名，发布时间，是否置顶）
        //注意分页处理
        $listRows = $this -> request -> param('numPerPage') ?: Config::get("paginate.list_rows");
        $list = db('news') -> alias('n') -> join('user u','n.userid = u.id','left')
            -> field(array('n.id','n.title','u.username','u.realname','n.create_time','n.isfrist','n.status')) -> order('n.id desc')
            -> paginate($listRows, false, ['query' => $this-> request -> get()]);
        $this-> view -> assign('list', $list);
        $this-> view -> assign("page", $list -> render());
        $this-> view -> assign('numPerPage', $list -> listRows());
        return $this -> view -> fetch();

    }

    /**
     * @姚启航
     * 修改新闻
     */
    public function edit(){

        if($this -> request -> isAjax()){//提交
            $data['title'] = $this-> request ->post('title');
            $data['content'] = $this -> request ->post('content');
            $id = $this -> request -> post('ids');
            $data['create_time'] = time();
            $data['userid'] = Session::get('userid');
            db('news') -> where(array('id'=>$id)) -> data($data) -> update();

        }else{//展示
            $id = $this -> request -> param('id');
            $news = db('news') -> where(array('id'=> $id)) -> find();
            $this-> view -> assign('news',$news);

            return $this -> view -> fetch();
        }
    }

    /**
     * @姚启航
     * 添加新闻
     */
    public function  add(){
        if($this -> request -> isAjax()){//提交
            $data = $this-> request -> post();
            $data['create_time'] = time();
            $data['userid'] = Session::get('userid');
            db('news') -> data($data) -> insert();
			
        }else{//展示
            return $this -> view -> fetch();
        }
    }




    /**
     * @姚启航
     * 置顶
     */
    public function  topping(){
        $data['isfrist'] = $this-> request -> post('isfrist');
        $id = $this-> request -> post('id');
         db('news') ->where(array('id'=>$id)) ->data($data) ->update();
    }

}
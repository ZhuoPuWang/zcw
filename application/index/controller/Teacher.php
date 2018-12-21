<?php
/**
 * Created by PhpStorm.
 * User: kingblanc
 * Date: 2018/8/29
 * Time: 14:33
 */
namespace app\index\controller;
use  think\Controller;
use  think\Session;
use think\Config;
class  Teacher extends Controller{
    /**
     * 前台负责展示讲师信息（需要分页）
     * @author
     */
	 public function __construct(){
        parent::__construct();
        $this -> view -> assign('base','4');
             if(!isset($_SESSION['think']['userid'])){
                 $this->redirect('index/user/login');
             }
     }
    public function index(){
        $listRows = $this -> request -> param('numPerPage') ?: Config::get("paginate.list_rows");
        $list = db('teacher')
            ->alias('a')
            ->join('member b','b.id = a.uid','left')
            ->field('b.realname,a.addtime,a.id,a.aptitude,a.honor,a.experience,a.head')
            -> paginate($listRows, false, ['query' => $this-> request -> get()]);
        $this-> view -> assign('list', $list);
        $this-> view -> assign("page", $list -> render());
        $this-> view -> assign('numPerPage', $list -> listRows());
        return $this -> view -> fetch();
    }

    /**
     * 讲师详情
     * @author
     */
    public function detail(){
        //需要接收前台穿过的teacherid,然后展示相对应的讲师信息

        $id=  $this -> request -> param('id');
        $teacher = db('teacher')
            ->alias('a')
            ->join('member b','b.id = a.uid','left')
            ->join('course_teacher c','a.id = c.teacher_id','left')
            -> where(array('a.id'=>$id))
            ->field('b.realname,a.addtime,a.id,a.aptitude,a.honor,a.experience,a.head,a.intro,a.shot_inintro')
            -> find();
        $course = db('course_teacher')
            ->alias('a')
            ->join('course b','a.course_id = b.id','left')
            ->where('a.teacher_id',$id)
            ->field('b.id,b.course_type,b.course_number,b.course_title')
            ->select();
        $this-> view -> assign('teacher', $teacher);
        $this-> view -> assign('course', $course);
        return $this -> view -> fetch();
    }
}
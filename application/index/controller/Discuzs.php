<?php
    namespace  app\index\controller;
    use think\Controller;
    use think\Config;
    use think\Session;

    class Discuz extends controller{
        use \app\admin\controller\Base;
        /**
         * 展示所有讨论列表
         * @author
         */
		  	 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','5');
}
        public function index(){
            $listRows = $this -> request -> param('numPerPage') ?: Config::get("paginate.list_rows");
            $list = db('discuz') -> alias('d') -> join('user u','d.userid = u.id')
                -> field(array('d.id','d.title','u.username','u.realname','d.status','d.isfirst','d.viewnum')) -> order('d.id desc')
                -> paginate($listRows, false, ['query' => $this-> request -> get()]);
            $this-> view -> assign('list', $list);
            $this-> view -> assign("page", $list -> render());
            $this-> view -> assign('numPerPage', $list -> listRows());
            return $this -> view -> fetch();
        }

        /**
         * 讨论详情页
         * @author
         */
        public function detail(){
            $id=  $this -> request -> param('id');
            $detail = db('discuz') -> alias('d') -> join('discuz_feedback f','d.id = f.did')
                -> field(array('d.id','d.title','u.username','u.realname','d.status','d.isfirst','f.content'))
                -> find();

            return $this -> view -> fetch();
        }

        /**
         * 回复当前主题
         * @author
         */
        public function  feedback(){

        }

        /**
         * 添加讨论
         * @author
         */
        public function  add(){
            if($this -> request -> isAjax()){
               // $data['pid'] = $data = $this -> request -> post('pid');
                $data['title'] = $this -> request -> post('title');
                $data['content'] = $this -> request -> post('content');
                $data['userid'] = Session::get('userid');
                //$data['content'] = time();
              //  $data['summary'] = $data = $this -> request -> post('summary');
                db('discuz') -> data($data) -> insert();


            }else{
                return $this -> view -> fetch();
            }
        }



        public function chooseParentDepart(){
            $map = array();
            if($this -> request -> param('name')){
                $map['d.name'] = ['like','%'.$this -> request -> param('name').'%'];
            }

            if($this -> request -> param('no')){
                $map['d.no'] = ['like','%'.$this -> request -> param('no').'%'];
            }

            if($this -> request -> param('id')){
                $map['d.id'] = ['neq',$this -> request -> param('id')];
            }


            $listRows = $this -> request -> param('numPerPage') ?: Config::get("paginate.list_rows");
            $list = db('depart') -> alias('d') -> join('zcw_depart b','b.id =  d.pid','LEFT') -> field(array('d.id','d.name','d.no',
                'b.name as p_name','b.no as p_no')) -> where($map) -> order('d.id desc')
                -> paginate($listRows, false, ['query' => $this->request->get()]);
            $this-> view -> assign('list', $list);
            //$this-> view -> assign("count", $list->total());
            $this-> view -> assign("page", $list->render());
            $this-> view ->assign('numPerPage', $list->listRows());
            $this -> view -> assign('haveLeft',false);
            $this -> view -> assign('haveHead',false);
            return $this -> view -> fetch();
        }

    }
?>
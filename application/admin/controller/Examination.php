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



class Examination extends Controller{

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

        if($this->request->post('name')){

            $map['a.name']  =array('like','%'.$this->request->post('name'));

        }else{

            $map ='';

        }

        $list = db('examination')
            ->alias('a')
            ->join('member b','b.id = a.createuser','left')
            ->where($map)
            ->field('a.id,a.name,b.realname,a.describe')
            -> paginate(10, false, ['query' => $this-> request -> get()]);

        $this-> view -> assign('list', $list);

        $this-> view -> assign("page", $list -> render());

        $this-> view -> assign('numPerPage', $list -> listRows());

        return $this -> view -> fetch();

    }

    public function delex(){
        $id = $this->request->param('id');
        db('examination')->where('id',$id)->delete();
        return 1;
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

    public function chooseParentDepary(){

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



    public function  add(){

        if($this -> request -> isAjax()){

            $data['number'] = $this->request->post('number');

            $data['name'] = $this->request->post('name');

            $data['describe'] = $this->request->post('describe');

            $data['credit'] = $this->request->post('credit');

            if($this->request->post('limitstart')){

                $data['limitstart'] = $this->request->post('limitstart');

            }else{

                $data['limitstart'] = time();

            }

            if($this->request->post('limitend')){

                $data['limitend'] = $this->request->post('limitend');

            }else{

                $data['limitend'] = time()+10*24*60*60;

            }

            $data['limittime'] = $this->request->post('limittime');

            $data['limitcount'] = $this->request->post('limitcount');

            $data['outtime'] = $this->request->post('outtime');

            $data['adopt'] = $this->request->post('adopt');

            $data['userobject'] = $this->request->post('userobject');

            $data['catalog'] = $this->request->post('catalog');

            $data['mode'] = $this->request->post('mode');

            $data['review'] = $this->request->post('review');

            $data['problem'] = $this->request->post('problem');

            if($this->request->post('email')){

                $data['email'] =$this->request->post('email');

            }else{

                $data['email'] ='';

            }

            if($this->request->post('wx')){

                $data['wx'] =$this->request->post('wx');

            }else{

                $data['wx'] ='';

            }

            if($this->request->post('independently')){

                $data['independently'] =$this->request->post('independently');

            }else{

                $data['independently'] ='';

            }

            if($this->request->post('examine')){

                $data['examine'] =$this->request->post('examine');

            }else{

                $data['examine'] ='';

            }

            //是否拥有证书

            if($this->request->post('certificate')){

                $data['certificate'] =$this->request->post('certificate');

                $data['certificatetype'] = $this->request->post('certificatetype');

            }else{

                $data['certificate'] ='';

                $data['certificatetype'] = '';

            }

            if($this->request->post('sequence')){

                $data['sequence'] =$this->request->post('sequence');

            }else{

                $data['sequence'] ='';

            }

            if($this->request->post('answers')){

                $data['answers'] =$this->request->post('answers');

            }else{

                $data['answers'] ='';

            }


 $data['createuser'] = Session::get('userid');


            db('examination')->data($data)->insert();

            $exid = db()->getLastInsID();
            $ins['ex_id'] = $exid;
            $ins['createtime'] = time();
            $ins['name'] = $data['name'];
            $ins['userobject'] =$data['userobject'];
            db('question')->data($ins)->insert();

            //添加日志

            $info['userid'] = Session::get('userid');

            $info['type'] = '考试管理';

            $info['cont'] = '创建'.$this->request->post('name');

            $info['time'] = time();

            db('logs') -> data($info) -> insert();

            return json_encode(array('state'=>1,'succ'=>'添加成功!!'));



        }else{

            $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';

            //查找相应的证书末班

             $cer = db('certificate')->where(array('endtime'=>array('gt',time())))->select();

            $key='';$length='10';

            for($i=0;$i<$length;$i++)

            {

                $key .= $pattern{mt_rand(0,10)};    //生成php随机数

            }

            $this->view->assign('number',$key);

            $this->view->assign('cer',$cer);

            return $this -> view -> fetch();

        }

    }



    public function  edit(){

        if($this -> request -> isAjax()){

            $id = $this->request->post('id');



            $data['number'] = $this->request->post('number');

            $data['name'] = $this->request->post('name');

            $data['describe'] = $this->request->post('describe');

            $data['credit'] = $this->request->post('credit');

            if($this->request->post('limitstart')){

                $data['limitstart'] = $this->request->post('limitstart');

            }else{

                $data['limitstart'] = time();

            }

            if($this->request->post('limitend')){

                $data['limitend'] = $this->request->post('limitend');

            }else{

                $data['limitend'] = time()+10*24*60*60;

            }

            $data['limittime'] = $this->request->post('limittime');

            $data['limitcount'] = $this->request->post('limitcount');

            $data['outtime'] = $this->request->post('outtime');

            $data['adopt'] = $this->request->post('adopt');

            $data['userobject'] = $this->request->post('userobject');

            $data['catalog'] = $this->request->post('catalog');

            $data['mode'] = $this->request->post('mode');

            $data['review'] = $this->request->post('review');

            $data['problem'] = $this->request->post('problem');

            if($this->request->post('email')){

                $data['email'] =$this->request->post('email');

            }else{

                $data['email'] ='';

            }

            if($this->request->post('wx')){

                $data['wx'] =$this->request->post('wx');

            }else{

                $data['wx'] ='';

            }

            if($this->request->post('independently')){

                $data['independently'] =$this->request->post('independently');

            }else{

                $data['independently'] ='';

            }

            if($this->request->post('examine')){

                $data['examine'] =$this->request->post('examine');

            }else{

                $data['examine'] ='';

            }

            //是否拥有证书

            if($this->request->post('certificate')){

                $data['certificate'] =$this->request->post('certificate');

                $data['certificatetime'] = $this->request->post('certificatetime');

                $data['certificatetype'] = $this->request->post('certificatetype');

            }else{

                $data['certificate'] ='';

                $data['certificatetime'] = '';

                $data['certificatetype'] = '';

            }

            if($this->request->post('sequence')){

                $data['sequence'] =$this->request->post('sequence');

            }else{

                $data['sequence'] ='';

            }

            if($this->request->post('answers')){

                $data['answers'] =$this->request->post('answers');

            }else{

                $data['answers'] ='';

            }



            db('examination')->data($data)->where('id',$id)->update();

            return json_encode(array('state'=>1,'succ'=>'添加成功!!'));



        }else{

            $id = $this->request->param('id');

            $list = db('examination')
                ->alias('a')
                ->join('depart b','a.catalog = b.id','left')
                ->join('depart c','a.userobject = c.id','left')
                ->field('a.number,a.name,a.describe,a.credit,a.limitstart,a.limitend,a.limittime,a.limitcount,a
                .outtime,a.adopt,a.userobject,a.catalog,a.mode,a.review,a.problem,a.email,a.wx,a.curriculum,a
                .independently,a.examine,a.certificate,a.certificatetime,a.certificatetype,a.sequence,a.answers,a
                .createuser,a.cour_id,b.name as catalogname,c.name as userobjectname,a.id')
                ->where('a.id',$id)
                ->find();


            $cer = db('certificate')->where(array('endtime'=>array('gt',time())))->select();

            $this->view->assign('list',$list);

            $this->view->assign('cer',$cer);

            $this->view->assign('ex_id',$id);

            return $this -> view -> fetch();

        }

    }



    public function zujuan(){



        if($this -> request -> isAjax()) {

            $data = $this->request->post();
            $da = array();
            foreach($data as $k=>$v){

                if($v != '0'){

                    $da[$k]['da'] = explode('_',$k);

                    $da[$k]['va'] = $v;

                }

            }
            $question = array();
           foreach($da as $k=>$v){

               if($v['da'][2] == 1){

                   $question[$v['da'][1]][1] = $v['va'];

               }elseif($v['da'][2] == 2){

                   $question[$v['da'][1]][2] =  $v['va'];

               }elseif($v['da'][2] == 3){

                   $question[$v['da'][1]][3] = $v['va'];

               }elseif($v['da'][2] == 4){

                   $question[$v['da'][1]][4] = $v['va'];

               }elseif($v['da'][2] == 5){

                   $question[$v['da'][1]][5] = $v['va'];

               }elseif($v['da'][2] == 0){

                   $id = $v['va'];

               }

           }



            //循环获取试卷题目

            $tt = '';

            foreach($question as $k=>$v){

                foreach($v as $k1=>$v1){

                    $ttt = db('ti')->where(array('questionid'=>$k,'type'=>$k1))->orderRaw('rand()')->limit($v1)->field('id')->select();

                    foreach($ttt as $k2=>$v2){

                        $tt = $tt.','.$v2['id'];

                    }

                }

            }

            $up['kaoti'] = $tt;


            db('question')->where(array('ex_id'=>$id))->update($up);

            return json_encode(array('state'=>1,'succ'=>'添加成功!!'));

        }else{

            $tik = db('question')->field('name,id')->select();

            $ti = db('ti')->field('type,questionid')->select();

            $list = array();

            foreach($tik as $k=>$v){

                $list[$k]['name']  = $v['name'];

                $list[$k]['id']  = $v['id'];

                $dan ='0';

                $duo ='0';

                $shifei ='0';

                $jian ='0';

                $tian ='0';


                if($ti){
                    foreach($ti as $k1=>$v1){

                        if($v1['questionid'] == $v['id']){

                            if($v1['type'] == '1' ){

                                $dan = $dan +1;

                            }elseif($v1['type'] == '2'){

                                $duo = $duo +1;

                            }elseif($v1['type'] == '3'){

                                $shifei = $shifei +1;

                            }elseif($v1['type'] == '4'){

                                $jian = $jian +1;

                            }elseif($v1['type'] == '5'){

                                $tian = $tian +1;

                            }

                        }

                        $list[$k]['dan']  = $dan;

                        $list[$k]['duo']  =$duo;

                        $list[$k]['shifei']  =$shifei;

                        $list[$k]['jian']  =$jian;

                        $list[$k]['tian']  =$tian;

                    }
                }
            }
            $ex_id = $this->request->param('id');

            $this->view->assign('ex_id',$ex_id);

            $this->view->assign('list',$list);

            return $this -> view -> fetch();

        }



    }





    public function yulan(){

        $questionid = $this->request->param('id');
        $ti = db('question')->where(array('ex_id'=>$questionid))->field('kaoti')->find();

        $ti = explode(',',$ti['kaoti']);

        $list = db('ti')->where(array('id'=>array('IN',$ti)))->select();

        $data = array();

        foreach ($list as $k=>$v){

            $data[$k] = $v;

            if($v['type'] == '1'){

                $data[$k]['question'] = json_decode($v['question']);

            }elseif($v['type'] == '2'){

                $data[$k]['answer'] = json_decode($v['answer']);

                $data[$k]['question'] = json_decode($v['question']);

            }

        }

        $this -> view -> assign('ex_id',$questionid);

        $this -> view -> assign('list',$data);

        return $this -> view ->  fetch();

    }



    public function fenpei(){

        $id = $this->request->param('id');

        $course = db('course')->where(array('ks_id'=>$id))->paginate(10, false, ['query' => $this-> request -> get()]);

        $this->view->assign('ex_id', $id);

        $this->view->assign('course', $course);

        $this-> view -> assign("page", $course -> render());

        $this-> view -> assign('numPerPage', $course -> listRows());

        return $this->view->fetch();

    }



    public function choosekc()

    {

        $id = $this->request->param('id');

        //获取课程列表

        $kc = db('course')->order('id desc')->field('id,course_number,course_title,addtime') ->paginate(10, false, ['query' => $this->request->get()]);

        $this->view->assign('kc',$kc);

        $this->view->assign('id',$id);

        return $this->view->fetch();

    }





    public function gl(){

        $data['ks_id'] = $this->request->post('id');

        $course_id = $this->request->post('cour_id');

       db('course')->data($data)->where(array('id'=>$course_id))->update();

        return '1';

    }



    public function delkc(){

        $data['ks_id'] = '';

        $course_id = $this->request->post('cour_id');

        db('course')->data($data)->where(array('id'=>$course_id))->update();

        return '1';

    }



    //阅卷

    public function yue(){

        $id = $this->request->param('id');

        $user = db('juan')->alias('a')->join('member b','a.uid = b.id')->where(array('a.ex_id'=>$id))->field('a.id,b.realname,a.addtime,b.usernumber,a.state,a.fen,a.pass')->paginate(10, false, ['query' => $this->request->get()]);



        $this-> view -> assign('list', $user);

        $this-> view -> assign("page", $user -> render());

        $this-> view -> assign('numPerPage', $user -> listRows());

        $this->view->assign('ex_id', $id);

        return $this->view->fetch();

    }



    public function yuejuan(){

        if($this -> request -> isAjax()) {

            $id = $this->request->post('id');

            $ex_id = $this->request->post('ex_id');

            $data = array();

            $num = '0';

            foreach($this->request->post() as $k=>$v){

                if(is_numeric($k)){

                    $num = $num + $v;

                }

            }

            $data['fen'] = $num;

            $data['state'] = '1';



            //判断是否达到通过分数

            $ex = db('examination')->where(array('id'=>$ex_id))->field('adopt,certificate,certificatetype')->find();

            if($data['fen'] < $ex['adopt'] ){

                $data['pass'] = '0';

            }else{

                $data['pass'] = '1';

                if($ex['certificate'] == 'on'){

                    $data['cer_id'] = $ex['certificatetype'];

                }

            }

            //更新数据

            db('juan')->data($data)->where(array('id'=>$id))->update();

            return json(array('state'=>'1'));

        }else{

            $id = $this->request->param('id');

            $ti = db('juan')->where(array('id'=>$id,'state'=>'0'))->find();



            $tii =json_decode($ti['ti']);

            foreach ($tii as $k=>$v){

                if(is_numeric($k)){

                    $da[$k] = $v;

                }

            }

            $list = array();

            foreach ($da as $k=>$v){

                $t = db('ti')->where(array('id'=>$k))->find();

                $list[$k] =$t;

                $list[$k]['da'] = $v;

            }



            foreach ($list as $k=>$v){

                $data[$k] = $v;

                if($v['type'] == '1'){

                    $data[$k]['question'] = json_decode($v['question']);

                }elseif($v['type'] == '2'){

                    $data[$k]['answer'] = json_decode($v['answer']);

                    $data[$k]['question'] = json_decode($v['question']);

                }

            }

            $this->view->assign('list',$data);

            $this->view->assign('juan_id',$ti['id']);

            $this->view->assign('ex_id',$ti['ex_id']);

            return $this->view->fetch();



        }



    }



    public function doyuejuan(){

        $id = $this->request->post('id');

        $ex_id = $this->request->post('ex_id');

        $data = array();

        $num = '0';

        foreach($this->request->post() as $k=>$v){

            if(is_numeric($k)){

                $num = $num + $v;
            }
        }
        $data['fen'] = $num;
        $data['state'] = '1';
        //判断是否达到通过分数

        $ex = db('examination')->where(array('id'=>$ex_id))->field('adopt')->find();
        if($data['fen'] < $ex['adopt'] ){
            $data['pass'] = '0';
        }else{
            $data['pass'] = '1';
        }
        //更新数据
        db('juan')->data($data)->where(array('id'=>$id))->update();
        return json(array('state'=>'1'));



    }

    public function delexamination(){
        $id = $this->request->param('id');
        db('examination')->where('id',$id)->delete();
        $this->redirect('admin/examination/index');
    }









}
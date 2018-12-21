<?php
namespace app\index\controller;

trait Base{
    //ajax成功返回
    public function ajax_success($res = 0){
        $arr = array();
        if(is_array($res)){
            $arr = $res;
            $arr['state'] = 1;
        }else if(is_string($res)){
            $arr = array('state' => 1,'data' => $res);
        }else{
            $arr = array('state' => 1);
        }
        return $arr;
    }

    //ajax失败返回
    public function ajax_error($res){
        $arr = array();
        if(is_array($res)){
            $arr = $res;
            $arr['state'] = 0;
        }else if(is_string($res)){
            $arr = array('state' => 0,'data' => $res);
        }else{
            $arr = array('state' => 0);
        }
        return $arr;
    }
}

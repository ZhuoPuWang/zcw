<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


function get_status($id,$status){
    if($status == 1){
        $url = url(request() -> controller().'/forbid','',false,true);
        return "<a href='javascript:forbid($id)' id='item_$id' dataurl='$url'>禁用</a>";
    }else{
        $url = url(request() -> controller().'/resume','',false,true);
        return "<a href='javascript:resume($id)' id='item_$id' dataurl='$url'>恢复</a>";
    }
}

function sedit($id,$status,array $list = array()){
    $html = '';
    if(count($list) > 0){
        foreach($list as $key => $val){
            if($val == 'edit'){
                $url = url(request() -> controller().'/edit',array('id' => $id),false,true);
                $html = $html."<span class='zd'><a href='$url'>修改</a></span>";
            }

            if($val == 'status'){
                $html = $html."<span class='fb'>".get_status($id,$status)."</span>";
            }

            if($val == 'delete'){
                $url = url(request() -> controller().'/delete','',false,true);
                $html = $html."<span class='sc'><a href='javascript:del($id)' id='del_$id' dataurl='$url'>删除</a></span>";
            }
        }
    }else{
        $url = url(request() -> controller().'/edit',array('id' => $id),false,true);
        $html = "<span class='zd'><a href='$url'>修改</a></span>";
        $html = $html."<span class='fb'>".get_status($id,$status)."</span>";
        $url = url(request() -> controller().'/delete','',false,true);
        $html = $html."<span class='sc'><a href='javascript:del($id)' id='del_$id' dataurl='$url'>删除</a></span>";
    }
    return $html;
}

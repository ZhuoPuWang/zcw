<?php
/**
 * Created by PhpStorm.
 * User: kingblanc
 * Date: 2018/8/29
 * Time: 15:34
 */
namespace app\index\controller;
use think\Controller;

class  Rl extends Controller{
    /**
     * 新闻列表页（注意分页和新闻的置顶）
     * @wang
     */

 public function __construct(){
    parent::__construct();
    $this -> view -> assign('base','2');
}

    public function index(){
        return  $this -> view -> fetch();
    }


}
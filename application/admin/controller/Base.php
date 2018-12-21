<?php
namespace app\admin\controller;

trait  Base{
    public function add(){
        $table = strtolower($this -> request -> controller());
        if($this -> request -> isAjax()){
            db($table) -> data($this -> request -> param()) -> insert();
            return json(['state' => 1]);
        }else{
            return $this -> view -> fetch();
        }
    }

    public function edit(){
        $table = strtolower($this -> request -> controller());
        if($this -> request -> isAjax()){
            $id =  $this -> request -> param('id');
            db($table) -> where(array('id' => $id)) -> data($this -> request -> param()) -> update();
            return  json(array('state' => 1));
        }else{
            $id = $this -> request -> param('id');
            $info = db($table) -> where(array('id' => $id)) -> find();
            $this -> view -> assign('vo',$info);
            $this -> view -> assign('id',$id);
            return $this -> view ->  fetch();
        }
    }

    public function  forbid(){
        $id =  request() -> param('id');
        $table = request() -> controller();
        db($table) -> where(array('id' => $id)) -> data(array('status' => 0)) -> update();
        return json(array('state' => 1));
    }

    public function  resume(){
        $id =  request() -> param('id');
        $table = request() -> controller();
        db($table) -> where(array('id' => $id)) -> data(array('status' => 1)) -> update();
        return json(array('state' => 1));
    }




    public function delete(){
        $id = $this -> request -> param('id');
        $table = request() -> controller();
        db($table) -> where(array('id' => $id))  -> delete();
        return json(array('state' => 1));
    }
}
?>
<?php
class MessageAction extends AdminbaseAction {

	//后台消息类
	public function add(){

		$this->display();
	} 

	public function addact(){

		$data = $_POST;
		$data['createtime']=date('Y-m-d H:i:s');
		if(M('message')->add($data)){
			$this -> success('添加短消息成功!');
		}else{
			$this -> error('添加短消息失败!');
		}
	}

	public function messagelist(){

		$messagelist = M('message')->select();
		$this -> assign('messagelist',$messagelist);
		$this->display();
	}

	public function edit(){
		$id = $_GET['id'];
		$msg = M('message')->where("id=$id")->find();
		$this -> assign('msg',$msg);
		$this->display();

	}

	public function update(){

		$data = $_POST;
		$data['updatetime'] = date('Y-m-d H:i:s');
		if(M('message')->save($data)){
			$this -> success('修改成功!');
		}else{
			$this -> error('修改失败!');
		}
	}

	public function delete(){

		$id = $_GET['id'];
		if(M('message')->where("id=$id")->delete()){
			$this -> success('删除成功!');
		}else{
			$this -> error('删除失败!');
		}
	}
}